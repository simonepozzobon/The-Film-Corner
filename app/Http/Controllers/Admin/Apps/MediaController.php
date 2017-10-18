<?php

namespace App\Http\Controllers\Admin\Apps;

use App\App;
use App\Media;
use App\Utility;
use App\AppSection;
use App\AppCategory;
use App\MediaCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function uploadMedia(Request $r)
    {

      $utility = new Utility;
      $file = $r->image;
      $filename = pathinfo($r->image->getClientOriginalName(), PATHINFO_FILENAME);
      $ext = $r->image->getClientOriginalExtension();

      $check = $utility->verifyExt($ext, ['image']);

      if ($check) {
          $pavilion = AppSection::find($r->section);
          $app_category = AppCategory::find($r->app_category);
          $app_name = App::find($r->app_name);
          $destFolder = 'apps/library/'.$pavilion->slug.'/'.$app_category->slug.'/'.$app_name->slug.'/images/';

          switch ($r->category) {
            case 1:
              $library = $utility->storeImg($file, $filename, $destFolder.'general');
              break;
            case 2:
              $library = $utility->storeImg($file, $filename, $destFolder.'app');
              break;
            case 3:
              $library = $utility->storeImg($file, $filename, $destFolder.'example');
              break;
          }

          $media = new Media;
          $media->category_id = $r->category;
          $media->title = $r->title;
          $media->src = preg_replace('/public\//', '',$library['src']);
          $media->thumb = preg_replace('/public\//', '',$library['thumb']);
          $media->landscape = preg_replace('/public\//', '',$library['landscape']);
          $media->portrait = preg_replace('/public\//', '',$library['portrait']);
          $media->save();

          $pavilion->medias()->save($media);
          $app_category->medias()->save($media);
          $app_name->medias()->save($media);

          $media->img = Storage::disk('local')->url($media->thumb);
          $media->path = $pavilion->name.' > '.$app_category->name.' > '.$app_name->title;

          $data = [
            'success' => true,
            'message' => 'success',
            'image' => $media
          ];

          return response()->json($data);

      } else {
          $data = [
              'success' => false,
              'message' => 'error, wrong format',
          ];
          return response()->json($data, 200);
      }


    }

    public function deleteMedia($id)
    {
      $media = Media::findOrFail($id);

      $media->appsSessions()->detach($media);
      $media->studentAppSessions()->detach($media);
      $media->teachers()->detach($media);
      $media->students()->detach($media);
      $media->apps()->detach($media);
      $media->appCategories()->detach($media);
      $media->appSection()->detach($media);

      $media_path = storage_path('app/public/'.$media->src);
      $thumb = storage_path('app/public/'.$media->thumb);
      $landscape = storage_path('app/public/'.$media->landscape);
      $portrait = storage_path('app/public/'.$media->portrait);

      if (file_exists($media_path)) {
        $r_media = unlink($media_path);
      }
      if (file_exists($thumb)) {
        $r_img = unlink($thumb);
      }
      if (file_exists($landscape)) {
        $r_img = unlink($landscape);
      }
      if (file_exists($portrait)) {
        $r_img = unlink($portrait);
      }

      $media->delete();

      $data = [
          'success' => true,
          'message' => 'video deleted!',
          'path' => $media_path,
      ];
      return response()->json($data, 200);

    }
}
