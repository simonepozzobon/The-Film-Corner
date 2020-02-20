<?php

namespace App\Http\Controllers\Api\Admin;

use App\Propaganda\Clip;
use App\Propaganda\Media;
use App\Propaganda\Library;
use App\Propaganda\Exercise;
use App\Propaganda\LibraryMedia;
use App\Propaganda\LibraryCaption;
use App\Propaganda\LibraryType;

use File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class LibraryController extends Controller
{
    public function __construct()
    {
        // set default locale per admin su italiano
        \App::setLocale('it');

        $this->locales = ['en', 'fr', 'it', 'sr', 'ka', 'sl'];
        $this->options_single = ['format', 'period', 'age', 'genre'];
        $this->options_multiple = ['directors', 'peoples', 'topics', 'captions'];
        $this->options_mixed = ['paratexts', 'libraries.exercise', 'libraries.medias.library_captions'];
        $this->options = array_merge($this->options_single, $this->options_multiple, $this->options_mixed);
    }

    public function upload_media(Request $request)
    {
        $exercise = Exercise::find($request->exercise_id);
        $clip = Clip::find($request->clip_id);

        $libraries = $exercise->libraries;
        // return [
        //   'libraries' => $libraries,
        //   'count' => $libraries->count(),
        //   'first' => $libraries[0]
        //
        // ];

        if ($libraries->count() > 0) {
            $library = $libraries[0];
        } else {
            $library = new Library();
            $library->clip_id = $clip->id;
            $library->exercise_id = $exercise->id;
            $library->library_type_id = $request->library_type_id;
            $library->save();
        }

        $upload = $this->uploadFile($request->file('media'));
        $src = $upload['src'];
        $name = $upload['name'];

        $m = new LibraryMedia();
        $m->url = $src;
        $m->library_type_id = $library->library_type_id;
        $m->library_id = $library->id;
        $m->save();

        $current = $m->translateOrNew('it');
        $current->library_media_id = $m->id;
        if ($library->library_type_id != 2) {
            $current->title = $request->title ? $request->title : '';
            $current->description = $request->description ? $request->description : '';
        } else {
            $current->title = $name;
            $current->description = $request->description ? $request->description : '';
        }
        $current->save();

        $m->url = Storage::disk('local')->url($m->url);

        $clip = $clip->fresh($this->options);

        return [
          'clip' => $clip,
          'library' => $library,
          'exercise' => $exercise,
          'media' => $m,
          'upload' => $upload
        ];
    }

    public function destroy_media($id)
    {
        $m = LibraryMedia::find($id);
        $clip = $m->library->clip;
        $m->delete();

        $clip = $clip->fresh($this->options);

        return [
            'success' => true,
            'clip' => $clip,
            'id' => $id,
            'message' => 'eliminato'
        ];
    }

    public function test()
    {
        $exercise = Exercise::find(1);
        $clip = Clip::find(1);
        $library = Library::find(1);
        $m = LibraryMedia::find(3);

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
        $src = $file->storeAs('public/propaganda/libraries', $filename);

        return [
            'src' => $src,
            'name' => $original_name
        ];
    }

    public function upload_caption(Request $request)
    {
        $media = LibraryMedia::find($request->library_media_id);

        if ($media) {
            $caption = new LibraryCaption();
            $caption->library_media_id = $media->id;
            $caption->locale = $request->cap_locale;

            $file = $request->file('cap_file');
            $original_name = $file->getClientOriginalName();
            $filename = uniqid() . '.srt';
            $path = 'public/propaganda/libraries/captions';
            $src = $file->storeAs($path, $filename);
            $src = Storage::disk('local')->url($src);

            $caption->src = $src;
            $caption->save();

            $clip = $media->library->clip;
            $clip = $clip->fresh($this->options);

            return [
                'success' => true,
                'clip' => $clip,
                'caption' => $caption,
                'message' => 'salvato'
            ];
        }

        return [
          'success' => false,
          'message' => 'non trovato',
        ];
    }

    public function destroy_caption(Request $request)
    {
        $caption = LibraryCaption::find($request->id);
        $clip = $caption->library_media->library->clip;
        $caption->delete();

        $clip = $clip->fresh($this->options);

        return [
            'success' => true,
            'clip' => $clip,
            'id' => $request->id,
            'message' => 'eliminato'
        ];
    }

    public function upload_translations(Request $request)
    {
        $translations = json_decode($request->translations);
        $media = LibraryMedia::find($request->library_media_id);

        if ($media) {
            foreach ($translations as $key => $translation) {
                $current = $media->translateOrNew($translation->locale);
                $current->library_media_id = $media->id;
                $current->title = $translation->title ? $translation->title : '';
                $current->description = $translation->description ? $translation->description : '';
                $current->save();
            }

            $clip = $media->library->clip;
            $clip = $clip->fresh($this->options);

            return response()->json(
                [
                    'success' => true,
                    'clip' => $clip,
                    'translations' => $translations,
                    'message' => 'salvato'
                ]
            );
        }

        return [
          'success' => false,
          'message' => 'non trovato',
        ];
    }
}
