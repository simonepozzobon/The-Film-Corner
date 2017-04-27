<?php

namespace App\Http\Controllers\Admin;

use FFMpeg;
use App\VideoLibrary;
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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
      $bins = [
          'ffmpeg.binaries'  => '/usr/local/bin/ffmpeg', // the path to the FFMpeg binary
          'ffprobe.binaries' => '/usr/local/bin/ffprobe', // the path to the FFProbe binary
      ];

        session()->flash('success',$request);

        // // Init FFmpeg
        // $ffmpeg = FFMpeg\FFMpeg::create($bins);
        //
        // // get the file
        // $file = $request->file('video');
        // $fileExt = $file->getClientOriginalExtension();
        // $filename = uniqid();
        //
        // // salvo il file così com'è
        // $file = $file->storeAs('public/video', "$filename.$fileExt");
        //
        // // Set the absolute path to storage folder
        // $globalPath = Storage::disk('local')->getDriver()->getAdapter();
        //
        // // Creo l'oggetto video
        // $filePath = $globalPath->applyPathPrefix($file);
        // $video = $ffmpeg->open($filePath);
        //
        // // Prendo la durata del video
        // $ffprobe = FFMpeg\FFProbe::create($bins);
        // $length = $ffprobe
        //     ->format($filePath) // extracts file informations
        //     ->get('duration');
        //
        // // Definisco il percorso per per il frame
        // $thumbPath = $globalPath->applyPathPrefix("public/video/$filename.jpg");
        //
        // // Estraggo il frame
        // if ($length > 10) {
        //   $thumb = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(10))->save($thumbPath);
        // } else {
        //   $middle = $length / 2;
        //   $thumb = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds($middle))->save($thumbPath);
        // }
        //
        // //scrivo la path pubblica senza esporre le cartelle del server
        // $thumbPublic = Storage::url("video/$filename.jpg");
        //
        // // Converto il video nel formato mp4
        // $format = new FFMpeg\Format\Video\X264('aac', 'libx264');
        //
        // // Da lavorare, deve mandarmi indietro il progress di quello che sta succedendo
        // $format->on('progress', function ($video, $format, $percentage) {
        //   session()->flash('info', "$percentage % transcoded");
        // });
        //
        // // Setto i parametri aggiuntivi per la conversione
        // $format->getExtraParams();
        // $format->setAudioChannels(2)->setAudioKiloBitrate(256);
        //
        // // Setto il formato unico per i video 1920x1080
        // $video->filters()
        //       ->pad(new FFMpeg\Coordinate\Dimension(1920, 1080));
        //
        // // Salvo il file
        // $videoPath = $globalPath->applyPathPrefix("public/video/$filename.mp4");
        // $video->save($format, $videoPath);
        // $videoPublic = Storage::url("video/$filename.mp4");
        //
        // // se il file non è un mp4 allora elimino la versione originale lasciando solo quella convertita
        // if ($fileExt != 'mp4') {
        //   Storage::delete($file);
        // }
        //
        // // Salvo nel DB
        // $video = new VideoLibrary;
        // $video->title = $request->input('title');
        // $video->path_x264 = $videoPublic;
        // $video->thumb = $thumbPublic;
        // $video->save();
        //
        // $request->session()->flash('success', 'Video uploaded!');
        //
        // return response()->json(['success' => true]);
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
        Storage::delete($video->path);
        Storage::delete($video->thumb);
        $video->delete();

        $request->session()->flash('success', 'Video Deleted!');
        return redirect('admin/video-library');

    }
}
