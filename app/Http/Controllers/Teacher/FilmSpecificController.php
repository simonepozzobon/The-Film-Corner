<?php

namespace App\Http\Controllers\Teacher;

use App\App;
use App\AppSection;
use App\AppKeyword;
use App\AppCategory;
use App\VideoLibrary;
use App\TeacherSession;
use Illuminate\Http\Request;
use App\AppsSessions\AppsSession;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\AppsSessions\StudentAppSession;
use App\AppsSessions\FilmSpecific\FrameCrop;

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
    $activities = Activity::where('description', '=', 'visited')->causedBy($teacher)->forSubject($app_category)->get();

    if ($activities->count() == 0) {
      activity()
        ->causedBy($teacher)
        ->performedOn($app_category)
        ->withProperties('visited', true)
        ->log('visited');
    } else {
      $visited = true;
    }

    $colors = [
      'yellow', 'blue', 'orange', 'green'
    ];

    $counter = 0;
    foreach ($apps as $key => $app) {
      $app->colors = $colors[$counter];
      $counter++;
      if ($counter % 4 == 0) {
        $counter = 0;
      }
    }

    // calcolo il numero di sessioni
    $sessions = $teacher->sessions()->get();
    foreach ($apps as $key => $app) {
      $filtered = $sessions->filter(function($session, $key) use ($app) {
        return $session->app_id == $app->id;
      })->all();
      count($filtered) < 5 ? $app->available = true : $app->available = false;
    }


    return view('teacher.film-specific.path.index', compact('apps', 'app_category', 'visited'));
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
        $images = $app->medias()->get();
        $images = $images->filter(function ($img, $key) {
            return $img->category_id == 2;
        });
        $images->all();
        return view('teacher.film-specific.frame-composer.index', compact('app', 'app_category', 'images'));
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

      // case 'parallel-action':
      case 'parallel-action':
        $elements = VideoLibrary::all();
        return view('teacher.film-specific.parallel-action.index', compact('app', 'app_category', 'elements'));
        break;

      case 'offscreen':
        return view('teacher.film-specific.offscreen.index', compact('app', 'app_category'));
        break;

      case 'attractions':
        return view('teacher.film-specific.attractions.index', compact('app', 'app_category'));
        break;

      // case 'attractions-viceversa':
      //   $emotions = [
      //     0 => 'Fear',
      //     1 => 'Anger',
      //     2 => 'Joy',
      //     3 => 'Disgust',
      //     4 => 'Surprise',
      //     5 => 'Trust',
      //   ];
      //
      //   $emotion = $emotions[rand(0, 5)];
      //
      //   return view('teacher.film-specific.attractions-viceversa.index', compact('app', 'app_category', 'emotion'));
      //   break;


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

      case 'soundscapes':
        return view('teacher.film-specific.soundscapes.index', compact('app', 'app_category'));
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

    $is_student = false;
    if ($app_session == null) {
      // Student Session
      $app_session = StudentAppSession::where('token', '=', $token)->first();
      $is_student = true;
    }

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
        $images = $app->medias()->get();
        $images = $images->filter(function ($img, $key) {
            return $img->category_id == 2;
        });
        $images->all();
        return view('teacher.film-specific.frame-composer.open', compact('app', 'app_category', 'session', 'is_student', 'images'));
        break;

      case 'frame-crop':
        return view('teacher.film-specific.frame-crop.open', compact('app', 'app_category', 'session', 'is_student'));
        break;

      case 'juxtaposition':
        return view('teacher.film-specific.juxtaposition.open', compact('app', 'app_category', 'session', 'is_student'));
        break;

      // case 'frame-counter':
      //   return view('teacher.film-specific.frame-counter.open', compact('app', 'app_category', 'session', 'is_student'));
      //   break;

      /*
       *
       * PATH EDITING
       *
      **/

      case 'parallel-action':
        $elements = VideoLibrary::all();
        $session = json_encode($session);
        return view('teacher.film-specific.parallel-action.open', compact('app', 'app_category', 'elements', 'session', 'token', 'is_student'));
        break;

      case 'offscreen':
        return view('teacher.film-specific.offscreen.open', compact('app', 'app_category', 'session', 'is_student'));
        break;

      case 'attractions':
        return view('teacher.film-specific.attractions.open', compact('app', 'app_category', 'session', 'is_student'));
        break;

      case 'attractions-viceversa':
        return view('teacher.film-specific.attractions-viceversa.open', compact('app', 'app_category', 'session', 'is_student'));
        break;


      /*
       *
       * PATH SOUND
       *
      **/

      case 'whats-going-on':
        return view('teacher.film-specific.whats-going-on.open', compact('app', 'app_category', 'session', 'is_student'));
        break;

      case 'sound-atmospheres':
        return view('teacher.film-specific.sound-atmosphere.open', compact('app', 'app_category', 'session', 'is_student'));
        break;

      case 'soundscapes':
        return view('teacher.film-specific.soundscapes.open', compact('app', 'app_category', 'session', 'is_student'));
        break;

      case 'stop-and-go':
        return view('teacher.film-specific.stop-and-go.open', compact('app', 'app_category', 'session', 'is_student'));
        break;


      /*
       *
       * PATH CHARACTERS
       *
      **/

      case 'character-analysis':
        return view('teacher.film-specific.character-analysis.open', compact('app', 'app_category', 'session', 'is_student'));
        break;
    }

  }

}
