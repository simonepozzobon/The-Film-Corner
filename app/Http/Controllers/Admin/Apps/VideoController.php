<?php

namespace App\Http\Controllers\Admin\Apps;

use App\App;
use App\Video;
use App\Utility;
use App\AppSection;
use App\AppCategory;
use App\VideoCategory;
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

      $destFolder = 'apps/library/'.$pavilion->slug.'/'.$app_category->slug.'/'.$app_name->slug.'/';

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

        // riformatto il link dell'immagine per renderlo accessibile in vue
        $video->img = Storage::disk('local')->url($video->img);
        $video->path = $pavilion->name.' > '.$app_category->name.' > '.$app_name->title;


        $data = [
          'success' => true,
          'message' => 'success',
          'video' => $video
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
        $video->teachers()->detach($video);
        $video->students()->detach($video);
        $video->apps()->detach($video);
        $video->appCategories()->detach($video);
        $video->appSection()->detach($video);

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

    public function getRelations(string $type, $id)
    {
        switch ($type) {
          case 'pavilion':
              $section = AppSection::find($id);
              $categories = $section->appCategories()->get();
              $apps = collect();

              foreach ($categories as $key => $category) {
                $items = $category->apps()->get();
                foreach ($items as $key => $app) {
                  $apps->push($app);
                }
              }

              $data = [
                'categories' => $categories,
                'apps' => $apps
              ];

              return response()->json($data, 200);
            break;

          case 'category':
              $category = AppCategory::find($id);
              $section = $category->section()->first();
              $apps = $category->apps()->get();

              $data = [
                'pavilion' => $section,
                'apps' => $apps
              ];

              return response()->json($data, 200);
            break;

          case 'app':
              $app = App::find($id);
              $category = $app->category()->first();
              $section = $app->category()->first();

              $data = [
                'category' => $category,
                'pavilion' => $section
              ];

              return response()->json($data, 200);
            break;
        }
    }
}
