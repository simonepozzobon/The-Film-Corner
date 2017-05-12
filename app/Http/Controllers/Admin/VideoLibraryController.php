<?php

namespace App\Http\Controllers\Admin;

use FFMpeg;
use App\VideoLibrary;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class VideoLibraryController extends Controller
{
    public function index()
    {
        $videos = VideoLibrary::all();
        return response(compact('videos'));
    }

    public function store(Request $request)
    {
      // definisco la library di FFMPEG
      define('FFMPEG_LIB', '/usr/local/bin/ffmpeg');

      // definisco la path global
      $globalPath = Storage::disk('local')->getDriver()->getAdapter();

      // Get The File
      $file = $request->file('video');

      // get more informations
      $det = [
        'name'  => $file->getClientOriginalName(),
        'noext' => preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->getClientOriginalName()),
        'ext'   => $file->getClientOriginalExtension(),
        'size'  => $file->getSize(),
        'mime'  => $file->getMimeType(),
        'path'  => $file->getRealPath(),
      ];

      // create a uniq id
      $filename = uniqid();

      // Allowed File Extensions
      $video = ['mp4', 'avi','mov','mpeg','3gp','m4v','mkv','flv','FLV','MP4','MKV','MOV','AVI','MPEG','MPEG'];
      $audio = ['wav','mp3','WAV','MP3'];
  		$image = ['jpg','png','gif','JPG','PNG','GIF'];

      // Define what type of file it is
      $ext = $det['ext'];

      if (in_array($ext, $image)) {
        $fileType = 'image';
        $path = 'images';
      } elseif (in_array($ext, $audio)) {
        $fileType = 'audio';
        $path = 'audio';
      } elseif (in_array($ext, $video)) {
        $fileType = 'video';
        $path = storage_path('app/public/video/uploads');

        // Salvo il file nella cartella tmp per la conversione
        $file = $file->storeAs('public/video/tmp', $filename.'.'.$ext);
        $filePath = $globalPath->applyPathPrefix($file);

        // eseguo il comando FFMPEG
        $cli = FFMPEG_LIB.' -i '.$filePath.' '.storage_path('app/public/video/uploads/').$filename.'.mp4';
        exec($cli);

        // Cancello il file temporaneo
        Storage::delete($file);

        // salvo la path del file converito per il DB
        $path = 'video/uploads/'.$filename.'.mp4';


        // get duration
        $filePath = $globalPath->applyPathPrefix('public/'.$path);
        $cli = FFMPEG_LIB.' -i '.$filePath.' 2>&1 | grep \'Duration\' | cut -d \' \' -f 4 | sed s/,//';
        $duration =  exec($cli);

        // Converto la durata in secondi
        $duration = explode(":",$duration);
        $duration = $duration[0]*3600 + $duration[1]*60+ round($duration[2]);
        $timeToSnap = $duration / 2;

        // prendo il frame e lo salvo
        $cli = FFMPEG_LIB.' -y -i '.$filePath.' -f mjpeg -vframes 1 -ss '.$timeToSnap.' '.storage_path('app/public/video/uploads/').$filename.'-thumb.jpg';
        exec($cli);

        // salvo la path del frame
        $thumbPath = 'video/uploads/'.$filename.'-thumb.jpg';

      } else {
        // formato non supportato
        $request->session()->flash('error', 'File format not supported!');
        return back();
      }

      $el = new VideoLibrary;
      $el->title = $request->input('title');
      $el->file_type = $fileType;
      $el->duration = $duration;
      $el->path = $path;
      $el->thumb = $thumbPath;
      $el->save();

      $request->session()->flash('success', 'Media uploaded!');
      return back();

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $video = VideoLibrary::find($id);
        Storage::delete('app/public/'.$video->path);
        Storage::delete('app/public/'.$video->thumb);
        $video->delete();

        session()->flash('success', 'Video Deleted!');
        return redirect('admin/video-library');

    }
}
