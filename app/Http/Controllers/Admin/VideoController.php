<?php

namespace App\Http\Controllers\Admin;

use App\App;
use App\Video;
use App\AppSection;
use App\AppCategory;
use App\VideoLibrary;
use App\MediaCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function adminVideo()
    {
      $categories = MediaCategory::all();
      $sections = AppSection::all();
      $app_categories = AppCategory::all();
      $apps = App::all();
      $videos = Video::orderBy('id', 'desc')->with('apps')->get();

      foreach ($videos as $key => $video) {
        $video->img = Storage::disk('local')->url($video->img);
        $app = $video->apps()->first();
        // $category = $app->category()->first();
        // $pavilion = $category->section()->first();
        // $video->path = $pavilion->name.' > '.$category->name.' > '.$app->title;
        $video->path = '';
      }

      return view('admin.video.index', compact('categories', 'sections', 'app_categories', 'apps', 'videos'));
    }

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
      $media_url = $publicPath.'/tfc_video_session.mp4';

      // Salvo la sessione nel database
      $Video = new Video;
      $Video->session = $session_id;
      $Video->media_url = $media_url;
      $Video->save();


      // prendo la libreria
      $elements = VideoLibrary::all();

      return view('video.index', compact('elements', 'session_id', 'media_url'));
    }

    public function upload(Request $request)
    {

  		$file = $request->file('file');
      $ext = $file->getClientOriginalExtension();
      $name = $file->getClientOriginalName();

      return response()->json(['success' => $name]);

    }
}
