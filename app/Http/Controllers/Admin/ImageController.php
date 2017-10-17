<?php

namespace App\Http\Controllers\Admin;

use App\App;
use App\Media;
use App\AppSection;
use App\AppCategory;
use App\MediaCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    public function adminImage()
    {
      $categories = MediaCategory::all();
      $sections = AppSection::all();
      $app_categories = AppCategory::all();
      $apps = App::all();
      $medias = Media::orderBy('id', 'desc')->with('apps')->get();

      foreach ($medias as $key => $media) {
        $media->img = Storage::disk('local')->url($media->src);
        $app = $media->apps()->first();
        $category = $app->category()->first();
        $pavilion = $category->section()->first();
        $media->path = $pavilion->name.' > '.$category->name.' > '.$app->title;
      }

      dd('immagini');
      return view('admin.media.index', compact('categories', 'sections', 'app_categories', 'apps', 'medias'));
    }
}
