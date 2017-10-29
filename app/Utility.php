<?php

namespace App;

use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Utility extends Model
{
  static public function startWith($haystack, $needle)
  {
       $length = strlen($needle);
       return (substr($haystack, 0, $length) === $needle);
  }

  public function verifyExt($ext, $types)
  {
    // Type is an array ['video', 'image', 'audio']
    // Allowed File Extensions
    $video = ['mp4', 'avi','mov','mpeg','3gp','m4v','mkv','flv','FLV','MP4','MKV','MOV','AVI','MPEG','MPEG'];
    $audio = ['wav','mp3','WAV','MP3','aiff'];
    $image = ['jpg','png','gif','JPG','PNG','GIF'];

    foreach ($types as $key => $type) {
      if ($type == 'video') {
        if (in_array($ext, $video)) {
          return true;
        }
      }

      if ($type == 'image') {
        if (in_array($ext, $image)) {
          return true;
        }
      }

      if ($type == 'audio') {
        if (in_array($ext, $audio)) {
          return true;
        }
      }
    }

    return false;
  }

  /*
   *
   * $filename = nome del file senza estensione
   * $ext = estensione del file originale
   * $destFolder = video/uploads/ cartella di destinazione con / alla fine
   *
   * ritorna la path dell'immagine catturata a metà video e la path del video
   *
  */
  public function storeVideo($file, $filename, $ext, $destFolder)
  {
    // definisco la library di FFMPEG
    define('FFMPEG_LIB', '/usr/local/bin/ffmpeg');

    // definisco la path global
    $globalPath = Storage::disk('local')->getDriver()->getAdapter();

    $file = $file->storeAs('public/video/tmp', $filename.'.'.$ext);
    $filePath = $globalPath->applyPathPrefix($file);

    Storage::makeDirectory('public/'.$destFolder, 0777, true);

    // eseguo il comando FFMPEG
    if ($ext == '.mp4') {
      $cli = FFMPEG_LIB.' -i "'.$filePath.'" "'.storage_path('app/public/'.$destFolder).$filename.'.mp4"';
    } else {
      $cli = FFMPEG_LIB.' -i "'.$filePath.'" -vcodec h264 -acodec aac -strict -2 -vf "scale=trunc(iw/2)*2:trunc(ih/2)*2" "'.storage_path('app/public/'.$destFolder).$filename.'.mp4"';
    }
    exec($cli);

    // Cancello il file temporaneo
    Storage::delete($file);

    // salvo la path del file converito per il DB
    $path = $destFolder.$filename.'.mp4';

    // get duration
    $filePath = $globalPath->applyPathPrefix('public/'.$path);
    $cli = FFMPEG_LIB.' -i "'.$filePath.'" 2>&1 | grep \'Duration\' | cut -d \' \' -f 4 | sed s/,//';
    $duration =  exec($cli);

    // Converto la durata in secondi
    $duration = explode(":",$duration);
    $duration = $duration[0]*3600 + $duration[1]*60+ round($duration[2]);
    $timeToSnap = $duration / 2;

    // prendo il frame e lo salvo
    $cli = FFMPEG_LIB.' -y -i "'.$filePath.'" -f mjpeg -vframes 1 -ss '.$timeToSnap.' "'.storage_path('app/public/'.$destFolder).$filename.'-thumb.jpg"';
    exec($cli);

    // salvo la path del frame
    $thumbPath = $destFolder.$filename.'-thumb.jpg';

    $data = [
      'src' => $path,
      'img' => $thumbPath,
      'duration' => $duration,
    ];

    return $data;
  }

  /*
   *
   * $filename = nome del file senza estensione
   * $ext = estensione del file originale
   * $destFolder = video/uploads/ cartella di destinazione con / alla fine
   *
   * ritorna la path dell'immagine catturata a metà video e la path del video
   *
  */
  public function storeAudio($file, $filename, $ext, $destFolder)
  {
    // definisco la library di FFMPEG
    define('FFMPEG_LIB', '/usr/local/bin/ffmpeg');

    // definisco la path global
    $globalPath = Storage::disk('local')->getDriver()->getAdapter();

    $file = $file->storeAs('public/'.$destFolder, $filename.'.'.$ext);

    $path = $destFolder.$filename.'.'.$ext;

    // get duration
    $filePath = $globalPath->applyPathPrefix('public/'.$path);
    $cli = FFMPEG_LIB.' -i "'.$filePath.'" 2>&1 | grep \'Duration\' | cut -d \' \' -f 4 | sed s/,//';
    $duration =  exec($cli);

    // Converto la durata in secondi
    $duration = explode(":",$duration);
    $duration = $duration[0]*3600 + $duration[1]*60+ round($duration[2]);
    $timeToSnap = $duration / 2;

    $data = [
      'src' => $path,
      'duration' => $duration,
    ];

    return $data;
  }


  public function storeImg($file, $filename, $destFolder)
  {
      // Salvo il file
      $ext = $file->getClientOriginalExtension();

      $src = $file->storeAs('public/'.$destFolder, $filename.'.'.$ext);

      // preparo gli altri formati
      $thumb = $file->storeAs('public/'.$destFolder.'/thumb', $filename.'.'.$ext);
      $portrait = $file->storeAs('public/'.$destFolder.'/portrait', $filename.'.'.$ext);
      $landscape = $file->storeAs('public/'.$destFolder.'/landscape', $filename.'.'.$ext);

      // genero gli altri formati
      $path = storage_path('app/public/'.$destFolder);

      // Thumb
      Image::make($path.'/thumb/'.$filename.'.'.$ext)->fit(500, 500, function ($constraint) {
          $constraint->upsize();
      })->save();

      // portrait
      Image::make($path.'/portrait/'.$filename.'.'.$ext)->fit(720, 960, function ($constraint) {
          $constraint->upsize();
      })->save();

      // landscape 960 540
      Image::make($path.'/landscape/'.$filename.'.'.$ext)->fit(960, 540, function ($constraint) {
          $constraint->upsize();
      })->save();

      $data = [
        'src' => $src,
        'thumb' => $thumb,
        'portrait' => $portrait,
        'landscape' => $landscape,
      ];

      return $data;
  }

  public function verifyDirAndCreate($path)
  {
      $finalPath = storage_path('app/'.$path);
      if (!file_exists($finalPath)) {
        $mkdir = Storage::makeDirectory($path, 0777, true);
      }

      return $finalPath;
  }

  public function formatNetworkContent($share) {
    $item = collect();
    $item->id = $share->id;
    $item->title = $share->title;
    $item->app_name = $share->app->title;
    $item->app_category = $share->app->category->name;
    $item->token = $share->token;
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

        $item->media_type = 'image';
        $item->featured_media = $obj->images[0];
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

    return $item;
  }

  public function assignColor($item, $key, $items_color)
  {
    $colors = [
      0 => ['yellow', 'dark-yellow'],
      1 => ['green', 'dark-green'],
      2 => ['orange', 'dark-orange'],
      3 => ['blue', 'dark-blue'],
    ];

    $item->debug = '';

    switch ($key) {
      case 0:
        $id = rand(0,3);
        break;

      case $key == 1:
        $id = rand(0,3);
        $before = $items_color[$key-1];

        while ($id == $before)
        {
            $id = rand(0,3);
        }

        break;

      case $key == 2:
        $id = rand(0,3);
        $first = $items_color[$key-1];
        $second = $items_color[$key-2];

        if ($id == $first || $id == $second) {
          while ($id == $first || $id == $second)
          {
              $id = rand(0,3);
          }
        }

        break;

      case $key > 2 && $key % 3 == 0:
        // Left Column
        $id = rand(0, 3);
        $right_corner = $items_color[$key-2];
        $top = $items_color[$key-3];

        if ($id == $right_corner || $id == $top) {
          while ($id == $right_corner || $id == $top)
          {
              $id = rand(0,3);
          }
        }
        break;

      case $key > 2 && ($key+1) % 3 == 0 || ($key-1) % 3 == 0:
        // Right Column
        $id = rand(0, 3);
        $before = $items_color[$key-1];
        $left_corner = $items_color[$key-4];
        $top = $items_color[$key-3];

        if ($id == $before || $id == $top || $id == $left_corner) {
          while ($id == $before || $id == $top || $id == $left_corner)
          {
              $id = rand(0,3);
          }
        }

        break;
    }


    $items_color->push($id);
    $item->colors = $colors[$id];

    return $item;
  }
}
