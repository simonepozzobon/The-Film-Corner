<?php

namespace App;

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
    $cli = FFMPEG_LIB.' -i '.$filePath.' '.storage_path('app/public/'.$destFolder).$filename.'.mp4';
    exec($cli);

    // Cancello il file temporaneo
    Storage::delete($file);

    // salvo la path del file converito per il DB
    $path = $destFolder.$filename.'.mp4';


    // get duration
    $filePath = $globalPath->applyPathPrefix('public/'.$path);
    $cli = FFMPEG_LIB.' -i '.$filePath.' 2>&1 | grep \'Duration\' | cut -d \' \' -f 4 | sed s/,//';
    $duration =  exec($cli);

    // Converto la durata in secondi
    $duration = explode(":",$duration);
    $duration = $duration[0]*3600 + $duration[1]*60+ round($duration[2]);
    $timeToSnap = $duration / 2;

    // prendo il frame e lo salvo
    $cli = FFMPEG_LIB.' -y -i '.$filePath.' -f mjpeg -vframes 1 -ss '.$timeToSnap.' '.storage_path('app/public/'.$destFolder).$filename.'-thumb.jpg';
    exec($cli);

    // salvo la path del frame
    $thumbPath = $destFolder.$filename.'-thumb.jpg';

    $data = [
      'src' => $path,
      'img' => $thumbPath
    ];

    return $data;
  }
}
