<?php

namespace App\Http\Controllers\Teacher;

use App\App;
use App\AppSection;
use App\AppKeyword;
use App\AppCategory;
use App\TeacherSession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\AppsSessions\FilmSpecific\FrameCrop;

class FilmSpecificController extends Controller
{
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

  public function app($category, $app_slug)
  {
    $app_category = AppCategory::where('slug', '=', $category)->with('section')->first();
    $app = App::where('slug', '=', $app_slug)->with('category')->first();

    switch ($app_slug) {

      case 'frame-crop':
        return view('teacher.film-specific.frame-crop.index', compact('app'));
        break;
    }

  }

  public function openSession($category, $app_slug, $token)
  {
    $app = App::where('slug', '=', $app_slug)->with('category')->first();

    $frames = FrameCrop::where('token', '=', $token)->get();

    foreach ($frames as $key => $frame) {
      $frame->img = str_replace('/storage', 'storage', $frame->img);
    }

    return view('teacher.film-specific.frame-crop.open', compact('app', 'frames'));
  }

}
