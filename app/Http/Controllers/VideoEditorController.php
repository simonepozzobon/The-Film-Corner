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

        // Li ordino
        $start = array();
        foreach ($data as $key => $media) {
          $start[$key] = $media['start'];
        }
        array_multisort($start, SORT_ASC, $data);

        // Cartella della sessione
        $session_id = $data[0]['session'];
        $storePath = storage_path('app/public/video/sessions/'.$session_id);
        $srcPath = $storePath.'/src';

        // Se non esiste la cartella src la creo
        if (!file_exists($srcPath)) {
          $mkdir = Storage::makeDirectory('public/video/sessions/'.$session_id.'/src', 0777, true);
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



        // Se c'è qualcosa all'inizio della timeline li salvo
        if ($data[0]['start'] == 0) {
          // Li salvo nel db per debug
          foreach ($data as $key => $media) {
            $save = new Test;
            $save->session = $media['session'];
            $save->media_url = $media['file'];
            $save->start = $Video->tToS($media['start']);
            $save->duration = $Video->tToS($media['duration']);
            $save->save();
          }
        } else {
          // non c'è nulla all'inizio
          $distance = $data[0]['start'];

          foreach ($data as $key => $media) {
            $newStart = $media['start'] - $distance;
            $save = new Test;
            $save->session = $media['session'];
            $save->media_url = $media['media_url'];
            $save->start = $Video->tTos($newStart);
            $save->duration = $Video->tToS($media['duration']);
            $save->save();
          }
        }





        return response()->json(compact('data'));
    }

}
