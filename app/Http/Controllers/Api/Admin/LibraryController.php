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
use Intervention\Image\Facades\Image;
use \Done\Subtitles\Subtitles;

define('FFMPEG_LIB', '/usr/local/bin/ffmpeg');

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

    public function test_web()
    {
        $this->generate_thumbnails();
        dd('test');
    }

    public function generate_thumbnails()
    {
        $medias = LibraryMedia::all();

        foreach ($medias as $key => $media) {
            $media = $this->generate_thumbnail($media);
            if ($this->endsWith($media->url, '.mp4')) {
                $media = $this->crop_thumbnail($media);
            }
        }
    }

    public function crop_thumbnail($media)
    {
        if ($media->thumb) {
            $globalPath = Storage::disk('local')->getDriver()->getAdapter();
            $path = str_replace('storage', 'public', $media->thumb);
            $filePath = $globalPath->applyPathPrefix($path);

            Image::make($filePath)->fit(
                1920, 1080, function ($constraint) {
                    $constraint->upsize();
                }
            )->save();
        }

        return $media;
    }

    // https://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php
    public function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    public function generate_thumbnail($media)
    {

        if (!$media->thumb || $media->thumb == null) {
            if ($this->endsWith($media->url, '.mp4')) {
                // dump('è un video');
                $globalPath = Storage::disk('local')->getDriver()->getAdapter();
                $filename = str_replace('.mp4', '', str_replace('public/propaganda/libraries/', '', $media->url));

                $filePath = $globalPath->applyPathPrefix($media->url);

                $timeToSnap = $this->get_clip_thumb_time($filePath);

                $pathToSave = storage_path('app/public/propaganda/libraries/').$filename.'.jpg';
                $saveThumb = $this->save_thumb_at_time($filePath, $timeToSnap, $pathToSave);
                $pathToDB = Storage::disk('local')->url('propaganda/libraries/'.$filename.'.jpg');

                $media->thumb = $pathToDB;
                $media->save();

                $media = $this->crop_thumbnail($media);
            }
        }

        return $media;
    }

    public function get_clip_thumb_time($path)
    {
        $cli = FFMPEG_LIB.' -i '.$path.' 2>&1 | grep \'Duration\' | cut -d \' \' -f 4 | sed s/,//';
        $duration =  exec($cli);

        $duration = explode(":", $duration);
        $duration = $duration[0]*3600 + $duration[1]*60+ round($duration[2]);
        $timeToSnap = $duration / 2;

        return $timeToSnap;
    }

    public function save_thumb_at_time($filePath, $timeToSnap, $pathToSave)
    {
        // prendo il frame e lo salvo
        $cli = FFMPEG_LIB.' -y -i '.$filePath.' -f mjpeg -vframes 1 -ss '.$timeToSnap.' '.$pathToSave;
        exec($cli);

        return $cli;
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

        $m = $this->generate_thumbnail($m);


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
            $path = 'public/propaganda/libraries/captions';

            $extension = $file->getClientOriginalExtension();

            if ($extension == 'srt') {
                $filename = uniqid() . '.srt';

            } else if ($extension == 'vtt') {
                $filename = uniqid() . '.vtt';
            }

            $src = $file->storeAs($path, $filename);
            $src = Storage::disk('local')->url($src);
            $globalPath = Storage::disk('local')->getDriver()->getAdapter();
            $srt = str_replace('/storage', 'public', $src);
            $filePath = $globalPath->applyPathPrefix($srt);

            if ($extension == 'srt') {
                $destPath = str_replace('.srt', '.vtt', $filePath);
                $subtitles = Subtitles::convert($filePath, $destPath);
                $caption->src = str_replace('.srt', '.vtt', $src);
            } else if ($extension == 'vtt') {
                $caption->src = $src;
            }

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
