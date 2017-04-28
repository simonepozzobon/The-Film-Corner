<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VideoLibrary;
use FFMpeg; //php-FFmpeg

class VideoController extends Controller
{
    public function index()
    {
      $ffmpeg = FFMpeg\FFMpeg::create([
            'ffmpeg.binaries'  => '/usr/local/bin/ffmpeg', // the path to the FFMpeg binary
            'ffprobe.binaries' => '/usr/local/bin/ffprobe', // the path to the FFProbe binary
            'timeout'          => 3600, // the timeout for the underlying process
            'ffmpeg.threads'   => 12,   // the number of threads that FFMpeg should use
        ]);

      $elements = VideoLibrary::all();

      return view('video.index', compact('elements'));
    }

    public function upload(Request $request)
    {

  		$file = $request->file('file');
      $ext = $file->getClientOriginalExtension();
      $name = $file->getClientOriginalName();

      return response()->json(['success' => $name]);

    }
}
