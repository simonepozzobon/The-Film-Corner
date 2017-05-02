<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\VideoLibrary;
use App\Video;

class VideoController extends Controller
{
    public function index()
    {
      // definisco la library di FFMPEG
      define('FFMPEG_LIB', '/usr/local/bin/ffmpeg');

      // creo una nuova sessione
      $img = public_path('img/helpers/poster.png');

      // Definisco il codice della sessione
      $session_id = uniqid();

      // Creo il video della sessione e lo salvo nella cartella /video/sessions/id della sessione
      $storePath = storage_path('app/public/video/sessions/'.$session_id);

      $mkdir = Storage::makeDirectory('public/video/sessions/'.$session_id, 0777, true);

      $cli = FFMPEG_LIB.' -r 25 -f image2 -s 1920x1080 -y -i '.$img.' -vframes 125 -vcodec libx264 -crf 25 -pix_fmt yuv420p '.$storePath.'/tfc_video_session.mp4';
      exec($cli);

      // definisco la path pubblica per recuperare il video successivamente
      $publicPath = 'storage/video/sessions/'.$session_id;

      // Salvo la sessione nel database
      $Video = new Video;
      $Video->session = $session_id;
      $Video->media_url = $publicPath.'/tfc_video_session.mp4';
      $Video->save();

      // prendo la libreria
      $elements = VideoLibrary::all();

      return view('video.index', compact('elements', 'session_id'));
    }

    public function upload(Request $request)
    {

  		$file = $request->file('file');
      $ext = $file->getClientOriginalExtension();
      $name = $file->getClientOriginalName();

      return response()->json(['success' => $name]);

    }
}
