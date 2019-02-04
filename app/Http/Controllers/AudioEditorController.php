<?php

namespace App\Http\Controllers;

use App\Audio;
use App\Utility;
use Illuminate\Http\Request;
use Lanin\Laravel\ApiDebugger\Facade;
use Illuminate\Support\Facades\Storage;

class AudioEditorController extends Controller
{
    public function updateEditor(Request $request, Audio $t) {
        // inizializzo la sessione
        $Audio = new Audio;

        // definisco la library di FFMPEG
        define('FFMPEG_LIB', '/usr/local/bin/ffmpeg');
        define('SOX_LIB', '/usr/local/bin/sox');

        // Prendo l'id della sessione
        $session_id = $request->session;

        // Cartelle della sessione
        $storePath = storage_path('app/public/audio/sessions/'.$session_id);
        $srcPath = $storePath.'/src';
        $tmpPath = $storePath.'/tmp';
        $expPath = $storePath.'/exp';

        // Preparo le cartelle per l'export
        $this->scaffold_audio($session_id);

        $clis = collect();
        $debugs = collect();

        // decode timelines
        $timelines = collect(json_decode($request->timelines));

        // copio i file originale nel progetto se necessario
        $check = $this->paste_original_to_project($timelines, $storePath, $session_id);

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
            $srcPath = storage_path('app/public/audio/sessions/'.$session_id.'/src/'.$basename.'.wav');
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

        }

        if ($dataLenght > 1) {
            // Mixo i file con i delay
            // sox -m sick-beat.wav offset-awful-lyrics.wav output.wav
            $cli = SOX_LIB.' -m ';
            foreach ($timelines as $key => $item) {
                $audioPath = urldecode($item->src);
                $srcFilename = pathinfo($audioPath, PATHINFO_FILENAME);
                $tmpFilename = $audio->id;
                $offsettedPath = $storePath.'/tmp/offset-'.$tmpFilename.'-'.$key.'.wav';
                $cli .= $offsettedPath.' ';
            }

            $audioExportName = uniqid();
            $audioExportPath = $storePath.'/tmp/exp-'.$audioExportName.'.wav';
            $cli .= $audioExportPath;
            exec($cli);
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

        // Pulisco il percorso del file video su cui montare l'audio
        $videoRawPath = parse_url($request->video_src, PHP_URL_PATH);
        $cleanedVideoPath = str_replace('/storage/', '', $videoRawPath);
        $convertSpaces = str_replace('%20', ' ', $cleanedVideoPath);
        $videoPath = storage_path('app/public/'.$convertSpaces);

        // Rimuovo l'audio dal video su cui montare
        // ffmpeg -i [input_file] -vcodec copy -an [output_file]
        $videoExportName = $audioExportName;
        $videoExportPath = $storePath.'/tmp/video-muted-'.$videoExportName.'.mp4';
        $cli = FFMPEG_LIB.' -i "'.$videoPath.'" -vcodec copy -an "'.$videoExportPath.'"';
        exec($cli);

        // Creo l'export
        // ffmpeg -i PrintingCDs.mp4 -i AudioPrintCDs.mp3 -acodec copy -vcodec copy PrintCDs1.mp4
        $exportName = uniqid();
        $exportPath = storage_path('app/public/audio/sessions/'.$session_id.'/exp/'.$exportName.'.mp4');
        $exportPublicPath = '/storage/audio/sessions/'.$session_id.'/exp/'.$exportName.'.mp4';
        $cli = FFMPEG_LIB.' -i '.$videoExportPath.' -i '.$compressedAudioExportPath.' -c:v copy -map 0:v:0 -map 1:a:0 '.$exportPath;
        exec($cli);

        return [
            'export' => $exportPublicPath,
        ];
    }

    public function scaffold_audio($session_id) {

        $storePath = storage_path('app/public/audio/sessions/'.$session_id);
        $srcPath = $storePath.'/src';
        $tmpPath = $storePath.'/tmp';
        $expPath = $storePath.'/exp';

        // Se non esiste la cartella src la creo
        if (!file_exists($srcPath)) {
            $mkdir = Storage::makeDirectory('public/audio/sessions/'.$session_id.'/src', 0777, true);
        }

        // Se non esiste la cartella tmp la Creo
        if (!file_exists($tmpPath)) {
            $mkdir = Storage::makeDirectory('public/audio/sessions/'.$session_id.'/tmp', 0777, true);
        }

        if (!file_exists($expPath)) {
            $mkdir = Storage::makeDirectory('public/audio/sessions/'.$session_id.'/exp', 0777, true);
        }

        return true;
    }

