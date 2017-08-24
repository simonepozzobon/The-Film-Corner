<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lanin\Laravel\ApiDebugger\Facade;
use Illuminate\Support\Facades\Storage;
use App\Audio;

class AudioEditorController extends Controller
{

      public function updateEditor(Request $request, Audio $t)
      {
          // inizializzo la sessione
          $Audio = new Audio;

          // definisco la library di FFMPEG
          define('FFMPEG_LIB', '/usr/local/bin/ffmpeg');
          define('SOX_LIB', '/usr/local/bin/sox');

          // Prendo i dati
          $data = $request->all();

          // Prendo l'id della sessione
          $session_id = $data[0]['session'];

          // Li ordino
          $start = array();
          foreach ($data as $key => $audio) {
            $start[$key] = $audio['start'];
          }
          array_multisort($start, SORT_ASC, $data);

          // Cartelle della sessione
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

          // Per ogni file nella timeline verifico se è già presente nel progetto e lo copio nella cartella src
          foreach ($data as $key => $audio) {
            $audioPath = $audio['media_url'];
            $srcFilename = str_replace('audio/uploads/', '', $audioPath);
            $srcPath = $storePath.'/src/'.$srcFilename;
            // Se il file non è presente allora lo copio dalla libreria
            if (!file_exists($srcPath)) {
              // qui copio i file nella cartella src
              Storage::copy('public/'.$audioPath, 'public/audio/sessions/'.$session_id.'/src/'.$srcFilename);
              $convPath = storage_path('app/public/audio/sessions/'.$session_id.'/src/'.$srcFilename);
              // lo converto allo stesso sample rate
              // sox input.mp3 output.wav channels 1 rate 8000

              // Prendo il sample Rate
              $cli = SOX_LIB.' --i -r '.$convPath;
              $sampleRate = exec($cli);

              // Prendo il numero di canali
              $cli = SOX_LIB.' --i -c '.$convPath;
              $channels = exec($cli);

              // Se il formato non corrisponde lo uniformo ai requisiti della sessione
              if ($sampleRate !== '44100') {
                $cli = SOX_LIB.' '.$convPath.' -r 44.1k -b 16 -e float -e signed -c 2 '.$convPath.' -D';
                exec($cli);
              } elseif ($channels !== '2') {
                $cli = SOX_LIB.' '.$convPath.' -b 16 -e float -e signed -c 2 '.$convPath.' -D';
                exec($cli);
              }

            }
          }

          $dataLenght = count($data);

          // Testing
          $startPos = collect();
          // Fine

          $cli = SOX_LIB.' -m ';

          // taglio i files e li salvo nella cartella tmp
          foreach ($data as $key => $audio) {
            $audioPath = $audio['media_url'];
            $srcFilename = str_replace("audio/uploads/", "", $audioPath);
            $tmpFilename = $audio['id'];
            $srcPath = $storePath.'/src/'.$srcFilename;
            $tmpPath = $storePath.'/tmp/'.$tmpFilename.'.mp3';

            // Testing
            $var = [
              'duration' => $Audio->tToS($audio['duration']),
              'start' => $Audio->tToS($audio['start']),
            ];

            $startPos->push($var);
            // Fine


            // tranne il primo
            if ($key == 0) {
              $cli .= $srcPath.' ';
            } else {
              $cli .= $srcPath.' -p pad '.$var['start'].' 0 "';

            }

            // tranne l'ultimo
            if ($key != ($dataLenght - 1)) {
              $cli .= '"|sox ';
            }
          }

          $cli .= ' '.$tmpPath;

          // Monto l'audio come sulla timeline in un file temporaneo $tmpPath
          exec($cli);
          return response([$tmpPath, $data, $cli]);


          // return response([$tmpPath, $data, $cli]);

          // file video su cui montare l'audio
          $video = storage_path($request[0]['file']);

          // Prendo la durata
          $cli = FFMPEG_LIB.' -i '.$video.' 2>&1 | grep \'Duration\' | cut -d \' \' -f 4 | sed s/,//';
          $duration =  exec($cli);
          // $duration = explode(":",$duration);
          // $duration = $duration[0]*3600 + $duration[1]*60+ round($duration[2]);

          // Taglio il file temporaneo
          $cli = SOX_LIB.' '.$tmpPath.' '.$tmpPath.' trim 0 '.$duration;

          return response([$tmpPath, $data, $cli]);
          exec($cli);



          // Creo il nuovo export
          $exportName = uniqid();
          $export = storage_path('app/public/audio/sessions/'.$session_id.'/exp/'.$exportName.'.mp4');
          $exportPublicPath = 'storage/audio/sessions/'.$session_id.'/exp/'.$exportName.'.mp4';

          // Mixo l'audio sul video;
          // ffmpeg -i v.mp4 -i a.wav -c:v copy -map 0:v:0 -map 1:a:0 new.mp4
          $cli = FFMPEG_LIB.' -i '.$video.' -i '.$tmpPath.' -c:v copy -map 0:v:0 -map 1:a:0 '.$export;

          exec($cli);

          // VECCHIO SISTEMA

          // pulisco la directory degli export
          // $success = File::deleteDirectory($expPath);

          // Creo il nuovo export
          $exportName = uniqid();
          $export = storage_path('app/public/audio/sessions/'.$session_id.'/exp/'.$exportName.'.mp4');
          $exportPublicPath = 'storage/audio/sessions/'.$session_id.'/exp/'.$exportName.'.mp4';

          $cli = FFMPEG_LIB.' -y -i "concat:';

          // faccio il render
          foreach ($data as $key => $audio) {
            $audioPath = $audio['media_url'];
            $srcFilename = str_replace("audio/uploads/", "", $audioPath);
            $tmpFilename = $audio['id'];
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

          // Save the cli on the DB for testing purposes
          $save = new Test;
          $save->session = $cli;
          $save->save();

          exec($cli);

          // return response($exportPublicPath);
          return redirect()->url('/');
      }
}
