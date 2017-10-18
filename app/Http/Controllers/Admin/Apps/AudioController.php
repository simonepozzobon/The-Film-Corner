<?php

namespace App\Http\Controllers\Admin\Apps;

use App\App;
use App\Audio;
use App\Utility;
use App\AppSection;
use App\AppCategory;
use App\MediaCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AudioController extends Controller
{
  public function uploadAudio(Request $r)
  {

    $utility = new Utility;

    $file = $r['audio'];
    $filename = pathinfo($r['audio']->getClientOriginalName(), PATHINFO_FILENAME);
    $ext = $r['audio']->getClientOriginalExtension();

    $check = $utility->verifyExt($ext, ['audio']);

    $pavilion = AppSection::find($r->section);
    $app_category = AppCategory::find($r->app_category);
    $app_name = App::find($r->app_name);

    $destFolder = 'apps/library/'.$pavilion->slug.'/'.$app_category->slug.'/'.$app_name->slug.'/audio/';



    if ($check) {

      switch ($r->category) {
        case 1:
          $library = $utility->storeAudio($file, $filename, $ext, $destFolder.'general/');
          break;
        case 2:
          $library = $utility->storeAudio($file, $filename, $ext, $destFolder.'app/');
          break;
        case 3:
          $library = $utility->storeAudio($file, $filename, $ext, $destFolder.'example/');
          break;
      }

      $audio = new Audio;
      $audio->title = $r->title;
      $audio->category_id = $r->category;
      $audio->src = $library['src'];
      $audio->duration = $library['duration'];
      $audio->save();

      $pavilion->audios()->save($audio);
      $app_category->audios()->save($audio);
      $app_name->audios()->save($audio);

      // riformatto il link dell'immagine per renderlo accessibile in vue
      $audio->img = '';
      $audio->path = $pavilion->name.' > '.$app_category->name.' > '.$app_name->title;

      $data = [
        'success' => true,
        'message' => 'success',
        'audio' => $audio
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

  public function deleteAudio($id)
  {
      $audio = Audio::findOrFail($id);

      $audio->appsSessions()->detach($audio);
      $audio->studentAppSessions()->detach($audio);
      $audio->teachers()->detach($audio);
      $audio->students()->detach($audio);
      $audio->apps()->detach($audio);
      $audio->appCategories()->detach($audio);
      $audio->appSection()->detach($audio);

      $audio_path = storage_path('app/public/'.$audio->src);

      if (file_exists($audio_path)) {
        $r_audio = unlink($audio_path);
      }

      $audio->delete();

      $data = [
          'success' => true,
          'message' => 'audio deleted!',
          'path' => $audio_path,
          'r_audio' => $r_audio
      ];
      return response()->json($data, 200);
  }

}
