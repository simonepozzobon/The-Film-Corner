<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
define('FFMPEG_LIB', '/usr/local/bin/ffmpeg');

class AudioUtil extends Model
{
    public function __construct() {
    }

    public static function convert_to_mp3($filePath, $filename, $destFolder)
    {
        // ffmpeg -i action.wav -acodec libmp3lame test.mp3


        $path = $destFolder.$filename.'.mp3';
        // dd($destFolder);

        Storage::makeDirectory('public/'.$destFolder, 0777, true);

        $cli = FFMPEG_LIB.' -i "'.$filePath.'" -acodec libmp3lame "'.storage_path('app/public/'.$destFolder).$filename.'.mp3"';
        dump($cli);
        exec($cli);

        return $path;
    }
}
