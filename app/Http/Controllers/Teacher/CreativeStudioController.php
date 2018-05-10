<?php

namespace App\Http\Controllers\Teacher;

use App\App;
use Validator;
use App\Video;
use App\Media;
use App\Teacher;
use App\Utility;
use App\AppSection;
use App\AppKeyword;
use App\AppCategory;
use App\AudioLibrary;
use App\VideoLibrary;
use App\TeacherSession;
use Illuminate\Http\Request;
use App\AppsSessions\AppsSession;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\AppsSessions\StudentAppSession;
use App\AppsSessions\FilmSpecific\FrameCrop;
use Spatie\Activitylog\Models\Activity;

class CreativeStudioController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth:teacher', ['except' => 'logout']);
  }

  public function index($category)
  {
    $app_category = AppCategory::where('slug', '=', $category)->with('section')->with('keywords')->first();
    $apps = App::where('app_category_id', '=', $app_category->id)->orderBy('order')->with('category')->get();
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

    $keywords = AppKeyword::all();

    return view('teacher.creative-studio.path.index', compact('apps', 'app_category', 'visited', 'keywords'));
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
        $videos = $app->videos()->get();
        $videos = collect($videos->pluck('src')->all());

        $flatten = $videos->transform(function($video, $key) {
            return Storage::disk('local')->url($video);
        });
        $random_video = $flatten->random();
        return view('teacher.creative-studio.active-offscreen.index', compact('app', 'app_category', 'random_video'));
        break;

      case 'active-parallel-action':
        $elements = $app->videos()->get();
        return view('teacher.creative-studio.active-parallel-action.index', compact('app', 'app_category', 'elements'));
        break;

      case 'sound-studio':
        $elements = $app->audios()->get();
        $videos = $app->videos()->get();
        $videos = collect($videos->pluck('src')->all());

        $flatten = $videos->transform(function($video, $key) {
            return Storage::disk('local')->url($video);
        });

        $random_video = $flatten->random();
        return view('teacher.creative-studio.sound-studio.index', compact('app', 'app_category', 'elements', 'random_video'));
        break;

      /*
       *
       * PATH STORYTELLING
       *
      **/

      case 'character-builder':
        $images = $app->medias()->get();
        $images = $images->filter(function ($img, $key) {
            // $img->library = $img->library()->get();
            return $img->category_id == 2;
        });
        $images->all();
        return view('teacher.creative-studio.character-builder.index', compact('app', 'app_category', 'images'));
        break;

      case 'storytelling':
        $categories = $app->mediaCategory()->get();
        $images = collect();
        foreach ($categories as $key => $category) {
          $library = $category->medias()->get();
          $flatten = $library->transform(function($media, $key) {
            return Storage::disk('local')->url($media->src);
          });
          $images->push($flatten);
        }
        $libraries_count = $images->count();
        $images = json_encode($images);

        return view('teacher.creative-studio.storytelling.index', compact('app', 'app_category', 'images', 'libraries_count'));
        break;

      case 'storyboard':
        return view('teacher.creative-studio.storyboard.index', compact('app', 'app_category'));
        break;


      /*
       *
       * PATH MY CORNER CONTEST
       *
      **/

      case 'lumiere-minute':
        return view('teacher.creative-studio.lumiere-minute.index', compact('app', 'app_category'));
        break;

      case 'make-your-own-film':
        return view('teacher.creative-studio.make-your-own-film.index', compact('app', 'app_category'));
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
      $app_session = StudentAppSession::where('token', '=', $token)->with('student')->first();
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


      /*
       *
       * PATH WARM UP
       *
      **/

      case 'active-offscreen':
        return view('teacher.creative-studio.active-offscreen.open', compact('app', 'app_category', 'app_session', 'is_student', 'session'));
        break;

      case 'active-parallel-action':
        $elements = $app->videos()->get();
        $session = $session;
        $timelines = json_encode($session->timelines);
        return view('teacher.creative-studio.active-parallel-action.open', compact('app', 'app_category', 'app_session', 'is_student', 'elements', 'session', 'timelines', 'token'));
        break;

      case 'sound-studio':
        $elements = $app->audios()->get();
        $session = $session;
        $timelines = json_encode($session->timelines);
        return view('teacher.creative-studio.sound-studio.open', compact('app', 'app_category', 'app_session', 'is_student', 'elements', 'timelines', 'session', 'token'));
        break;


      /*
       *
       * PATH STORYTELLING
       *
      **/

      case 'character-builder':
        $images = $app->medias()->get();
        $images = $images->filter(function ($img, $key) {
            return $img->category_id == 2;
        });
        $images->all();
        $session->json_data = htmlspecialchars_decode($session->json_data);
        return view('teacher.creative-studio.character-builder.open', compact('app', 'app_category', 'app_session', 'is_student', 'session', 'images'));
        break;

      case 'storytelling':
        $categories = $app->mediaCategory()->get();
        $images = collect();
        foreach ($categories as $key => $category) {
          $library = $category->medias()->get();
          $flatten = $library->transform(function($media, $key) {
            return Storage::disk('local')->url($media->src);
          });
          $images->push($flatten);
        }
        $libraries_count = $images->count();
        $images = json_encode($images);
        return view('teacher.creative-studio.storytelling.open', compact('app', 'app_category', 'app_session', 'is_student', 'session', 'libraries_count', 'images'));
        break;

      case 'storyboard':
        return view('teacher.creative-studio.storyboard.open', compact('app', 'app_category', 'app_session', 'is_student', 'session'));
        break;


      /*
       *
       * PATH MY CORNER CONTEST
       *
      **/

      case 'lumiere-minute':
        return view('teacher.creative-studio.lumiere-minute.open', compact('app', 'app_category', 'app_session', 'is_student', 'session'));
        break;

      case 'make-your-own-film':
        return view('teacher.creative-studio.make-your-own-film.open', compact('app', 'app_category', 'app_session', 'is_student', 'session'));
        break;

    }

  }

  public function uploadVideo($category, $app_slug, Request $request)
  {
    // manca aggiungere la sessione al form
    // manca fare una verifica della dimensione del file
    if ($request->file('media') == null) {
      $data = [
        'msg' => 'Error, No file selected'
      ];
      return response()->json($data, 400);
    }

    $utility = new Utility;
    $file = $request->file('media');
    $title = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    $ext = $file->getClientOriginalExtension();
    $check = $utility->verifyExt($ext, ['video']);

    // return response()->json([$ext]);

    // verify the extension
    if ($check == false) {
      $data = [
        'msg' => 'Error. File not supported'
      ];
      return response()->json($data, 400);
    } else {

      $teacher = Auth::guard('teacher')->user();
      $app = App::where('slug', '=', $app_slug)->with('category')->first();
      $app_category = AppCategory::find($app->app_category_id);
      $app_session = AppsSession::where('token', '=', $request->input('session'))->first();

      // return response()->json([$app_session, $request->input('session'), $teacher]);

      if ($app_session == null || $request->input('session') == null || $teacher == null) {
        $data = [
          'msg' => 'Error. Session is corrupted, must create a new one'
        ];
        return response()->json($data, 400);
      }

      //Creo il nome del file
      $filename = uniqid();
      $videoStore = $utility->storeVideo($file, $filename, $ext, 'apps/'.$app_category->slug.'/'.$app->slug.'/'.$teacher->id.'/');

      $video = new Video;
      $video->title = $title;
      $video->img = $videoStore['img'];
      $video->src = $videoStore['src'];
      $video->duration = $videoStore['duration'];
      $video->save();

      // creo il link tra video e sessione
      $app_session->videos()->save($video);
      $teacher->videos()->save($video);

      // se è un contest devo anche salvare la sessione
      if ($app->id == 16 || $app->id == 17) {
        $data = [
          'video' => [
            'img' => Storage::disk('local')->url($videoStore['img']),
            'video' => $videoStore['src']
          ]
        ];
        $app_session->is_empty = 0;
        $app_session->title = $request['title'];
        $app_session->content = json_encode($data);
        $app_session->save();
      }

      $data = [
        'name' => $title,
        'duration' => $videoStore['duration'],
        'video_id' => $video->id,
        'img' => Storage::disk('local')->url($videoStore['img']),
        'src' => $videoStore['src']
      ];

      return response()->json($data);
    }
  }

  public function uploadImg($category, $app_slug, Request $request)
  {
    // manca aggiungere la sessione al form
    // manca fare una verifica della dimensione del file
    // return response($request->all());

    $utility = new Utility;
    $file = $request->file('media');
    $ext = $file->getClientOriginalExtension();
    $check = $utility->verifyExt($ext, ['image']);


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
        $app_session = AppsSession::where('token', '=', $request->input('session_token'))->first();

        // Se c'è un problema con la sessione ritorno un errore
        if ($app_session == null || $teacher == null) {
            return response()->json(['Session is corrupted'], 500);
        } else if ($teacher == null) {
            return response()->json(['Not authorized'], 500);
        }

        //Creo il nome del file
        $filename = uniqid();
        $imgStore = $utility->storeImg($file, $filename, 'apps/'.$app_category->slug.'/'.$app->slug.'/'.$teacher->id);

        $img = new Media;
        $img->src = $imgStore['src'];
        $img->thumb = $imgStore['thumb'];
        $img->landscape = $imgStore['landscape'];
        $img->portrait = $imgStore['portrait'];
        $img->save();

        // creo il link tra video e sessione
        $app_session->medias()->save($img);
        $teacher->medias()->save($img);

        $data = [
            'img_id' => $img->id,
            'img' => Storage::disk('local')->url($imgStore['src']),
            'src' => $imgStore['src']
        ];

        return response()->json($data);
    }
  }
}
