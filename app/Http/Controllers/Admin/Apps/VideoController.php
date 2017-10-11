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

class VideoController extends Controller
{
    public function uploadVideo(Request $r)
    {

      $utility = new Utility;

      $file = $r['video'];
      $filename = pathinfo($r['video']->getClientOriginalName(), PATHINFO_FILENAME);
      $ext = $r['video']->getClientOriginalExtension();

      // $check = $utility->verifyExt($ext, ['video']);
      $check = true;

      $pavilion = AppSection::find($r->section);
      $app_category = AppCategory::find($r->app_category);
      $app_name = App::find($r->app_name);

      $destFolder = 'apps/library/'.$pavilion->slug.'/'.$app_category->slug.'/'.$app_name->slug.'/';

      if ($check) {

        switch ($r->category) {
          case 1:
            $library = $utility->storeVideo($file, $filename, $ext, $destFolder.'/general/');
            break;
          case 2:
            $library = $utility->storeVideo($file, $filename, $ext, $destFolder.'/app/');
            break;
          case 3:
            $library = $utility->storeVideo($file, $filename, $ext, $destFolder.'/example/');
            break;
        }

        $video = new Video;
        $video->title = $r->title;
        $video->category_id = $r->category;
        $video->img = $library['img'];
        $video->src = $library['src'];
        $video->duration = $library['duration'];
        $video->save();

        $data = [
          'success' => 'true',
          'message' => 'success',
          'request' => $r->all(),
          'response' => $library['img']
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
}
