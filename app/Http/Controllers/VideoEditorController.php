<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lanin\Laravel\ApiDebugger\Facade;
use Illuminate\Support\Facades\Storage;
use App\Test;
use App\Video;

class VideoEditorController extends Controller
{

    public function updateEditor(Request $request, Video $t)
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

        // Se non esiste la cartella src la creo
        if (!file_exists($srcPath)) {
          $mkdir = Storage::makeDirectory('public/video/sessions/'.$session_id.'/src', 0777, true);
        }

        // Se non esiste la cartella tmp la Creo
        if (!file_exists($tmpPath)) {
          $mkdir = Storage::makeDirectory('public/video/sessions/'.$session_id.'/tmp', 0777, true);
        }

        // Per ogni file nella timeline verifico se è già presente nel progetto e lo copio nella cartella src
        foreach ($data as $key => $media) {
          $mediaPath = $media['media_url'];
          $srcFilename = str_replace("video/uploads/", "", $mediaPath);
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
          $mediaPath = $media['media_url'];
          $srcFilename = str_replace("video/uploads/", "", $mediaPath);
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
          $cli = FFMPEG_LIB.' -y -i '.$srcPath.' -t '.$duration.' -c copy '.$tmpPath;
          exec($cli);

        }

        $export = storage_path('app/public/video/sessions/'.$session_id.'/tfc_video_session.mp4');

        $cli = FFMPEG_LIB.' -y -i "concat:';

        // faccio il render
        foreach ($data as $key => $media) {
          $mediaPath = $media['media_url'];
          $srcFilename = str_replace("video/uploads/", "", $mediaPath);
          $tmpFilename = $media['id'];
          $srcPath = $storePath.'/src/'.$srcFilename;
          $tmpPath = $storePath.'/tmp/'.$tmpFilename.'.mp4';
          $intermediatePath = $storePath.'/tmp/'.$tmpFilename.'.ts';

          $intermediateCli = FFMPEG_LIB.' -y -i '.$tmpPath.' -c copy -bsf:v h264_mp4toannexb -f mpegts '.$intermediatePath;
          exec($intermediateCli);

          if ($key != ($dataLenght - 1)) {
            $cli .= $intermediatePath.'|';
          } else {
            $cli .= $intermediatePath.'"';
          }
        }

        $cli .= ' -c copy -bsf:a aac_adtstoasc '.$export;
        $save = new Test;
        $save->session = $cli;
        $save->save();
        exec($cli);


        // $save = new Test;
        // $save->session = $duration;
        // $save->media_url = $media['media_url'];
        // $save->save();

        // $save = new Test;
        // $save->session = $lastElement;
        // $save->save();

        // Se c'è qualcosa all'inizio della timeline li salvo
        // if ($data[0]['start'] == 0) {
        //   // Li salvo nel db per debug
        //   foreach ($data as $key => $media) {
        //     $save = new Test;
        //     $save->session = $media['session'];
        //     $save->media_url = $media['file'];
        //     $save->start = $Video->tToS($media['start']);
        //     $save->duration = $Video->tToS($media['duration']);
        //     $save->save();
        //   }
        // } else {
        //   // non c'è nulla all'inizio
        //   $distance = $data[0]['start'];
        //
        //   foreach ($data as $key => $media) {
        //     $newStart = $media['start'] - $distance;
        //     $save = new Test;
        //     $save->session = $media['session'];
        //     $save->media_url = $media['media_url'];
        //     $save->start = $Video->tTos($newStart);
        //     $save->duration = $Video->tToS($media['duration']);
        //     $save->save();
        //   }
        // }





        return response()->json(compact('data'));
    }

}
