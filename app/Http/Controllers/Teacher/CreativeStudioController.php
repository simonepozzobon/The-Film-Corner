<?php

namespace App\Http\Controllers\Teacher;

use App\App;
use Validator;
use App\Video;
use App\Teacher;
use App\Utility;
use App\AppSection;
use App\AppKeyword;
use App\AppCategory;
use App\VideoLibrary;
use App\TeacherSession;
use Illuminate\Http\Request;
use App\AppsSessions\AppsSession;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\AppsSessions\FilmSpecific\FrameCrop;

class CreativeStudioController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth:teacher', ['except' => 'logout']);
  }

  public function index($category)
  {
    $app_category = AppCategory::where('slug', '=', $category)->with('section')->with('keywords')->first();
    $apps = App::where('app_category_id', '=', $app_category->id)->with('category')->get();

    $teacher = Auth::guard('teacher')->user();

    $colors = [
      0 => ['#f5db5e', '#e9c845'],
      1 => ['#d8ef8f', '#b7cc5e'],
      2 => ['#f4c490', '#e8a360'],
      3 => ['#d9f5fc', '#a6dbe2'],
    ];

    $counter = 0;
    foreach ($apps as $key => $app) {
      $app->colors = $colors[$counter];
      $counter++;

      if ($counter % 4 == 0) {
        $counter = 0;
      }
    }

    return view('teacher.creative-studio.path.index', compact('apps', 'app_category'));
  }

  /**
   *
   * Start a new session on the app
   *
  **/

  public function app($category, $app_slug)
  {
    $app_category = AppCategory::where('slug', '=', $category)->with('section')->first();
    $app = App::where('slug', '=', $app_slug)->with('category')->first();

    $colors = [
      0 => ['#f5db5e', '#e9c845'],
      1 => ['#d8ef8f', '#b7cc5e'],
      2 => ['#f4c490', '#e8a360'],
      3 => ['#d9f5fc', '#a6dbe2'],
    ];

    $app->colors = $colors[rand(0, 3)];

    switch ($app_slug) {
      /*
       *
       * PATH WARM UP
       *
      **/

      case 'active-offscreen':
        return view('teacher.creative-studio.active-offscreen.index', compact('app', 'app_category'));
        break;


      /*
       *
       * PATH STORY TELLING
       *
      **/

      case 'character-builder':
        return view('teacher.creative-studio.character-builder.index', compact('app', 'app_category'));
        break;

      case 'storytelling':
        return view('teacher.creative-studio.storytelling.index', compact('app', 'app_category'));
        break;
    }

  }


  /**
   *
   * Open a saved session
   *
  **/

  public function openSession($category, $app_slug, $token)
  {
    $app = App::where('slug', '=', $app_slug)->with('category')->first();
    $app_category = AppCategory::find($app->app_category_id);

    $app_session = AppsSession::where('token', '=', $token)->first();
    $session = json_decode($app_session->content);

    $colors = [
      0 => ['#f5db5e', '#e9c845'],
      1 => ['#d8ef8f', '#b7cc5e'],
      2 => ['#f4c490', '#e8a360'],
      3 => ['#d9f5fc', '#a6dbe2'],
    ];

    $app->colors = $colors[rand(0, 3)];

    switch ($app_slug) {


      /*
       *
       * PATH WARM UP
       *
      **/

      case 'active-offscreen':
        return view('teacher.creative-studio.active-offscreen.open', compact('app', 'app_category', 'app_session', 'session'));
        break;

      case 'character-builder':
        $session->json_data = htmlspecialchars_decode($session->json_data);
        return view('teacher.creative-studio.character-builder.open', compact('app', 'app_category', 'app_session', 'session'));
        break;

      case 'storytelling':
        return view('teacher.creative-studio.storytelling.open', compact('app', 'app_category', 'app_session', 'session'));
        break;

    }

  }

  public function uploadVideo($category, $app_slug, Request $request)
  {
    // manca aggiungere la sessione al form
    // manca fare una verifica della dimensione del file

    $utility = new Utility;
    $file = $request->file('media');
    $ext = $file->getClientOriginalExtension();
    $check = $utility->verifyExt($ext, ['video']);

    // verify the extension
    if ($check == false) {
      $data = [
        'msg' => 'Error, file not supported'
      ];
      return response()->json($data);
    } else {

      $teacher = Auth::guard('teacher')->user();
      $app = App::where('slug', '=', $app_slug)->with('category')->first();
      $app_category = AppCategory::find($app->app_category_id);

      $app_session = AppsSession::where('token', '=', $request->input('session'))->first();

      //Creo il nome del file
      $filename = uniqid();
      $videoStore = $utility->storeVideo($file, $filename, $ext, 'apps/'.$app_category->slug.'/'.$app->slug.'/'.$teacher->id.'/');

      $video = new Video;
      $video->img = $videoStore['img'];
      $video->src = $videoStore['src'];
      $video->save();

      // creo il link tra video e sessione
      $app_session->videos()->save($video);
      // $data = [
      //   'request' => $request->input('session'),
      //   'session' => $app_session
      // ];
      $teacher->videos()->save($video);


      $data = [
        'message' => 'success',
        'video_id' => $video->id,
        'img' => Storage::disk('local')->url($videoStore['img']),
        'src' => $videoStore['src']
      ];

      return response()->json($data);
    }


  }
}
