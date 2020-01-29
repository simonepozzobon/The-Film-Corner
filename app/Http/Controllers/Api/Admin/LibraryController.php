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
        if ($request->is_new == 1) {
            $library = new Library();
            $library->clip_id = $clip->id;
            $library->exercise_id = $exercise->id;
            $library->library_type_id = $request->library_type_id;
            $library->save();
        } else {
            $library = Library::find($request->library_id);
        }

        $src = $this->uploadFile($request->file('media'));

        $m = new LibraryMedia();
        $m->title = $request->title;
        $m->url = $src;
        $m->library_type_id = $library->library_type_id;
        $m->library_id = $library->id;
        $m->save();

        $m->url = Storage::disk('local')->url($m->url);

        return [
          'clip' => $clip,
          'library' => $library,
          'exercise' => $exercise,
          'media' => $m,
        ];
    }

    public function destroy_media($id)
    {
        $m = LibraryMedia::find($id);
        $m->delete();

        return [
            'id' => $id,
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

        return $src;
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
