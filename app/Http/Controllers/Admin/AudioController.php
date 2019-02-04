<?php

namespace App\Http\Controllers\Admin;

use App\App;
use App\Audio;
use App\AppSection;
use App\AppCategory;
use App\MediaCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AudioController extends Controller
{
    public function adminAudio()
    {
        $categories = MediaCategory::all();
        $sections = AppSection::all();
        $app_categories = AppCategory::all();
        $apps = App::all();
        $audios = Audio::orderBy('id', 'desc')->with('apps')->get();

        foreach ($audios as $key => $audio) {
            $app = $audio->apps()->first();
            if ($app) {
                $category = $app->category()->first();
                $pavilion = $category->section()->first();
                $audio->path = $pavilion->name.' > '.$category->name.' > '.$app->title;
            } else {
                $category = null;
                $pavilion = null;
                $audio->path = 'error';
            }
        }

        return view('admin.audio.index', compact('categories', 'sections', 'app_categories', 'apps', 'audios'));
    }

    public function get_audios()
    {
        $categories = MediaCategory::all();
        $sections = AppSection::all();
        $app_categories = AppCategory::all();
        $apps = App::all();
        $audios = Audio::where('category_id', '=', 3)->orderBy('id', 'desc')->with('apps')->get();

        foreach ($audios as $key => $audio) {
            $app = $audio->apps()->first();
            $category = $app->category()->first();
            $pavilion = $category->section()->first();
            $audio->path = $pavilion->name.' > '.$category->name.' > '.$app->title;
        }

        return response($audios);
    }

    public function save_audio(Request $request)
    {
        $audio = Audio::find($request->id);
        $audio->title = $request->title;
        $audio->save();
        return response($audio, 200);
    }

}
