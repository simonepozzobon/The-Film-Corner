<?php

namespace App\Http\Controllers\Admin\Apps;

use App\App;
use App\Video;
use App\Utility;
use App\AppSection;
use App\AppCategory;
use App\MediaCategory;
use App\MediaSubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function uploadVideo(Request $r)
    {

      $utility = new Utility;

      $file = $r['video'];
      $filename = pathinfo($r['video']->getClientOriginalName(), PATHINFO_FILENAME);
      $ext = $r['video']->getClientOriginalExtension();

      $check = $utility->verifyExt($ext, ['video']);
      // $check = true;

      $pavilion = AppSection::find($r->section);
      $app_category = AppCategory::find($r->app_category);
      $app_name = App::find($r->app_name);

      $destFolder = 'apps/library/'.$pavilion->slug.'/'.$app_category->slug.'/'.$app_name->slug.'/video/';

      // return response()->json([
      //   'request' => $r->all(),
      //   'file' => $file,
      //   'filename' => $filename,
      //   'ext' => $ext,
      //   'check' => $check,
      //   'pavilion' => $pavilion,
      //   'app_category' => $app_category,
      //   'app_name' => $app_name,
      //   'destFolder' => $destFolder
      // ], 200);

      if ($check) {

        switch ($r->category) {
          case 1:
            $library = $utility->storeVideo($file, $filename, $ext, $destFolder.'general/');
            break;
          case 2:
            $library = $utility->storeVideo($file, $filename, $ext, $destFolder.'app/');
            break;
          case 3:
            $library = $utility->storeVideo($file, $filename, $ext, $destFolder.'example/');
            break;
        }

        return response([
          'library' => $library
        ]);

        $video = new Video;
        $video->title = $r->title;
        $video->category_id = $r->category;
        $video->img = $library['img'];
        $video->src = $library['src'];
        $video->duration = $library['duration'];
        $video->save();

        $pavilion->videos()->save($video);
        $app_category->videos()->save($video);
        $app_name->videos()->save($video);

        if ($r->sub_category != null) {
          $sub_category = MediaSubCategory::find($r->sub_category);
          $sub_category->videos()->save($video);
        }

        // riformatto il link dell'immagine per renderlo accessibile in vue
        $video->img = Storage::disk('local')->url($video->img);
        $video->path = $pavilion->name.' > '.$app_category->name.' > '.$app_name->title;


        $data = [
          'success' => true,
          'message' => 'success',
          'video' => $video,
          'library' => $library,
          'destFolder' => $destFolder,
          'file' => $file,
          'filename' => $filename,
          'ext' => $ext
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

    public function deleteVideo($id)
    {
        $video = Video::findOrFail($id);

        $video->appsSessions()->detach($video);
        $video->studentAppSessions()->detach($video);
        $video->teachers()->detach($video);
        $video->students()->detach($video);
        $video->apps()->detach($video);
        $video->appCategories()->detach($video);
        $video->appSection()->detach($video);
        $video->mediaSubCategories()->detach($video);

        $video_path = storage_path('app/public/'.$video->src);
        $img_path = storage_path('app/public/'.$video->img);

        if (file_exists($video_path)) {
          $r_video = unlink($video_path);
        }
        if (file_exists($img_path)) {
          $r_img = unlink($img_path);
        }

        $video->delete();

        $data = [
            'success' => true,
            'message' => 'video deleted!',
            'path' => $video_path,
            'r_video' => $r_video
        ];
        return response()->json($data, 200);
    }

}
