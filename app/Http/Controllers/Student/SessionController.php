<?php

namespace App\Http\Controllers\Student;

use App\App;
use Validator;
use App\Video;
use App\Media;
use App\Utility;
use App\Teacher;
use App\AppSection;
use App\AppCategory;
use App\SharedSession;
use App\StudentSession;
use Illuminate\Http\Request;
use App\Notifications\ShareSession;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\AppsSessions\StudentAppSession;
use App\AppsSessions\FilmSpecific\FrameCrop;

class SessionController extends Controller
{
  public function openSessions($student_id, $app_id)
  {
    $sessions = StudentAppSession::where([
      ['student_id', '=', $student_id],
      ['app_id', '=', $app_id]
    ])->get();

    $app = App::find($app_id);

    $category = $app->category->slug;

    $data = [
      'sessions' => $sessions,
      'app' => $app,
      'category' => $category
    ];

    return response()->json($data);
  }

  public function newSession(Request $request)
  {
    $student = Auth::guard('student')->user();

    $sessions = StudentAppSession::where([
      ['app_id', '=', $request['app_id']],
      ['student_id', '=', $student->id]
    ])->get();

    foreach ($sessions as $key => $session) {
      if ($session->is_empty ==  1) {
        // return response()->json(['video' => $session->videos()->get()]);
        foreach ($session->videos()->get() as $key => $video) {
          // Cancello il video
          $videoObj = Video::findOrFail($video->id);
          $videoObj->delete();
          Storage::delete('public/'.$video->src);
          Storage::delete('public/'.$video->img);

          // Cancello il link del video con l'insegnante
          $student->videos()->detach($video);

          // Cancello il link del video con la sessione
          $session->videos()->detach($video);
        }

        foreach ($session->medias()->get() as $key => $mediaObj) {
          // Cancello l'immagine
          $media = Media::findOrFail($mediaObj->id);
          $media->delete();
          Storage::delete($mediaObj->src);
          Storage::delete($mediaObj->thumb);
          Storage::delete($mediaObj->landscape);
          Storage::delete($mediaObj->portrait);

          // Cancello il link dell'immagine con l'insegnante
          $student->medias()->detach($media);

          // Cancello il link dell'immagine con la sessione
          $session->medias()->detach($media);
        }

        $session->delete();
      }
    }

    $session = new StudentAppSession;
    $session->student_id = $student->id;
    $session->app_id = $request['app_id'];
    $session->token = uniqid();
    $session->save();

    $data = [
      'token' => $session->token
    ];

    return response()->json($data);
  }

