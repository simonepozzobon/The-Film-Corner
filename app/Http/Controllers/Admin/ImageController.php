<?php

namespace App\Http\Controllers\Admin;

use App\App;
use App\Media;
use App\AppSection;
use App\AppCategory;
use App\MediaCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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
        $media->img = Storage::disk('local')->url($media->thumb);
        $app = $media->apps()->first();
        $category = $app->category()->first();
        $pavilion = $category->section()->first();
        $media->path = $pavilion->name.' > '.$category->name.' > '.$app->title;
      }

      return view('admin.image.index', compact('categories', 'sections', 'app_categories', 'apps', 'medias'));
    }
}
