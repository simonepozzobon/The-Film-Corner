<?php

namespace App\Http\Controllers\Student;

use App\SharedSession;
use AppsSession\AppsSession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class NetworkController extends Controller
{
    public function index()
    {
      $shared = SharedSession::orderBy('created_at', 'desc')->with('app', 'app.category')->get();
      $items = collect();

      foreach ($shared as $key => $share) {

        // Creo l'oggetto
        $item = collect();
        $item->title = $share->title;
        $item->app_name = $share->app->title;
        $item->app_category = $share->app->category->name;

        switch ($share->app_id) {
          // Film Specific - Framing - App 1 - Frame Composer
          case '1':
            $obj = json_decode($share->content);
            $item->media_type = 'image';
            $item->featured_media = $obj->img;
            $item->notes = $obj->notes;
            break;

          // Film Specific - Framing - App 2 - Frame Crop
          case '2':
            $obj = collect(json_decode($share->content));

            $item->media_type = 'image';
            $item->featured_media = $obj->first()->img;
            $item->notes = $obj->first()->description;
            break;

          // Film Specific - Framing - App 3 - Juxtaposition
          case '3':
            $obj = json_decode($share->content);

            $item->media_type = 'video';
            $item->featured_media = $obj->videos[0];
            $item->notes = $obj->notes;
            break;

          // Film Specific - Editing - App 5 - Offscreen
          case '5':
            $obj = json_decode($share->content);

            $item->media_type = 'video';
            $item->featured_media = $obj->video;
            $item->notes = $obj->notes;
            break;

          // Film Specific - Editing - App 6 - Attractions
          case '6':
            $obj = json_decode($share->content);

            $item->media_type = 'image';
            $item->featured_media = $obj->imgL;
            $item->notes = $obj->notes;
            break;

          // Film Specific - Sound - App 7 - What's going on
          case '7':
            $obj = json_decode($share->content);

            $item->media_type = 'audio';
            $item->featured_media = $obj->audio;
            $item->notes = $obj->notes;
            break;

          // Film Specific - Sound - App 8 - Sound Atmosphere
          case '8':
            $obj = json_decode($share->content);

            $item->media_type = 'video';
            $item->featured_media = $obj->video;
            $item->notes = $obj->notes;
            break;

          // Film Specific - Sound - App 9 - Soundscapes
          case '9':
            $obj = json_decode($share->content);

            $item->media_type = 'video';
            $item->featured_media = $obj->video;
            $item->notes = $obj->notes;
            break;

          // Creative Studio - Warm up - App 10 - Active Offscreen
          case '10':
            $obj = json_decode($share->content);

            $item->media_type = 'video';
            $item->featured_media = Storage::disk('local')->url($obj->videos[0]->video);
            $item->notes = '';
            break;

          // Creative Studio - Story Telling - App 13 - Character Builder
          case '13':
            $obj = json_decode($share->content);
            $item->media_type = 'image';
            $item->featured_media = $obj->img;
            $item->notes = $obj->notes;
            break;

          // Creative Studio - Story Telling - App 14 - Storytelling
          case '14':
            $obj = json_decode($share->content);

            $item->media_type = 'text';
            $item->featured_media = '';
            $item->notes = $obj->notes;
            break;

          // Creative Studio - Story Telling - App 15 - Storyboard
          case '15':
            $obj = json_decode($share->content);
            $item->media_type = 'image';
            $item->featured_media = $obj[0]->img;
            $item->notes = $obj[0]->description;
            break;

          // Creative Studio - Contest - App 16 - Minuto Lumiere
          case '16':
            $obj = json_decode($share->content);
            $item->media_type = 'video';
            $item->featured_media = Storage::disk('local')->url($obj->video->video);
            $item->notes = '';
            break;

          // Creative Studio - Contest - App 16 - Make Your Own film
          case '17':
            $obj = json_decode($share->content);
            $item->media_type = 'video';
            $item->featured_media = Storage::disk('local')->url($obj->video->video);
            $item->notes = '';
            break;
        }

        $items->push($item);

      }

      return view('student.network.index', compact('items'));
    }

}