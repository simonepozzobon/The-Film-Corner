<?php

namespace App\Http\Controllers\Teacher;

use App\App;
use Validator;
use App\Video;
use App\Media;
use App\Utility;
use App\AppSection;
use App\AppCategory;
use App\TeacherSession;
use Illuminate\Http\Request;
use App\AppsSessions\AppsSession;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\AppsSessions\FilmSpecific\FrameCrop;

class SessionController extends Controller
{
  public function openSessions($teacher_id, $app_id)
  {
    $sessions = AppsSession::where([
      ['teacher_id', '=', $teacher_id],
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
    $teacher = Auth::guard('teacher')->user();

    $sessions = AppsSession::where([
      ['app_id', '=', $request['app_id']],
      ['teacher_id', '=', $teacher->id]
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
          $teacher->videos()->detach($video);

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
          $teacher->medias()->detach($media);

          // Cancello il link dell'immagine con la sessione
          $session->medias()->detach($media);
        }

        $session->delete();
      }
    }

    $session = new AppsSession;
    $session->teacher_id = $teacher->id;
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

    $utility = new Utility;

    // se la validazione funziona allora aggiorno la sessione
    $path = base_path('storage/app/public/apps/frame-crop');
    $session = AppsSession::where('token', '=', $request['token'])->first();
    $session->is_empty = 0;
    $session->title = $request['title'];

    switch ($request['app_id']) {

      // Film Specific - Framing - App 1 - Frame Crop
      case 1:
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
          $session->content = json_encode($frames);
        }
        break;


      // Film Specific - Framing - App 2 - Juxtaposition
      case 2:
        if (isset($request['notes'])) {
          $session->content = json_encode($request['notes']);
        }
        break;


      // Film Specific - Framing - App 3 - Frame Counter
      case 3:
        if (isset($request['markers'])) {
          $session->content = json_encode($request['markers']);
        }
        break;


      // Film Specific - Editing - App 4 - Intercut Cross Cutting
      case 4:
        if (isset($request['markers'])) {
          $session->content = json_encode($request['markers']);
        }
        break;


      // Film Specific - Editing - App 5 - Offscreen
      case 5:
        if (isset($request['notes'])) {
          $session->content = json_encode($request['notes']);
        }
        break;


      // Film Specific - Editing - App 6 - Attractions
      case 6:
        if (isset($request['notes'])) {

          $data = [
            'imgL' => $request['imgL'][0],
            'imgR' => $request['imgR'][0],
            'notes' => $request['notes']
          ];

          $session->content = json_encode($data);
        }
        break;


      // Film Specific - Editing - App 7 - attractions-viceversa
      case 7:
        if (isset($request['notes'])) {

          $data = [
            'emotion' => $request['emotion'],
            'imgL' => $request['imgL'][0],
            'imgR' => $request['imgR'][0],
            'notes' => $request['notes']
          ];

          $session->content = json_encode($data);
        }
        break;



      /*
       *
       * CREATIVE STUDIO - PADIGLIONE 2
       *
      */

      // Creative Studio - Warm Up - App 12 - Active Offscreen
      case 12:
        // $data = [''];
        // $session->content = json_encode($data);
        break;


      // Creative Studio - Warm Up - App 16 - Character Builder
      case 16:
        $data = [
          'json_data' => $request['canvas'],
          'notes' => $request['notes']
        ];
        $session->content = json_encode($data);
        break;


      // Creative Studio - Warm Up - App 17 - Storytelling
      case 17:
        $data = [
          'notes' => $request['notes'],
          'slot_1' => $request['slot_1'],
          'slot_2' => $request['slot_2'],
          'slot_3' => $request['slot_3'],
          'slot_4' => $request['slot_4'],
        ];
        $session->content = json_encode($data);
        break;


      // Creative Studio - Warm Up - App 18 - storyboard
      case 18:
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


      // Creative Studio - My Corner Contest - App 19 - Lumiere Minute
      case 19:

        $session->content = json_encode(['contest']);

        break;


      // Creative Studio - My Corner Contest - App 20 - Make Your Own Film
      case 20:

        $session->content = json_encode(['contest']);

        break;

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
}
