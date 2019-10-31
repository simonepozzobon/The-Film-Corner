<?php

namespace App\Http\Controllers\Api\Admin;

use App\Propaganda\Clip;
use App\Propaganda\Media;
use App\Propaganda\Library;
use App\Propaganda\Exercise;
use App\Propaganda\LibraryMedia;
use App\Propaganda\LibraryType;

use File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class LibraryController extends Controller
{
    public function upload_media()
    {
        $exercise = Exercise::find($request->exercise_id);
        $clip = Clip::find($request->clip_id);
        if ($request->is_new == true) {
            $library = new Library();
            $library->clip_id = $clip->id;
            $library->exercise_id = $exercise->id;
            $library->library_type_id = $request->library_type_id;
            $library->save();
        } else {
            // $library = Library::find($request->)
        }

        $src = $this->uploadFile($request->file('media'));

        $m = new LibraryMedia();
        $m->title = $request->title;
        $m->url = $src;
        $m->library_type_id = $library->library_type_id;
        $m->library_id = $library->id;
        $m->save();

        return [
          'clip' => $clip,
          'library' => $library,
          'exercise' => $exercise,
          'media' => $m,
        ];
    }
    public function test()
    {
        $exercise = Exercise::find(1);
        $clip = Clip::find(1);
        $library = Library::find(1);
        $m = LibraryMedia::find(1);

        $m->url = Storage::disk('local')->url($m->url);

        return [
            'clip' => $clip,
            'library' => $library,
            'exercise' => $exercise,
            'media' => $m,
        ];
    }

    public function uploadFile($file)
    {
        $extension = $file->getClientOriginalExtension();
        $original_name = $file->getClientOriginalName();

        $filename = uniqid() . '.' . $extension;
        $path = '';
        $src = $file->storeAs('public/propaganda/libraries/', $filename);

        return $src;
    }
}
