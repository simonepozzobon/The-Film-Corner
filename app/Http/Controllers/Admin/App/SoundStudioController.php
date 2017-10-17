<?php

namespace App\Http\Controllers\Admin\App;

use App\AudioLibrary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SoundStudioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => 'logout']);
    }

    public function view()
    {
      return view('admin.apps.sound-studio.index', compact('items'));
    }

    public function index()
    {
      $audios = AudioLibrary::all();
      return response(compact('audios'));
    }

    public function store(Request $request)
    {
      // definisco la library di FFMPEG
      define('FFMPEG_LIB', '/usr/local/bin/ffmpeg');
      define('FFPROBE_LIB', '/usr/local/bin/ffprobe');

      // definisco la path global
      $globalPath = Storage::disk('local')->getDriver()->getAdapter();

      // Get The File
      $file = $request->file('audio');

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

      if (in_array($ext, $audio)) {
        $fileType = 'audio';
        $path = storage_path('app/public/audio/uploads');

        // Salvo il file nella cartella tmp per la conversione
        $file = $file->storeAs('public/audio/tmp', $filename.'.'.$ext);
        $filePath = $globalPath->applyPathPrefix($file);

        // eseguo il comando FFMPEG
        $cli = FFMPEG_LIB.' -i '.$filePath.' -codec:a libmp3lame -qscale:a 2 '.storage_path('app/public/audio/uploads/').$filename.'.mp3';
        exec($cli);

        // Cancello il file temporaneo
        Storage::delete($file);

        // salvo la path del file converito per il DB
        $path = 'audio/uploads/'.$filename.'.mp3';

        // get duration
        $filePath = $globalPath->applyPathPrefix('public/'.$path);
        $cli = FFPROBE_LIB.' -i '.$filePath.' -show_entries format=duration -v quiet -of csv="p=0"';
        $duration =  exec($cli);

      } else {
        // formato non supportato
        $request->session()->flash('error', 'File format not supported!');
        return back();
      }

      $el = new AudioLibrary;
      $el->title = $request->input('title');
      $el->file_type = $fileType;
      $el->duration = $duration;
      $el->path = $path;
      $el->save();

      $request->session()->flash('success', 'Media uploaded!');
      return back();

    }

    public function destroy($id)
    {
        $audio = AudioLibrary::find($id);
        Storage::delete('app/public/'.$audio->path);
        $audio->delete();

        session()->flash('success', 'Audio Deleted!');
        return redirect()->route('app.sound-studio.view');

    }
}
