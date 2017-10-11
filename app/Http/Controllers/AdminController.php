<?php

namespace App\Http\Controllers;

use App\App;
use App\AppSection;
use App\AppCategory;
use App\VideoCategory;
use Illuminate\Http\Request;

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

        return view('admin', compact('categories', 'sections', 'app_categories', 'apps'));
    }
}
