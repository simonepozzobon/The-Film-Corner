<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
