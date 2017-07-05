<?php

namespace App\Http\Controllers\Teacher;

use App\App;
use App\AppSection;
use App\AppCategory;
use App\TeacherSession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\AppsSessions\FilmSpecific\FrameCrop;
use App\AppsSessions\AppsSession;

class SessionController extends Controller
{
  public function openSessions($teacher_id, $app_id)
  {
    // $sessions = TeacherSession::where([
    //   ['teacher_id', '=', $teacher_id],
    //   ['app_id', '=', $app_id]
    // ])->get();

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
    $teacher_id = Auth::guard('teacher')->Id();

    $sessions = TeacherSession::where([
      ['app_id', '=', $request['app_id']],
      ['teacher_id', '=', $teacher_id]
    ])->get();

    foreach ($sessions as $key => $session) {
      if ($session->empty == 1) {
        $session->delete();
      }
    }

    $session = new TeacherSession;
    $session->teacher_id = $teacher_id;
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

    // Aggiorno la sessione
    $session = TeacherSession::where('token', '=', $request['token'])->first();
    $session->empty = 0;
    $session->title = $request['title'];
    $session->save();
    $path = base_path('storage/app/public/apps/frame-crop');

    // itero all'interno di ogni frame che arriva dall'app
    if (isset($request['frames'])) {

      $frames = FrameCrop::where('token', '=', $session->token)->get();

      // se non ci sono già frame in questa sessione allora li inserisco
      if ($frames->count() == 0) {

        // Salvo i nuovi frames
        foreach ($request['frames'] as $key => $newFrame) {
          $frame = new FrameCrop;
          $frame->token = $session->token;
          $frame->order = $newFrame['order'];
          $frame->description = $newFrame['text'];

          // converto l'immagine
          if (isset($newFram['base64'])) {
            $img = Image::make($newFrame['base64'])->save($path.'/'.$session->token.'-frame-'.$newFrame['order'].'.png', 10);
            $frame->img = Storage::disk('local')->url('apps/frame-crop').'/'.$session->token.'-frame-'.$newFrame['order'].'.png';
          }

          $frame->save();
        }

      } else {

        // Elimino i vecchi
        foreach ($frames as $key => $frame) {
          Storage::delete($frame->img);
          $frame->delete();
        }

        // Salvo i nuovi frames
        foreach ($request['frames'] as $key => $newFrame) {
          $frame = new FrameCrop;
          $frame->token = $session->token;
          $frame->order = $newFrame['order'];
          $frame->description = $newFrame['text'];

          // converto l'immagine
          if (isset($newFram['base64'])) {
            $img = Image::make($newFrame['base64'])->save($path.'/'.$session->token.'-frame-'.$newFrame['order'].'.png', 10);
            $frame->img = Storage::disk('local')->url('apps/frame-crop').'/'.$session->token.'-frame-'.$newFrame['order'].'.png';
          }


          $frame->save();
        }

      }

    }

    $data = [
      'path' => $path,
      'request' => $request->all(),
      'message' => 'success',
      'frames' => $request['frames'],
      'token' => $session->token
    ];

    return response()->json($data);
  }
}
