<?php

namespace App\Http\Controllers;

use App\App;
use App\Video;
use App\AppSection;
use App\AppCategory;
use App\VideoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {
         $this->middleware('auth:admin', ['except' => 'logout']);
     }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = VideoCategory::all();
        $sections = AppSection::all();
        $app_categories = AppCategory::all();
        $apps = App::all();
        $videos = Video::orderBy('id', 'desc')->with('apps')->get();

        foreach ($videos as $key => $video) {
          $video->img = Storage::disk('local')->url($video->img);
          $app = $video->apps()->first();
          $category = $app->category()->first();
          $pavilion = $category->section()->first();
          $video->path = $pavilion->name.' > '.$category->name.' > '.$app->title;
        }

        return view('admin', compact('categories', 'sections', 'app_categories', 'apps', 'videos'));
    }
}
