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
          // array_multisort($start, SORT_DESC, $data);

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
                  $basename = pathinfo($srcFilename, PATHINFO_FILENAME);;
                  $outPath = storage_path('app/public/audio/sessions/'.$session_id.'/src/'.$basename.'.wav');
                  // lo converto allo stesso sample rate
                  // sox input.mp3 output.wav channels 1 rate 8000

                  // // Prendo il sample Rate
                  // $cli = SOX_LIB.' --i -r '.$convPath;
                  // $sampleRate = exec($cli);
                  //
                  // // Prendo il numero di canali
                  // $cli = SOX_LIB.' --i -c '.$convPath;
                  // $channels = exec($cli);
                  //
                  // // Se il formato non corrisponde lo uniformo ai requisiti della sessione
                  // if ($sampleRate !== '44100') {
                  //   $cli = SOX_LIB.' '.$convPath.' -r 44.1k -c 2 -C 320 '.$convPath.' -D';
                  //   exec($cli);
                  // } elseif ($channels !== '2') {
                  //   $cli = SOX_LIB.' '.$convPath.' -c 2 -C 320 '.$convPath.' -D';
                  //   exec($cli);
                  // }

                  // -r 48k  -b 16 -L -c 1

                  $cli = SOX_LIB.' '.$convPath.' -r 44.1k -b 16 -c 2 '.$outPath.' -D';
                  exec($cli);

              }
          }

          $dataLenght = count($data);

          // faccio degli step intermedi creando gli offset
          // sox awful-lyrics.wav offset-awful-lyrics.wav pad 3 0
          // Debug: $clis = collect();
          foreach ($data as $key => $audio) {
              $srcFilename = str_replace("audio/uploads/", "", $audio['media_url']);
              $tmpFilename = $audio['id'];

              $basename = pathinfo($srcFilename, PATHINFO_FILENAME);;
              $srcPath = storage_path('app/public/audio/sessions/'.$session_id.'/src/'.$basename.'.wav');

              $tmpPath = $storePath.'/tmp/offset-'.$tmpFilename.'-'.$key.'.wav';

              $delay = $Audio->tToS($audio['start']);

              $cli = SOX_LIB.' '.$srcPath. ' '.$tmpPath.' pad '.$delay. ' 0';
              exec($cli);
              // Debug: $clis->push($cli);
          }

          // Mixo i file con i delay
          // sox -m sick-beat.wav offset-awful-lyrics.wav output.wav
          $cli = SOX_LIB.' -m ';
          foreach ($data as $key => $audio) {
              $srcFilename = str_replace('audio/uploads/', '', $audio['media_url']);
              $tmpFilename = $audio['id'];
              $offsettedPath = $storePath.'/tmp/offset-'.$tmpFilename.'-'.$key.'.wav';
              $cli .= $offsettedPath.' ';
          }

          $audioExportName = uniqid();
          $audioExportPath = $storePath.'/tmp/exp-'.$audioExportName.'.wav';
          $cli .= $audioExportPath;
          exec($cli);

          // comprimo il file wav in mp3
          // ffmpeg -i input.wav -codec:a libmp3lame -qscale:a 2 output.mp3
          $compressedAudioExportPath = $storePath.'/tmp/exp-'.$audioExportName.'.mp3';
          $cli = FFMPEG_LIB.' -i '.$audioExportPath.' -codec:a libmp3lame -qscale:a 4 '.$compressedAudioExportPath;
          exec($cli);

          // Rimuovo l'audio dal video su cui montare
          // ffmpeg -i [input_file] -vcodec copy -an [output_file]

          // file video su cui montare l'audio
          $video = storage_path($request[0]['file']);
          $videoExportName = $audioExportName;
          $videoExportPath = $storePath.'/tmp/video-muted-'.$videoExportName.'.mp4';
          $cli = FFMPEG_LIB.' -i '.$video.' -vcodec copy -an '.$videoExportPath;
          exec($cli);

          // Creo l'export
          // ffmpeg -i PrintingCDs.mp4 -i AudioPrintCDs.mp3 -acodec copy -vcodec copy PrintCDs1.mp4
          $exportName = uniqid();
          $exportPath = storage_path('app/public/audio/sessions/'.$session_id.'/exp/'.$exportName.'.mp4');
          $exportPublicPath = 'storage/audio/sessions/'.$session_id.'/exp/'.$exportName.'.mp4';
          $cli = FFMPEG_LIB.' -i '.$videoExportPath.' -i '.$compressedAudioExportPath.' -c:v copy -map 0:v:0 -map 1:a:0 '.$exportPath;
          exec($cli);

          return response($exportPublicPath);
          // return redirect()->url('/');
      }
}
