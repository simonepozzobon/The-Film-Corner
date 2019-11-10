<?php

namespace App\Http\Controllers\Api;

use App\Video;
use App\Audio;
use App\Utility;
use App\Session;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MixedEditorController extends Controller
{
    public function update_editor(Request $request)
    {
        $Video = new Video();
        $Audio = new Audio();

        define('FFMPEG_LIB', '/usr/local/bin/ffmpeg');
        define('SOX_LIB', '/usr/local/bin/sox');

        // Prendo l'id della sessione
        $token = $request->token;

        // Preparo le cartelle per l'export
        $paths = $this->scaffold_mixed($token);

        // ridefinisco le paths
        $storePath = $paths['store_path'];
        $srcPath = $paths['srcPath'];
        $tmpPath = $paths['tmpPath'];
        $expPath = $paths['expPath'];

        $clis = collect();
        $debugs = collect();

        // decode timelines
        $timelines = collect(json_decode($request->timelines));

        // divido le timelines
        $audio_trks = collect();
        $video_trks = collect();
        foreach ($timelines as $key => $timeline) {
            if (isset($timeline->type) && $timeline->type == 'audio') {
                $audio_trks->push($timeline);
            } else {
                $video_trks->push($timeline);
            }
        }

        $debug = [
            'clis' => collect(),
            'debugs' => collect(),
        ];

        $audio = false;
        $video = false;

        if ($audio_trks->count() > 0) {
            $audio = $this->create_audio($audio_trks, $paths, $token, $debug);
        }

        if ($video_trks->count() > 0) {
            $video = $this->create_video($video_trks, $paths, $token, $debug);
        }

        if ($audio && $video) {
            $export = $this->merge_audio_video($video, $audio, $paths, $token);
            return [$export];
        }

        return [
            'audio' => $audio_trks,
            'video' => $video_trks,
        ];
    }

    public function merge_audio_video($video, $audio, $paths, $token)
    {
        $compressedAudioExportPath = $audio['export'];

        $cleanedVideoPath = str_replace('/storage/', '', $video['export']);
        $videoPath = $videoPath = storage_path('app/public/'.$cleanedVideoPath);

        $clis = $video['clis'];
        $debugs = $video['debugs'];

        $storePath = $paths['store_path'];
        $srcPath = $paths['srcPath'];
        $tmpPath = $paths['tmpPath'];
        $expPath = $paths['expPath'];

        // Rimuovo l'audio dal video su cui montare
        // ffmpeg -i [input_file] -vcodec copy -an [output_file]
        $videoExportName = uniqid();
        $videoExportPath = $storePath.'/tmp/video-muted-'.$videoExportName.'.mp4';
        $cli = FFMPEG_LIB.' -i "'.$videoPath.'" -vcodec copy -an "'.$videoExportPath.'"';
        exec($cli);
        $clis->push($cli);

        // Creo l'export
        // ffmpeg -i PrintingCDs.mp4 -i AudioPrintCDs.mp3 -acodec copy -vcodec copy PrintCDs1.mp4
        $exportName = uniqid();
        $exportPath = storage_path('app/public/video/sessions/'.$token.'/exp/'.$exportName.'.mp4');
        $exportPublicPath = '/storage/video/sessions/'.$token.'/exp/'.$exportName.'.mp4';
        $cli = FFMPEG_LIB.' -i '.$videoExportPath.' -i '.$compressedAudioExportPath.' -c:v copy -map 0:v:0 -map 1:a:0 '.$exportPath;
        exec($cli);
        $clis->push($cli);

        return [
            'debugs' => $debugs,
            'clis' => $clis,
            'export' => $exportPublicPath
        ];
    }

    public function create_video($timelines, $paths, $token, $debug)
    {
        $clis = $debug['clis'];
        $debugs = $debug['debugs'];

        $storePath = $paths['store_path'];
        $srcPath = $paths['srcPath'];
        $tmpPath = $paths['tmpPath'];
        $expPath = $paths['expPath'];

        // copio i file originale nel progetto se necessario
        $check = $this->paste_original_video_to_project($timelines, $storePath, $token);

        // sort timelines by start time
        $timelines = $timelines->sortBy('start')->values();
        $timelines = $timelines->transform(function($item, $key) {
            $item->is_black = false;
            return $item;
        });

        // cerco la presenza di neri
        $blacks = $this->detect_black($timelines);

        // in caso di neri creo un'unica timeline
        $full_timeline = $timelines->merge($blacks);
        $full_timeline = $full_timeline->sortBy('start')->values();

        // conto le timeline per dopo
        $dataLenght = $full_timeline->count();

        foreach ($full_timeline as $key => $item) {
            $item = (object) $item;

            //re-imposto gli id includendo anche i neri
            $item->id = $key;

            if ($item->is_black) {
                // ffmpeg -loop 1 -i black.png -c:v libx264 -t 15 -pix_fmt yuv420p -vf scale=320:240 out.mp4
                $black_path = public_path('img/black.png');
                $tmpFilename = $item->id;
                $black_tmp_path = $storePath.'/tmp/'.$tmpFilename.'.mp4';
                $cli = FFMPEG_LIB.' -loop 1 -y -i "'.$black_path.'" -c:v libx264 -t '.$item->duration.' -pix_fmt yuv420p -vf scale=320:240 "'.$black_tmp_path.'"';
                exec($cli);
                $clis->push($cli);
                $item->src = $black_tmp_path;
            } else {
                $mediaPath = urldecode($item->src);
                $srcFilename = pathinfo($mediaPath, PATHINFO_FILENAME).'.mp4';
                $tmpFilename = $item->id;
                $srcPath = $storePath.'/src/'.$srcFilename;
                $tmpPath = $storePath.'/tmp/'.$tmpFilename.'.mp4';


                $duration = $item->duration;

                // se non è l'ultimo
                if ($key != ($dataLenght - 1)) {

                    // Seleziono la chiave del prossimo elemento
                    $next_key = $key + 1;
                    $next_start = $full_timeline[$next_key]->start;

                    $current_start = $item->start;
                    $current_length = $item->duration;
                    $current_end = $current_start + $current_length;

                    if ($current_end < $next_start) {
                        // se il prossimo elemento inizia prima che questo finisce
                        // accorcio la durata di questo
                        $duration = $next_start - $current_end;
                    }
                }

                //ffmpeg -ss [start] -i in.mp4 -t [duration] -c copy out.mp4
                if ($item->cutStart > 0) {
                    $cli = FFMPEG_LIB.' -y -ss '.$item->cutStart.' -i "'.$srcPath.'" -t '.$duration.' -c copy "'.$tmpPath.'"';
                    $clis->push($cli);
                } else {
                    $cli = FFMPEG_LIB.' -y -i "'.$srcPath.'" -t '.$duration.' -c copy "'.$tmpPath.'"';
                    $clis->push($cli);
                }
                exec($cli);
            }
        }

        // pulisco la directory degli export
        // $success = File::deleteDirectory($expPath);

        // Creo il nuovo export
        $exportName = uniqid();
        $export = storage_path('app/public/video/sessions/'.$token.'/exp/'.$exportName.'.mp4');
        $exportPublicPath = '/storage/video/sessions/'.$token.'/exp/'.$exportName.'.mp4';

        $cli = FFMPEG_LIB.' -y -i "concat:';

        // faccio il render
        foreach ($full_timeline as $key => $item) {
            // $videoRawPath = parse_url($request[0]['file'], PHP_URL_PATH);
            // $cleanedVideoPath = str_replace('/storage/', '', $videoRawPath);
            // $convertSpaces = str_replace('%20', ' ', $cleanedVideoPath);

            $mediaPath = urldecode($item->src);
            $srcFilename = pathinfo($mediaPath, PATHINFO_FILENAME);
            $tmpFilename = $item->id;
            $srcPath = $storePath.'/src/'.$srcFilename;
            $tmpPath = $storePath.'/tmp/'.$tmpFilename.'.mp4';
            $intermediatePath = $storePath.'/tmp/'.$tmpFilename.'.ts';

            $debugs->push($item);
            $intermediateCli = FFMPEG_LIB.' -y -i "'.$tmpPath.'" -c copy -bsf:v h264_mp4toannexb -f mpegts '.$intermediatePath;
            exec($intermediateCli);
            $clis->push($intermediateCli);

            if ($key != ($dataLenght - 1)) {
                $cli .= $intermediatePath.'|';
            } else {
                $cli .= $intermediatePath.'"';
            }
        }

        $cli .= ' -c copy -bsf:a aac_adtstoasc '.$export;
        exec($cli);

        $clis->push($cli);

        return [
            'export' => $exportPublicPath,
            'clis' => $clis,
            'debugs' => $debugs,
        ];
    }

    public function detect_black($timelines)
    {

        $blacks = collect();
        $dataLenght = $timelines->count();

        if ($timelines[0]->start != 0) {
            $black = new Utility();
            $black->is_black = true;
            $black->start = 0;
            $black->duration = $timelines[0]->start;
            $blacks->push($black);
        }

        foreach ($timelines as $key => $timeline) {
            // tutte tranne l'ultima
            if ($key != ($dataLenght - 1)) {
                // Seleziono la chiave del prossimo elemento
                $next_key = $key + 1;
                $next_start = $timelines[$next_key]->start;

                $current_start = $timeline->start;
                $current_length = $timeline->duration;

                $current_end = $current_start + $current_length;
                if ($current_end < $next_start) {
                    $black = new Utility();
                    $black->is_black = true;
                    $black->start = $current_end;
                    $black->duration = $next_start - $current_end;
                    $blacks->push($black);
                }

            }
        }

        return $blacks;
    }

    public function paste_original_video_to_project($timelines, $storePath, $token)
    {
        // Per ogni file nella timeline verifico se è già presente nel progetto e lo copio nella cartella src
        foreach ($timelines as $key => $timeline) {
            $mediaPath = urldecode($timeline->src);
            $srcFilename = pathinfo($mediaPath, PATHINFO_FILENAME);
            $srcExt = pathinfo($mediaPath, PATHINFO_EXTENSION);

            $srcPath = $storePath.'/src/'.$srcFilename.'.'.$srcExt;

            // Se il file non è presente allora lo copio dalla libreria
            if (!file_exists($srcPath)) {
                // qui copio i file nella cartella src
                Storage::copy('public/'.$mediaPath, 'public/video/sessions/'.$token.'/src/'.$srcFilename.'.'.$srcExt);
            }
        }
        return true;
    }

    public function create_audio($timelines, $paths, $token, $debug)
    {
        $clis = $debug['clis'];
        $debugs = $debug['debugs'];

        $storePath = $paths['store_path'];
        $srcPath = $paths['srcPath'];
        $tmpPath = $paths['tmpPath'];
        $expPath = $paths['expPath'];

        // copio i file originale nel progetto se necessario
        $check = $this->paste_original_audio_to_project($timelines, $storePath, $token);

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
            $srcPath = storage_path('app/public/video/sessions/'.$token.'/src/'.$basename.'.wav');
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

        return [
            'export' => $compressedAudioExportPath,
            'clis' => $clis,
            'debugs' => $debugs,
        ];
    }

    public function paste_original_audio_to_project($timelines, $storePath, $token)
    {
        $clis = collect();
        $debug = collect();

        foreach ($timelines as $key => $item) {
            $audioPath = urldecode($item->src);
            $srcFilename = pathinfo($audioPath, PATHINFO_FILENAME);
            $srcExt = pathinfo($audioPath, PATHINFO_EXTENSION);

            $srcPath = $storePath.'/src/'.$srcFilename;

            if ($srcExt != 'wav') {
                $srcPath = $srcPath . '.wav';
            }

            // Se il file non è presente allora lo copio dalla libreria
            if (!file_exists($srcPath)) {
                // qui copio i file nella cartella src
                $orignalFilename = $srcFilename.'.'.$srcExt;
                Storage::copy('public/'.$audioPath, 'public/video/sessions/'.$token.'/src/'.$orignalFilename);
                $convPath = storage_path('app/public/video/sessions/'.$token.'/src/'.$orignalFilename);
                $basename = $srcFilename;
                $outPath = storage_path('app/public/video/sessions/'.$token.'/src/'.$basename.'.wav');
                $cli = SOX_LIB.' '.$convPath.' -r 44.1k -b 16 -c 2 '.$outPath.' -D';
                $clis->push($cli);
                exec($cli);
            }
        }

        return [
            'clis' => $clis,
            'debug' => $debug
        ];
    }

    public function scaffold_mixed($token)
    {
        $storePath = storage_path('app/public/video/sessions/'.$token);
        $srcPath = $storePath.'/src';
        $tmpPath = $storePath.'/tmp';
        $expPath = $storePath.'/exp';

        // Se non esiste la cartella src la creo
        if (!file_exists($srcPath)) {
          $mkdir = Storage::makeDirectory('public/video/sessions/'.$token.'/src', 0777, true);
        }

        // Se non esiste la cartella tmp la Creo
        if (!file_exists($tmpPath)) {
          $mkdir = Storage::makeDirectory('public/video/sessions/'.$token.'/tmp', 0777, true);
        }

        if (!file_exists($expPath)) {
          $mkdir = Storage::makeDirectory('public/video/sessions/'.$token.'/exp', 0777, true);
        }

        return [
            'store_path' => $storePath,
            'srcPath' => $srcPath,
            'tmpPath' => $tmpPath,
            'expPath' => $expPath,
        ];
    }
}
