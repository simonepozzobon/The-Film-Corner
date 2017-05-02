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
      // prendo la libreria
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