  public function updateSession(Request $request)
  {
    // Deve avere un titolo
    $validator = Validator::make($request->all(), [
      'title' => 'required'
    ]);

    if ($validator->fails()) {
      return response()->json([
        'success' => false,
        'errors' => $validator->getMessageBag()->toArray(),
      ], 400);
    }

    define('FFMPEG_LIB', '/usr/local/bin/ffmpeg');
    define('SOX_LIB', '/usr/local/bin/sox');

    $utility = new Utility;

    // se la validazione funziona allora aggiorno la sessione
    $session = StudentAppSession::where('token', '=', $request['token'])->first();
    $session->is_empty = 0;
    $session->title = $request['title'];

    $app = $session->app()->first();
    $app_category = $app->category()->first();
    $app_section = $app_category->section()->first();

    $path = base_path('storage/app/public/apps/frame-crop');

    switch ($request['app_id']) {

      // Film Specific - Framing - App 1 - Frame Composer
      case 1:
        // Save the image
        if ($request['rendered'] != null) {
          $path = base_path('storage/app/public/network/frame-composer');
          if (!file_exists($path)) {
            $mkdir = Storage::makeDirectory('public/network/frame-composer', 0777, true);
          }
          Image::make($request['rendered'])->save($path.'/'.$session->token.'.png');
          $img = '/storage/network/frame-composer/'.$session->token.'.png';
        }

        $data = [
          'json_data' => $request['canvas'],
          'rendered' => $img,
          'notes' => $request['notes']
        ];
        $session->content = json_encode($data);
        break;


      // Film Specific - Framing - App 2 - Frame Crop
      case 2:
        $path = base_path('storage/app/public/apps/frame-crop');
        if (isset($request['frames'])) {
          $frames = collect();
          foreach ($request['frames'] as $key => $newFrame) {
            if (isset($newFrame['base64'])) {
              if (strpos($newFrame['base64'], 'data:image/png;base64') !== false) {
                //Base64
                Image::make($newFrame['base64'])->save($path.'/'.$session->token.'-frame-'.$newFrame['order'].'.png', 10);
                $img = '/storage/apps/frame-crop/'.$session->token.'-frame-'.$newFrame['order'].'.png';
              } else {
                // path
                $img = $newFrame['base64'];
              }


            }

            $data = [
              'order' => $newFrame['order'],
              'description' => $newFrame['text'],
              'img' => $img
            ];
            $frames->push($data);
          }

          $data = [
            'frames' => $frames,
            'src' => $request['src']
          ];

          $session->content = json_encode($data);
        }
        break;


      // Film Specific - Framing - App 3 - types-of-images
      case 3:
        if (isset($request['notes'])) {
          $data = [
            'images' => $request['images'],
            'notes' => $request['notes']
          ];

          $session->content = json_encode($data);
        }
        break;


      // Film Specific - Editing - App 4 - Intercut Cross Cutting
      case 4:
        $data = [
          'timelines' => $request['timelines'],
          'notes' => $request['notes']
        ];

        $session->content = json_encode($data);
        break;


      // Film Specific - Editing - App 5 - Offscreen
      case 5:
        if (isset($request['notes'])) {
          $data = [
            'video' => $request['video'],
            'notes' => $request['notes']
          ];
          $session->content = json_encode($data);
        }
        break;


      // Film Specific - Editing - App 6 - Attractions
      case 6:
        if (isset($request['notes'])) {

          $data = [
            'videoL' => $request['videoL'],
            'videoR' => $request['videoR'],
            'notes' => $request['notes']
          ];

          $session->content = json_encode($data);
        }
        break;


      // Film Specific - Sound - App 7 - What's Going On
      case 7:
        $data = [
          'notes' => $request['notes'],
          'audio' => $request['audio']
        ];

        $session->content = json_encode($data);

        break;


      // Film Specific - Sound - App 8 - Sound Atmosphere
      case 8:

        // Definisco la variabili per il render
        $video = parse_url($request['video'], PHP_URL_PATH);
        $audio = parse_url($request['audio'], PHP_URL_PATH);
        $sessionToken = $request['token'];

        // rimuovo il primo / e ottengo la path assoluta del file
        $audioPath = public_path(substr($audio, 1));
        $videoPath = public_path(substr($video, 1));

        // Definisco i percorsi
        $expPath = $utility->verifyDirAndCreate('public/apps/sound-atmosphere/'.$sessionToken.'/exp');

        // Creo i percorsi per l'export
        $exportName = uniqid();
        $exportPath = storage_path('app/public/apps/sound-atmosphere/'.$sessionToken.'/exp/'.$exportName.'.mp4');
        $exportPublicPath = 'storage/apps/sound-atmosphere/'.$sessionToken.'/exp/'.$exportName.'.mp4';

        // effettuo l'export
        $cli = FFMPEG_LIB.' -i '.$videoPath.' -i '.$audioPath.' -c:v copy -map 0:v:0 -map 1:a:0 '.$exportPath;
        exec($cli);

        // Pacchetto i dati per salvarli nella sessione
        $data = [
          'notes' => $request['notes'],
          'audio' => $request['audio'],
          'video' => $request['video'],
          'export' => $exportPublicPath
        ];

        $session->content = json_encode($data);

        break;


      // Film Specific - Sound - App 9 - Soundscapes
      case 9:

        // creo una collezione per le sorgenti
        $audioSrcs = collect();

        // creo una variabile con i volumi
        $vols = [];
        foreach (json_decode($request['audio-vol']) as $key => $vol) {
          array_push($vols, $vol);
        }

        // Per ogni sorgente audio e calcolo la durata
        $counter = 0;
        foreach (json_decode($request['audio-src']) as $key => $audio) {
          if ($audio) {
            $cleanPath = str_replace('/storage/', 'app/public/', $audio);
            $realPath = storage_path($cleanPath);
            $media = [
              'id' => uniqid(),
              'key' => $key,
              'src' => $realPath,
              'vol' => $vols[$counter],
              'duration' => Utility::getAudioLenght($realPath)
            ];
            $audioSrcs->push($media);
          }
          $counter = $counter+1;
        }

        // determino la lungezza del video in base alla lunghezza massima delle sorgenti
        $duration = $audioSrcs->max('duration');
        $audioSrcs = $audioSrcs->transform(function($audio, $key) use($duration) {
          $audio['repeat'] = $duration / $audio['duration'];
          return $audio;
        });


        // verifo l'esitenza della cartelle per gli export e per i tmp o le creo
        // '/apps/sound/soundscapes/sessione'
        $rawExpDir = 'apps/'.$app_category->slug.'/'.$app->slug.'/'.$request['token'].'/exp';
        $absExpDir = Utility::staticVerifyDirAndCreate($rawExpDir);
        $rawTmpDir = 'apps/'.$app_category->slug.'/'.$app->slug.'/'.$request['token'].'/tmp';
        $absTmpDir = Utility::staticVerifyDirAndCreate($rawTmpDir);

        // rendo tutte le sorgenti della stessa durata
        $audioSrcs = $audioSrcs->transform(function($audio, $key) use($absTmpDir) {

            // tmp path
            $tmpPath = $absTmpDir.'/'.$audio['id'].'.wav';

            // se il file deve essere allungato e il volume è diverso da zero
            if ($audio['repeat'] != 1 && $audio['vol'] != 0) {

                // allungo il file e ne aggiusto il volume
                // sox music.mp3 foo.wav repeat 3
                // sox -v 0.9 in.wav out.wav
                $cli = SOX_LIB.' -v '.$audio['vol'].' "'.$audio['src'].'" "'.$tmpPath.'" repeat '.$audio['repeat'];
                exec($cli);

                $audio['tmp'] = $tmpPath;


            } elseif ($audio['vol'] != 0 && $audio['vol'] != 1) {

                // se non deve essere allungato, regolo il volume
                $cli = SOX_LIB.' -v '.$audio['vol'].' "'.$audio['src'].'" "'.$tmpPath.'" ';
                exec($cli);

                $audio['tmp'] = $tmpPath;

            } else {

                // se il file è al massimo volume e non deve essere allungato
                $audio['tmp'] = $audio['src'];

            }

            return $audio;

        });

        // creo un unico file audio
        // sox -m audio1.wav audio2.wav out.wav
        $audioTmpPath = $absTmpDir.'/audio.wav';

        $cli = SOX_LIB.' -m ';
        foreach ($audioSrcs as $key => $audio) {
          $cli .= '"'.$audio['tmp'].'" ';
        }
        $cli .= ' "'.$audioTmpPath.'" ';
        exec($cli);

        // comprimo il file wav in mp3
        // ffmpeg -i input.wav -codec:a libmp3lame -qscale:a 2 output.mp3
        $compressedAudioTmpPath = $absTmpDir.'/audio.mp3';
        $cli = FFMPEG_LIB.' -i '.$audioTmpPath.' -codec:a libmp3lame -qscale:a 4 '.$compressedAudioTmpPath;
        exec($cli);


        // Pulisco la path per l'immagine
        $rawImagePath = str_replace('/storage/', '', $request['image']);
        $absImagePath = storage_path('app/public/'.$rawImagePath);
        $videoTmpPath = $absTmpDir.'/video.mp4';

        // creo il video dall'immagine
        // ffmpeg -loop 1 -i image.png -c:v libx264 -t 15 -pix_fmt yuv420p -vf scale=320:240 out.mp4
        $cli = FFMPEG_LIB.' -loop 1 -i "'.$absImagePath.'" -c:v libx264 -t '.$duration.' -pix_fmt yuv420p -vf scale=640:480 "'.$videoTmpPath.'"';
        exec($cli);

        // unisco audio e video
        // ffmpeg -i PrintingCDs.mp4 -i AudioPrintCDs.mp3 -acodec copy -vcodec copy PrintCDs1.mp4
        $exportPath = $absExpDir.'/video.mp4';
        $rawExpPath = $rawExpDir.'/video.mp4';
        $cli = FFMPEG_LIB.' -i '.$videoTmpPath.' -i '.$compressedAudioTmpPath.' -c:v copy -map 0:v:0 -map 1:a:0 '.$exportPath;
        exec($cli);

        $data = [
          'exp' => $rawExpPath,
          'notes' => $request['notes'],
          'audio_src' => $request['audio-src'],
          'audio_vol' => $request['audio-vol'],
          'image' => $request['image']
        ];

        $session->content = json_encode($data);

        break;

      /*
       *
       * CREATIVE STUDIO - PADIGLIONE 2
       *
      */

      // Creative Studio - Warm Up - App 10 - Active Offscreen
      case 10:
        $data = [
          'main_video' => $request['main_video'],
          'videos' => $request['videos'],
        ];

        $session->content = json_encode($data);

        break;

      // Creative Studio - Warm Up - App 11 - Active Intercut Cross-Cutting
      case 11:
        $data = [
          'timelines' => $request['timelines'],
          'notes' => $request['notes']
        ];

        $session->content = json_encode($data);

        // $session->content = json_encode($request['timelines']);
        break;

      // Creative Studio - Warm Up - App 12 - Sound studio
      case 12:
        $data = [
          'video' => $request['video'],
          'notes' => $request['notes'],
          'timelines' => $request['timelines'],
        ];

        $session->content = json_encode($data);
        break;

      // Creative Studio - Warm Up - App 13 - Character Builder
      case 13:
        // Save the image
        if ($request['rendered'] != null) {
          $path = base_path('storage/app/public/network/character-builder');
          if (!file_exists($path)) {
            $mkdir = Storage::makeDirectory('public/network/character-builder', 0777, true);
          }
          Image::make($request['rendered'])->save($path.'/'.$session->token.'.png');
          $img = '/storage/network/character-builder/'.$session->token.'.png';
        }

        $data = [
          'json_data' => $request['canvas'],
          'rendered' => $img,
          'notes' => $request['notes']
        ];
        $session->content = json_encode($data);
        break;


      // Creative Studio - Warm Up - App 14 - Storytelling
      case 14:
        $data = [
          'notes' => $request['notes'],
          'slot_1' => $request['slot_1'],
          'slot_2' => $request['slot_2'],
          'slot_3' => $request['slot_3'],
          'slot_4' => $request['slot_4'],
        ];
        $session->content = json_encode($data);
        break;


      // Creative Studio - Warm Up - App 15 - storyboard
      case 15:
        if (isset($request['stories'])) {
          $stories = collect();
          foreach ($request['stories'] as $key => $newStory) {
            $data = [
              'order' => $newStory['order'],
              'description' => $newStory['content'],
              'img' => $newStory['img']
            ];
            $stories->push($data);
          }
          $session->content = json_encode($stories);
        }
        break;


      // Creative Studio - My Corner Contest - App 16 - Lumiere Minute
      case 16:
        $data = [
          'video' => $request['video'],
        ];
        $session->content = json_encode($data);
        break;


      // Creative Studio - My Corner Contest - App 17 - Make Your Own Film
      case 17:
        $data = [
          'video' => $request['video'],
        ];
        $session->content = json_encode($data);
        break;


      /*
       *
       * DEPRECATED
       *
      */

      // case 4:
      //   if (isset($request['markers'])) {
      //     $session->content = json_encode($request['markers']);
      //   }
      //   break;

      // Film Specific - Sound - App 8 - Stop and Go
      // case 8:
      //   $data = [
      //     'notes' => $request['notes'],
      //     'video' => $request['video']
      //   ];
      //
      //   $session->content = json_encode($data);
      //
      //   break;

      // Film Specific - Editing - App 7 - attractions-viceversa
      // case 7:
      //   if (isset($request['notes'])) {
      //
      //     $data = [
      //       'emotion' => $request['emotion'],
      //       'imgL' => $request['imgL'][0],
      //       'imgR' => $request['imgR'][0],
      //       'notes' => $request['notes']
      //     ];
      //
      //     $session->content = json_encode($data);
      //   }
      //   break;

      // // Film Specific - Framing - App 3 - Frame Counter
      // case 3:
      //   if (isset($request['markers'])) {
      //     $session->content = json_encode($request['markers']);
      //   }
      //   break;

    }

    $data = [
      'path' => $path,
      'request' => $request->all(),
      'message' => 'success',
      'frames' => $request['frames'],
      'token' => $session->token
    ];

    $session->save();

    return response()->json($data);
  }

  public function shareSession(Request $request)
  {
    // Raccolgo le informazioni necessarie per creare la notifica e condividere la sessione
    $session = StudentAppSession::where('token', '=', $request['token'])->with('student', 'app')->first();
    $student = $session->student()->first();
    $app = $session->app()->first();
    $teacher = $student->teacher()->first();

    // utilizzo il sistema di Laravel per creare una nuova notifica
    $sender = $student;
    $teacher->notify( new ShareSession($session, $sender) );

    // Redis instant notification
    // Preparo l'oggetto per la notifica da inviare a server.js
    $notification = [
      'event' => 'newSharedSession',
      'from_id' => $student->id,
      'from_type' => get_class($student),
      'to_id' => $teacher->id,
      'to_type' => get_class($teacher),
      'data' => [
          'sender' => $student,
          'session' => $session,
          'app' => $app
      ]
    ];

    // pubblico la notifica sul server Redis
    Redis::publish('notification', json_encode($notification));

    // Salvo la sessione come condivisa
    $session->teacher_shared = 1;
    $session->save();

    // Se tutto va a buon fine, creo la risposta con esito positivo
    $data = [
      'status' => 'success'
    ];

    return response()->json($data);
  }
}
