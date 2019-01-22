<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lanin\Laravel\ApiDebugger\Facade;
use Illuminate\Support\Facades\Storage;
use App\Test;
use App\Video;
use App\AppsSessions\AppsSession;
use App\AppsSessions\GuestAppSession;
use App\AppsSessions\StudentAppSession;

class VideoEditorController extends Controller
{
    public function updateEditor(Request $request) {
        // inizializzo la sessione
        $Video = new Video;

        // definisco la library di FFMPEG
        define('FFMPEG_LIB', '/usr/local/bin/ffmpeg');

        // Prendo l'id della sessione
        $session_id = $request->session;

        // Preparo le cartelle per l'export
        $paths = $this->scaffold_video($session_id);

        // ridefinisco le paths
        $storePath = $paths['store_path'];
        $srcPath = $paths['srcPath'];
        $tmpPath = $paths['tmpPath'];
        $expPath = $paths['expPath'];

        // decode timelines
        $timelines = json_decode($request->timelines);

        // sort timelines by start time
        $timelines = collect($timelines)->sortBy('start');

        // Per ogni file nella timeline verifico se è già presente nel progetto e lo copio nella cartella src
        foreach ($timelines as $key => $timeline) {
            $mediaPath = urldecode($timeline->src);
            $srcFilename = pathinfo($mediaPath, PATHINFO_FILENAME);
            $srcPath = $storePath.'/src/'.$srcFilename;
            // Se il file non è presente allora lo copio dalla libreria
            if (!file_exists($srcPath)) {
                // qui copio i file nella cartella src
                Storage::copy('public/'.$mediaPath, 'public/video/sessions/'.$session_id.'/src/'.$srcFilename);
            }
        }

        $dataLenght = $timelines->count();



        foreach ($timelines as $key => $timeline) {
            $mediaPath = urldecode($timeline->src);
            $srcFilename = pathinfo($mediaPath, PATHINFO_FILENAME);
            $tmpFilename = $timeline->id;
            $srcPath = $storePath.'/src/'.$srcFilename;
            $tmpPath = $storePath.'/tmp/'.$tmpFilename.'.mp4';

            // per ogni elemento tranne l'ultimo verifico la distanza dall'elemento successivo
            if ($key != ($dataLenght - 1)) {
                // Seleziono la chiave del prossimo elemento
                $nextKey = $key + 1;
                // la sua partenza
                $nextStart = $timelines[$nextKey]->start;
                $start = $timeline->start;
                // la sottraggo a quella precedente per avere la nuova durata
                $newDuration = $nextStart - $start;
                $duration = $timeline->duration;
                // se la nuova durata è minore dell'originale assegno la nuova durata
                if ($newDuration < $duration) {
                    $duration = $newDuration;
                }
                // Converto la durata in secondi
                $duration = $Video->tToS($duration);
            }

            // se la durata non è cambiata mantengo il file intatto
            if (!isset($duration)) {
                $duration = $Video->tToS($timeline->duration);
            }

            //ffmpeg -ss [start] -i in.mp4 -t [duration] -c copy out.mp4
            $cli = FFMPEG_LIB.' -y -i "'.$srcPath.'" -t '.$duration.' -c copy "'.$tmpPath.'"';
            exec($cli);
        }

        // pulisco la directory degli export
        // $success = File::deleteDirectory($expPath);

        // Creo il nuovo export
        $exportName = uniqid();
        $export = storage_path('app/public/video/sessions/'.$session_id.'/exp/'.$exportName.'.mp4');
        $exportPublicPath = '/storage/video/sessions/'.$session_id.'/exp/'.$exportName.'.mp4';

        $cli = FFMPEG_LIB.' -y -i "concat:';

        // faccio il render
        foreach ($timelines as $key => $timeline) {
            // $videoRawPath = parse_url($request[0]['file'], PHP_URL_PATH);
            // $cleanedVideoPath = str_replace('/storage/', '', $videoRawPath);
            // $convertSpaces = str_replace('%20', ' ', $cleanedVideoPath);

            $mediaPath = urldecode($timeline->src);
            $srcFilename = pathinfo($mediaPath, PATHINFO_FILENAME);
            $tmpFilename = $timeline->id;
            $srcPath = $storePath.'/src/'.$srcFilename;
            $tmpPath = $storePath.'/tmp/'.$tmpFilename.'.mp4';
            $intermediatePath = $storePath.'/tmp/'.$tmpFilename.'.ts';

            $intermediateCli = FFMPEG_LIB.' -y -i "'.$tmpPath.'" -c copy -bsf:v h264_mp4toannexb -f mpegts '.$intermediatePath;
            exec($intermediateCli);

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

        // Find the session relative to this video
        $session = AppsSession::where('token', '=', $session_id)->first();
        if (!$session) {
            $session = StudentAppSession::where('token', '=', $session_id)->first();
        }
        if (!$session) {
            $session = GuestAppSession::where('token', '=', $session_id)->first();
        }

        return response([
            'app' => $session->app_id,
            'export' => $exportPublicPath,
        ]);
    }

    public function scaffold_video($session_id) {
        $storePath = storage_path('app/public/video/sessions/'.$session_id);
        $srcPath = $storePath.'/src';
        $tmpPath = $storePath.'/tmp';
        $expPath = $storePath.'/exp';

        // Se non esiste la cartella src la creo
        if (!file_exists($srcPath)) {
          $mkdir = Storage::makeDirectory('public/video/sessions/'.$session_id.'/src', 0777, true);
        }

        // Se non esiste la cartella tmp la Creo
        if (!file_exists($tmpPath)) {
          $mkdir = Storage::makeDirectory('public/video/sessions/'.$session_id.'/tmp', 0777, true);
        }

        if (!file_exists($expPath)) {
          $mkdir = Storage::makeDirectory('public/video/sessions/'.$session_id.'/exp', 0777, true);
        }

        return [
            'store_path' => $storePath,
            'srcPath' => $srcPath,
            'tmpPath' => $tmpPath,
            'expPath' => $expPath,
        ];
    }

    public function _deprecated_updateEditor(Request $request, Video $t)
    {
        // inizializzo la sessione
        $Video = new Video;

        // definisco la library di FFMPEG
        define('FFMPEG_LIB', '/usr/local/bin/ffmpeg');

        // Prendo i dati
        $data = $request->all();

        // Prendo l'id della sessione
        $session_id = $data[0]['session'];

        // Li ordino
        $start = array();
        foreach ($data as $key => $media) {
          $start[$key] = $media['start'];
        }
        array_multisort($start, SORT_ASC, $data);

        // Cartelle della sessione
        $storePath = storage_path('app/public/video/sessions/'.$session_id);
        $srcPath = $storePath.'/src';
        $tmpPath = $storePath.'/tmp';
        $expPath = $storePath.'/exp';

        // Se non esiste la cartella src la creo
        if (!file_exists($srcPath)) {
          $mkdir = Storage::makeDirectory('public/video/sessions/'.$session_id.'/src', 0777, true);
        }

        // Se non esiste la cartella tmp la Creo
        if (!file_exists($tmpPath)) {
          $mkdir = Storage::makeDirectory('public/video/sessions/'.$session_id.'/tmp', 0777, true);
        }

        if (!file_exists($expPath)) {
          $mkdir = Storage::makeDirectory('public/video/sessions/'.$session_id.'/exp', 0777, true);
        }

        // Per ogni file nella timeline verifico se è già presente nel progetto e lo copio nella cartella src
        foreach ($data as $key => $media) {
          $mediaPath = urldecode($media['media_url']);
          $srcFilename = pathinfo($mediaPath, PATHINFO_FILENAME);
          $srcPath = $storePath.'/src/'.$srcFilename;
          // Se il file non è presente allora lo copio dalla libreria
          if (!file_exists($srcPath)) {
            // qui copio i file nella cartella src
            Storage::copy('public/'.$mediaPath, 'public/video/sessions/'.$session_id.'/src/'.$srcFilename);
          }
        }

        $dataLenght = count($data);

        // taglio i files e li salvo nella cartella tmp
        foreach ($data as $key => $media) {
          $mediaPath = urldecode($media['media_url']);
          $srcFilename = pathinfo($mediaPath, PATHINFO_FILENAME);
          $tmpFilename = $media['id'];
          $srcPath = $storePath.'/src/'.$srcFilename;
          $tmpPath = $storePath.'/tmp/'.$tmpFilename.'.mp4';

          // per ogni elemento tranne l'ultimo verifico la distanza dall'elemento successivo
          if ($key != ($dataLenght - 1)) {
            // Seleziono la chiave del prossimo elemento
            $nextKey = $key + 1;
            // la sua partenza
            $nextStart = $data[$nextKey]['start'];
            $start = $media['start'];
            // la sottraggo a quella precedente per avere la nuova durata
            $newDuration = $nextStart - $start;
            $duration = $media['duration'];
            // se la nuova durata è minore dell'originale assegno la nuova durata
            if ($newDuration < $duration) {
              $duration = $newDuration;
            }
            // Converto la durata in secondi
            $duration = $Video->tToS($duration);
          }

          // se la durata non è cambiata mantengo il file intatto
          if (!isset($duration)) {
            $duration = $Video->tToS($media['duration']);
          }

          //ffmpeg -ss [start] -i in.mp4 -t [duration] -c copy out.mp4
          $cli = FFMPEG_LIB.' -y -i "'.$srcPath.'" -t '.$duration.' -c copy "'.$tmpPath.'"';
          exec($cli);

        }

        // pulisco la directory degli export
        // $success = File::deleteDirectory($expPath);

        // Creo il nuovo export
        $exportName = uniqid();
        $export = storage_path('app/public/video/sessions/'.$session_id.'/exp/'.$exportName.'.mp4');
        $exportPublicPath = 'storage/video/sessions/'.$session_id.'/exp/'.$exportName.'.mp4';

        $cli = FFMPEG_LIB.' -y -i "concat:';

        // faccio il render
        foreach ($data as $key => $media) {
          // $videoRawPath = parse_url($request[0]['file'], PHP_URL_PATH);
          // $cleanedVideoPath = str_replace('/storage/', '', $videoRawPath);
          // $convertSpaces = str_replace('%20', ' ', $cleanedVideoPath);

          $mediaPath = urldecode($media['media_url']);
          $srcFilename = pathinfo($mediaPath, PATHINFO_FILENAME);
          $tmpFilename = $media['id'];
          $srcPath = $storePath.'/src/'.$srcFilename;
          $tmpPath = $storePath.'/tmp/'.$tmpFilename.'.mp4';
          $intermediatePath = $storePath.'/tmp/'.$tmpFilename.'.ts';

          $intermediateCli = FFMPEG_LIB.' -y -i "'.$tmpPath.'" -c copy -bsf:v h264_mp4toannexb -f mpegts '.$intermediatePath;
          exec($intermediateCli);

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

        // Find the session relative to this video
        $session = AppsSession::where('token', '=', $session_id)->first();
        if (!$session) {
            $session = StudentAppSession::where('token', '=', $session_id)->first();
        }
        if (!$session) {
            $session = GuestAppSession::where('token', '=', $session_id)->first();
        }

        return response([
            'app' => $session->app_id,
            'export' => $exportPublicPath,
        ]);
    }

}
