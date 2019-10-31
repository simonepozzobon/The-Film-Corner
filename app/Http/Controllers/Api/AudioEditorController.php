<?php

namespace App\Http\Controllers\Api;

use App\Audio;
use App\Utility;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AudioEditorController extends Controller
{
    public function update_editor(Request $request, Audio $t) {
        // inizializzo la sessione
        $Audio = new Audio;

        // definisco la library di FFMPEG
        define('FFMPEG_LIB', '/usr/local/bin/ffmpeg');
        define('SOX_LIB', '/usr/local/bin/sox');

        // Prendo l'id della sessione
        $token = $request->token;

        // Cartelle della sessione
        $storePath = storage_path('app/public/audio/sessions/'.$token);
        $srcPath = $storePath.'/src';
        $tmpPath = $storePath.'/tmp';
        $expPath = $storePath.'/exp';

        // Preparo le cartelle per l'export
        $this->scaffold_audio($token);

        $clis = collect();
        $debugs = collect();

        // decode timelines
        $timelines = collect(json_decode($request->timelines));

        // copio i file originale nel progetto se necessario
        $check = $this->paste_original_to_project($timelines, $storePath, $token);

        // sort timelines by start time
        $timelines = $timelines->sortBy('start')->values();

        // conto le timeline per dopo
        $dataLenght = $timelines->count();

        foreach ($timelines as $key => $item) {
            // Definisco le variabili
            $audioPath = urldecode($item->src);
            $srcFilename = pathinfo($audioPath, PATHINFO_FILENAME);
            $tmpFilename = $item->id;
            $basename = $srcFilename;

            // definisco le paths per le operazioni
            $srcPath = storage_path('app/public/audio/sessions/'.$token.'/src/'.$basename.'.wav');
            $trimmedPath = $storePath.'/tmp/trim-'.$tmpFilename.'-'.$key.'.wav';
            $offsettedPath = $storePath.'/tmp/offset-'.$tmpFilename.'-'.$key.'.wav';

            /*
             * Taglio l'audio
             */

            // Prendo la durata del file originale
            $originalDuration = Utility::getAudioLenght($srcPath);

            //imposto come limite massimo di durata quello originale del file
            $duration = $item->duration;
            if ($duration > $originalDuration) {
                $duration = $originalDuration;
            }

            if ($duration != $originalDuration) {
                // taglio l'audio
                // sox input output trim <start> <duration>
                $cli = SOX_LIB.' "'.$srcPath.'" "'.$trimmedPath.'" trim '.$item->cutStart.' '.$duration;
                exec($cli);
                $clis->push($cli);
            } else {
              // salto il passagio del taglio assegnando la sorgente alla variabile tagliata
              $trimmedPath = $srcPath;
            }

            /*
             * Setto la distanza dei file dall'inizio della timeline (Ritardo)
             */

            // ritardo il file
            $cli = SOX_LIB.' '.$trimmedPath. ' '.$offsettedPath.' pad '.$item->start. ' 0';
            exec($cli);
            $clis->push($cli);

        }

        if ($dataLenght > 1) {
            // Mixo i file con i delay
            // sox -m sick-beat.wav offset-awful-lyrics.wav output.wav
            $cli = SOX_LIB.' -m ';
            foreach ($timelines as $key => $item) {
                $audioPath = urldecode($item->src);
                $srcFilename = pathinfo($audioPath, PATHINFO_FILENAME);
                $tmpFilename = $item->id;
                $offsettedPath = $storePath.'/tmp/offset-'.$tmpFilename.'-'.$key.'.wav';
                $cli .= $offsettedPath.' ';
            }

            $audioExportName = uniqid();
            $audioExportPath = $storePath.'/tmp/exp-'.$audioExportName.'.wav';
            $cli .= $audioExportPath;
            exec($cli);
            $clis->push($cli);
        } else {
            // Se c'è un solo file nella timeline lo salvo nella cartella degli export
            $tmpFilename = $timelines[0]->id;
            $offsettedPath = $storePath.'/tmp/offset-'.$tmpFilename.'-0.wav';

            // definisco il nome dell'export
            $audioExportName = uniqid();

            // essendo un unico file lo assegno alla variabile $audioExportPath per comprimerlo successivamente
            $audioExportPath = $offsettedPath;
        }

        // comprimo il file wav in mp3
        // ffmpeg -i input.wav -codec:a libmp3lame -qscale:a 2 output.mp3
        $compressedAudioExportPath = $storePath.'/tmp/exp-'.$audioExportName.'.mp3';
        $cli = FFMPEG_LIB.' -i '.$audioExportPath.' -codec:a libmp3lame -qscale:a 4 '.$compressedAudioExportPath;
        exec($cli);
        $clis->push($cli);

        // Pulisco il percorso del file video su cui montare l'audio
        $debugs->push($request->video);
        $videoRawPath = parse_url($request->video, PHP_URL_PATH);
        $debugs->push($videoRawPath);
        $cleanedVideoPath = str_replace('/storage/', '', $videoRawPath);
        $debugs->push($cleanedVideoPath);
        $convertSpaces = str_replace('%20', ' ', $cleanedVideoPath);
        $debugs->push($convertSpaces);
        $videoPath = storage_path('app/public/'.$convertSpaces);
        $debugs->push($videoPath);

        // Rimuovo l'audio dal video su cui montare
        // ffmpeg -i [input_file] -vcodec copy -an [output_file]
        $videoExportName = $audioExportName;
        $videoExportPath = $storePath.'/tmp/video-muted-'.$videoExportName.'.mp4';
        $cli = FFMPEG_LIB.' -i "'.$videoPath.'" -vcodec copy -an "'.$videoExportPath.'"';
        exec($cli);
        $clis->push($cli);

        // Creo l'export
        // ffmpeg -i PrintingCDs.mp4 -i AudioPrintCDs.mp3 -acodec copy -vcodec copy PrintCDs1.mp4
        $exportName = uniqid();
        $exportPath = storage_path('app/public/audio/sessions/'.$token.'/exp/'.$exportName.'.mp4');
        $exportPublicPath = '/storage/audio/sessions/'.$token.'/exp/'.$exportName.'.mp4';
        $cli = FFMPEG_LIB.' -i '.$videoExportPath.' -i '.$compressedAudioExportPath.' -c:v copy -map 0:v:0 -map 1:a:0 '.$exportPath;
        exec($cli);
        $clis->push($cli);

        return [
            'export' => $exportPublicPath,
            'clis' => $clis,
            'debugs' => $debugs,
        ];
    }

    public function scaffold_audio($token) {

        $storePath = storage_path('app/public/audio/sessions/'.$token);
        $srcPath = $storePath.'/src';
        $tmpPath = $storePath.'/tmp';
        $expPath = $storePath.'/exp';

        // Se non esiste la cartella src la creo
        if (!file_exists($srcPath)) {
            $mkdir = Storage::makeDirectory('public/audio/sessions/'.$token.'/src', 0777, true);
        }

        // Se non esiste la cartella tmp la Creo
        if (!file_exists($tmpPath)) {
            $mkdir = Storage::makeDirectory('public/audio/sessions/'.$token.'/tmp', 0777, true);
        }

        if (!file_exists($expPath)) {
            $mkdir = Storage::makeDirectory('public/audio/sessions/'.$token.'/exp', 0777, true);
        }

        return true;
    }

    public function paste_original_to_project($timelines, $storePath, $token) {
        foreach ($timelines as $key => $item) {
            $audioPath = urldecode($item->src);
            $srcFilename = pathinfo($audioPath, PATHINFO_FILENAME);
            $srcPath = $storePath.'/src/'.$srcFilename;
            // Se il file non è presente allora lo copio dalla libreria
            if (!file_exists($srcPath)) {
                // qui copio i file nella cartella src
                Storage::copy('public/'.$audioPath, 'public/audio/sessions/'.$token.'/src/'.$srcFilename);
                $convPath = storage_path('app/public/audio/sessions/'.$token.'/src/'.$srcFilename);
                $basename = $srcFilename;
                $outPath = storage_path('app/public/audio/sessions/'.$token.'/src/'.$basename.'.wav');
                $cli = SOX_LIB.' '.$convPath.' -r 44.1k -b 16 -c 2 '.$outPath.' -D';
                exec($cli);
            }
        }

        return true;
    }
}
