<?php

namespace App\Http\Controllers\Api;

use App\Video;
use App\Utility;
use App\Session;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class VideoEditorController extends Controller
{
    public function update_editor(Request $request)
    {
        // inizializzo la sessione
        $Video = new Video();

        // definisco la library di FFMPEG
        define('FFMPEG_LIB', '/usr/local/bin/ffmpeg');

        // Prendo l'id della sessione
        $token = $request->token;

        // Preparo le cartelle per l'export
        $paths = $this->scaffold_video($token);

        // ridefinisco le paths
        $storePath = $paths['store_path'];
        $srcPath = $paths['srcPath'];
        $tmpPath = $paths['tmpPath'];
        $expPath = $paths['expPath'];

        $clis = collect();
        $debugs = collect();

        // decode timelines
        $timelines = collect(json_decode($request->timelines));

        // copio i file originale nel progetto se necessario
        $check = $this->paste_original_to_project($timelines, $storePath, $token);

        // sort timelines by start time
        $timelines = $timelines->sortBy('start')->values();
        $timelines = $timelines->transform(function ($item, $key) {
            $item->is_black = false;
            $item->duration = $item->duration / 10;
            $item->cutEnd = $item->cutEnd / 10;
            $item->cutStart = $item->cutStart / 10;
            $item->originalDuration = $item->originalDuration / 10;
            $item->start = $item->start / 10;
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
                $srcFilename = pathinfo($mediaPath, PATHINFO_FILENAME);
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

        // Save the cli on the DB for testing purposes
        // $save = new Test;
        // $save->session = $cli;
        // $save->save();

        exec($cli);
        $clis->push($cli);

        // Find the session relative to this video
        $session = Session::where('token', '=', $token)->first();

        return response([
            'session' => $session->app_id,
            'export' => $exportPublicPath,
            'clis' => $clis,
            'debugs' => $debugs,
        ]);
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

    public function scaffold_video($token)
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

    public function paste_original_to_project($timelines, $storePath, $token)
    {
        // Per ogni file nella timeline verifico se è già presente nel progetto e lo copio nella cartella src
        foreach ($timelines as $key => $timeline) {
            $mediaPath = urldecode($timeline->src);
            $srcFilename = pathinfo($mediaPath, PATHINFO_FILENAME);
            $srcPath = $storePath.'/src/'.$srcFilename;
            // Se il file non è presente allora lo copio dalla libreria
            if (!file_exists($srcPath)) {
                // qui copio i file nella cartella src
                Storage::copy('public/'.$mediaPath, 'public/video/sessions/'.$token.'/src/'.$srcFilename);
            }
        }
        return true;
    }
}