    public function paste_original_to_project($timelines, $storePath, $session_id) {
        foreach ($timelines as $key => $item) {
            $audioPath = urldecode($item->src);
            $srcFilename = pathinfo($audioPath, PATHINFO_FILENAME);
            $srcPath = $storePath.'/src/'.$srcFilename;
            // Se il file non è presente allora lo copio dalla libreria
            if (!file_exists($srcPath)) {
                // qui copio i file nella cartella src
                Storage::copy('public/'.$audioPath, 'public/audio/sessions/'.$session_id.'/src/'.$srcFilename);
                $convPath = storage_path('app/public/audio/sessions/'.$session_id.'/src/'.$srcFilename);
                $basename = $srcFilename;
                $outPath = storage_path('app/public/audio/sessions/'.$session_id.'/src/'.$basename.'.wav');
                $cli = SOX_LIB.' '.$convPath.' -r 44.1k -b 16 -c 2 '.$outPath.' -D';
                exec($cli);
            }
        }

        return true;
    }

      public function _deprecated_updateEditor(Request $request, Audio $t)
      {
          // // inizializzo la sessione
          // $Audio = new Audio;
          //
          // // definisco la library di FFMPEG
          // define('FFMPEG_LIB', '/usr/local/bin/ffmpeg');
          // define('SOX_LIB', '/usr/local/bin/sox');
          // Prendo i dati
          // $data = $request->all();
          // Prendo l'id della sessione
          // $session_id = $data[0]['session'];
          // Li ordino
          // $start = array();
          // foreach ($data as $key => $audio) {
          //     $start[$key] = $audio['start'];
          // }
          // array_multisort($start, SORT_ASC, $data);
          // array_multisort($start, SORT_DESC, $data);
          // // Cartelle della sessione
          // $storePath = storage_path('app/public/audio/sessions/'.$session_id);
          // $srcPath = $storePath.'/src';
          // $tmpPath = $storePath.'/tmp';
          // $expPath = $storePath.'/exp';
          //
          // // Se non esiste la cartella src la creo
          // if (!file_exists($srcPath)) {
          //     $mkdir = Storage::makeDirectory('public/audio/sessions/'.$session_id.'/src', 0777, true);
          // }
          //
          // // Se non esiste la cartella tmp la Creo
          // if (!file_exists($tmpPath)) {
          //     $mkdir = Storage::makeDirectory('public/audio/sessions/'.$session_id.'/tmp', 0777, true);
          // }
          //
          // if (!file_exists($expPath)) {
          //     $mkdir = Storage::makeDirectory('public/audio/sessions/'.$session_id.'/exp', 0777, true);
          // }
          // Per ogni file nella timeline verifico se è già presente nel progetto e lo copio nella cartella src
          // foreach ($data as $key => $audio) {
          //     $audioPath = urldecode($audio['media_url']);
          //     $srcFilename = pathinfo($audioPath, PATHINFO_FILENAME);
          //     $srcPath = $storePath.'/src/'.$srcFilename;
          //     // Se il file non è presente allora lo copio dalla libreria
          //     if (!file_exists($srcPath)) {
          //         // qui copio i file nella cartella src
          //         Storage::copy('public/'.$audioPath, 'public/audio/sessions/'.$session_id.'/src/'.$srcFilename);
          //         $convPath = storage_path('app/public/audio/sessions/'.$session_id.'/src/'.$srcFilename);
          //         $basename = $srcFilename;
          //         $outPath = storage_path('app/public/audio/sessions/'.$session_id.'/src/'.$basename.'.wav');
          //         $cli = SOX_LIB.' '.$convPath.' -r 44.1k -b 16 -c 2 '.$outPath.' -D';
          //         exec($cli);
          //     }
          // }
          // $dataLenght = count($data);
          // faccio degli step intermedi creando gli offset e tagliando i files
          // sox awful-lyrics.wav offset-awful-lyrics.wav pad 3 0
          // Debug: $clis = collect();
          // foreach ($data as $key => $audio) {
          //
          //     // // Definisco le variabili
          //     // $audioPath = urldecode($audio['media_url']);
          //     // $srcFilename = pathinfo($audioPath, PATHINFO_FILENAME);
          //     // $tmpFilename = $audio['id'];
          //     // $basename = $srcFilename;
          //     //
          //     // // definisco le paths per le operazioni
          //     // $srcPath = storage_path('app/public/audio/sessions/'.$session_id.'/src/'.$basename.'.wav');
          //     // $trimmedPath = $storePath.'/tmp/trim-'.$tmpFilename.'-'.$key.'.wav';
          //     // $offsettedPath = $storePath.'/tmp/offset-'.$tmpFilename.'-'.$key.'.wav';
          //
          //     /*
          //      * Taglio l'audio
          //      */
          //
          //     // // Prendo la durata del file originale
          //     // $originalDuration = Utility::getAudioLenght($srcPath);
          //
          //     // prendo la durata del file nella timeline, in questo caso il primo e unico
          //     // $clipDurationInTicks = $request[0]['duration'];
          //     // $clipDuration = $Audio->tToS($clipDurationInTicks);
          //     //
          //     // //imposto come limite massimo di durata quello originale del file
          //     // $duration = $clipDuration;
          //     // if ($clipDuration > $originalDuration) {
          //     //   $duration = $originalDuration;
          //     // }
          //
          //     // se la durata è diversa dall'originale effetuo il taglio altrimenti no
          //     // if ($duration != $originalDuration) {
          //     //
          //     //   // taglio l'audio
          //     //   // sox input output trim <start> <duration>
          //     //   $cli = SOX_LIB.' "'.$srcPath.'" "'.$trimmedPath.'" trim 0 '.$duration;
          //     //   exec($cli);
          //     //
          //     // } else {
          //     //   // salto il passagio del taglio assegnando la sorgente alla variabile tagliata
          //     //   $trimmedPath = $srcPath;
          //     // }
          //
          //     /*
          //      * Setto la distanza dei file dall'inizio della timeline (Ritardo)
          //      */
          //
          //     // // ritardo il file
          //     // $delay = $Audio->tToS($audio['start']);
          //     // $cli = SOX_LIB.' '.$trimmedPath. ' '.$offsettedPath.' pad '.$delay. ' 0';
          //     // exec($cli);
          //
          //     // Debug: $clis->push($cli);
          // }
          // se c'è più di un file sulla timeline
          if ($dataLenght > 1) {
            // Mixo i file con i delay
            // sox -m sick-beat.wav offset-awful-lyrics.wav output.wav
            $cli = SOX_LIB.' -m ';
            foreach ($data as $key => $audio) {
                $audioPath = urldecode($audio['media_url']);
                $srcFilename = pathinfo($audioPath, PATHINFO_FILENAME);
                $tmpFilename = $audio['id'];
                $offsettedPath = $storePath.'/tmp/offset-'.$tmpFilename.'-'.$key.'.wav';
                $cli .= $offsettedPath.' ';
            }

            $audioExportName = uniqid();
            $audioExportPath = $storePath.'/tmp/exp-'.$audioExportName.'.wav';
            $cli .= $audioExportPath;
            exec($cli);

          } else {
            // Se c'è un solo file nella timeline lo salvo nella cartella degli export
            $tmpFilename = $data[0]['id'];
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

          // Pulisco il percorso del file video su cui montare l'audio
          $videoRawPath = parse_url($request[0]['file'], PHP_URL_PATH);
          $cleanedVideoPath = str_replace('/storage/', '', $videoRawPath);
          $convertSpaces = str_replace('%20', ' ', $cleanedVideoPath);
          $videoPath = storage_path('app/public/'.$convertSpaces);

          // Rimuovo l'audio dal video su cui montare
          // ffmpeg -i [input_file] -vcodec copy -an [output_file]
          $videoExportName = $audioExportName;
          $videoExportPath = $storePath.'/tmp/video-muted-'.$videoExportName.'.mp4';
          $cli = FFMPEG_LIB.' -i "'.$videoPath.'" -vcodec copy -an "'.$videoExportPath.'"';
          exec($cli);

          // Creo l'export
          // ffmpeg -i PrintingCDs.mp4 -i AudioPrintCDs.mp3 -acodec copy -vcodec copy PrintCDs1.mp4
          $exportName = uniqid();
          $exportPath = storage_path('app/public/audio/sessions/'.$session_id.'/exp/'.$exportName.'.mp4');
          $exportPublicPath = 'storage/audio/sessions/'.$session_id.'/exp/'.$exportName.'.mp4';
          $cli = FFMPEG_LIB.' -i '.$videoExportPath.' -i '.$compressedAudioExportPath.' -c:v copy -map 0:v:0 -map 1:a:0 '.$exportPath;
          exec($cli);

          return response($exportPublicPath);
      }
}
