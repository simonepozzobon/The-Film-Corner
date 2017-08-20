<?php

namespace App\Http\Controllers\Teacher;

use App\App;
use App\AppSection;
use App\AppKeyword;
use App\AppCategory;
use App\VideoLibrary;
use App\TeacherSession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\AppsSessions\FilmSpecific\FrameCrop;
use App\AppsSessions\AppsSession;

class FilmSpecificController extends Controller
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

    return view('teacher.film-specific.path.index', compact('apps', 'app_category'));
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
       * PATH FRAMING
       *
      **/


      case 'frame-composer':
        return view('teacher.film-specific.frame-composer.index', compact('app', 'app_category'));
        break;

      case 'frame-crop':
        return view('teacher.film-specific.frame-crop.index', compact('app', 'app_category'));
        break;

      case 'juxtaposition':
        return view('teacher.film-specific.juxtaposition.index', compact('app', 'app_category'));
        break;

      // case 'frame-counter':
      //   return view('teacher.film-specific.frame-counter.index', compact('app', 'app_category'));
      //   break;

      /*
       *
       * PATH EDITING
       *
      **/

      case 'intercut-cross-cutting':
        $elements = VideoLibrary::all();
        return view('teacher.film-specific.intercut-cross-cutting.index', compact('app', 'app_category', 'elements'));
        break;

      case 'offscreen':
        return view('teacher.film-specific.offscreen.index', compact('app', 'app_category'));
        break;

      case 'attractions':
        return view('teacher.film-specific.attractions.index', compact('app', 'app_category'));
        break;

      case 'attractions-viceversa':
        $emotions = [
          0 => 'Fear',
          1 => 'Anger',
          2 => 'Joy',
          3 => 'Disgust',
          4 => 'Surprise',
          5 => 'Trust',
        ];

        $emotion = $emotions[rand(0, 5)];

        return view('teacher.film-specific.attractions-viceversa.index', compact('app', 'app_category', 'emotion'));
        break;


      /*
       *
       * PATH SOUND
       *
      **/

      case 'whats-going-on':
        return view('teacher.film-specific.whats-going-on.index', compact('app', 'app_category'));
        break;

      case 'sound-atmospheres':
        return view('teacher.film-specific.sound-atmosphere.index', compact('app', 'app_category'));
         break;

      case 'stop-and-go':
        return view('teacher.film-specific.stop-and-go.index', compact('app', 'app_category'));
        break;


      /*
       *
       * PATH CHARACTERS
       *
      **/

      case 'character-analysis':
        return view('teacher.film-specific.character-analysis.index', compact('app', 'app_category'));
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

      case 'frame-composer':
        return view('teacher.film-specific.frame-composer.open', compact('app', 'app_category', 'session'));
        break;

      case 'frame-crop':
        return view('teacher.film-specific.frame-crop.open', compact('app', 'app_category', 'session'));
        break;

      case 'juxtaposition':
        return view('teacher.film-specific.juxtaposition.open', compact('app', 'app_category', 'session'));
        break;

      // case 'frame-counter':
      //   return view('teacher.film-specific.frame-counter.open', compact('app', 'app_category', 'session'));
      //   break;

      /*
       *
       * PATH EDITING
       *
      **/

      case 'intercut-cross-cutting':
        $elements = VideoLibrary::all();
        return view('teacher.film-specific.intercut-cross-cutting.index', compact('app', 'app_category', 'elements'));
        break;

      case 'offscreen':
        return view('teacher.film-specific.offscreen.open', compact('app', 'app_category', 'session'));
        break;

      case 'attractions':
        return view('teacher.film-specific.attractions.open', compact('app', 'app_category', 'session'));
        break;

      case 'attractions-viceversa':
        return view('teacher.film-specific.attractions-viceversa.open', compact('app', 'app_category', 'session'));
        break;


      /*
       *
       * PATH SOUND
       *
      **/

      case 'whats-going-on':
        return view('teacher.film-specific.whats-going-on.open', compact('app', 'app_category', 'session'));
        break;

      case 'sound-atmospheres':
        return view('teacher.film-specific.sound-atmosphere.open', compact('app', 'app_category', 'session'));
        break;

      case 'stop-and-go':
        return view('teacher.film-specific.stop-and-go.open', compact('app', 'app_category', 'session'));
        break;


      /*
       *
       * PATH CHARACTERS
       *
      **/

      case 'character-analysis':
        return view('teacher.film-specific.character-analysis.open', compact('app', 'app_category', 'session'));
        break;
    }

  }

}
