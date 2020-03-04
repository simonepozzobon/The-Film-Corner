<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\App;
use App\User;
use App\Session;
use App\Network;
use App\Propaganda\Age;
use App\Propaganda\Clip;
use App\Propaganda\Genre;
use App\Propaganda\Topic;
use App\Propaganda\People;
use App\Propaganda\Period;
use App\Propaganda\Format;
use App\Propaganda\Library;
use App\Propaganda\Hashtag;
use App\Propaganda\Exercise;
use App\Propaganda\Challenge;
use App\Propaganda\ParatextType;
use App\Propaganda\ChallengeLibrary;
use App\Propaganda\ChallengeLibraryMedia;

use Illuminate\Http\Request;
use App\Notifications\SharedSession;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

define('FFMPEG_LIB', '/usr/local/bin/ffmpeg');

class PropagandaController extends Controller
{
    public function test()
    {
        $clip = $this->get_exercise_single(23, 1, null, true);
        dd($clip);
    }

    public function get_search_options()
    {
        $periods = Period::all();
        $genres = Genre::all();
        $formats = Format::all();
        $ages = Age::all();
        $topics = Topic::all();
        $peoples = People::all();
        $hashtags = Hashtag::all();

        return [
            'success' => true,
            'options' => [
                'periods' => $periods,
                'genres' => $genres,
                'formats' => $formats,
                'ages' => $ages,
                'topics' => $topics,
                'peoples' => $peoples,
                'topics' => $topics,
            ]
        ];
    }

    public function get_clips()
    {
        $periods = Period::with('clips.period', 'clips.format', 'clips.age', 'clips.directors', 'clips.peoples', 'clips.topics', 'clips.captions')->get();

        return [
            'success' => true,
            'periods' => $periods,
        ];
    }

    public function get_clip_single($id, $token = null)
    {
        $clip = Clip::with('period', 'format', 'age', 'directors', 'details', 'peoples', 'topics', 'captions', 'paratexts.type', 'paratexts.medias', 'libraries.exercise')->where('id', $id)->first();
        $exercises = collect();

        if ($clip->exercise_1 == 1) {
            $exercise = Exercise::find(1);
            $exercises->push($exercise);
        }

        if ($clip->exercise_2 == 1) {
            $exercise = Exercise::find(2);
            $exercises->push($exercise);
        }

        if ($clip->exercise_3 == 1) {
            $exercise = Exercise::find(3);
            $exercises->push($exercise);
        }

        // foreach ($clip->libraries as $key => $library) {
        //     $exercise = $library->exercise;
        //     $exercises->push($library->exercise);
        // }
        //
        // dd($exercisesLib);

        $clip->exercises = $exercises;

        $clip = $this->format_paratexts($clip);

        return [
            'success' => true,
            'clip' => $clip,
        ];
    }

    public function format_paratexts($clip)
    {
        $types = ParatextType::all();
        $clipId = $clip->id;
        $types = $types->filter(
            function ($type, $key) use ($clipId) {

                $paratexts = $type->paratext()->with('clip', 'medias')->get();
                $paratexts = $paratexts->filter(
                    function ($paratext, $pKey) use ($clipId) {
                        $clips = $paratext->clip;

                        $clips = $clips->filter(
                            function ($cClip, $cKey) use ($clipId) {
                                return $cClip->id == $clipId;
                            }
                        );

                        $paratext->clip = $clips;
                        return $paratext->clip->count() > 0;
                    }
                );
                $type->paratext = $paratexts;
                return $type->paratext->count() > 0;
            }
        );

        $clip->paratexts_formatted = $types;
        return $clip;
    }

    public function get_exercise_single($id, $exercise_id, $token = null, $isTest = false)
    {
        $get_clip = $this->get_clip_single($id);

        $user = $isTest ? User::find(2) : Auth::user();
        // $user = User::find(2);

        $clip = $get_clip['clip'];
        $app = App::find(19);

        switch ($exercise_id) {
        case 1:
            $app = App::find(19);
            break;
        case 2:
            $app = App::find(20);
            break;
        case 3:
            $app = App::find(21);
            break;
        }

        $sessions = $user->sessions()->where(
            [
                ['app_id', $app->id],
                ['is_empty', '!=', 1]
            ]
        )->get();

        if ($exercise_id == 1) {
            $library = $clip->libraries()->with('exercise', 'medias.library_captions')->first();
            $exercise = $clip->exercises->filter(
                function ($exercise, $key) use ($exercise_id) {
                    return $exercise->id == $exercise_id;
                }
            )->first();

            $medias = $library->medias->transform(
                function ($media, $key) {
                    $url = Storage::disk('local')->url($media->url);
                    $media->url = $url;
                    $media->captions = $media->library_captions;
                    return $media;
                }
            );

            $library->medias = $medias;
            // dd($library->medias);

            $exercise->library = $library;
        } else {
            $exercise = collect();
            $exercises = $clip->exercises;
            foreach ($exercises as $key => $item) {
                if ($item->id == $exercise_id) {
                    $exercise = $item;
                }
            }
        }

        if (!$token || $token == false) {
            $session = new Session();
            $session->user_id = Auth::user() ? Auth::user()->id : 1;
            $session->app_id = $app->id;
            $session->title = 'empty';
            $session->token = uniqid();
            $session->content = json_encode([]);
            $session->save();
            $session->refresh();
            $session->app = $session->app;
        } else if ($token == 'navigation') {
            $session = null;
        } else {
            $session = Session::where('token', $token)->with('app')->first();
        }

        return [
            'success' => true,
            'clip' => $clip,
            'exercise' => $exercise,
            'session' => $session,
            'sessions' => $sessions,
        ];
    }

    public function upload_challenge_content(Request $request)
    {
        $media = new ChallengeLibraryMedia();
        $media->challenge_library_id = $request->challenge_id;
        $media->title = $request->title;

        $file = $request->file('media');
        $extension = $file->getClientOriginalExtension();
        $original_name = $file->getClientOriginalName();

        $filename = uniqid() . '.' . $extension;
        $path = 'public/propaganda/users';
        $src = $file->storeAs($path, $filename);

        $media->url = Storage::disk('local')->url($src);
        $media->library_type_id = isset($request->library_type_id) ? $request->library_type_id : 0;
        $media->save();

        $media = $this->generate_thumbnail($media);

        return [
            'success' => true,
            'media' => $media,
        ];
    }

    public function get_challenge($id)
    {
        $challenge = Challenge::find($id);
        $library = ChallengeLibrary::where('challenge_id', $id)->with('medias')->first();

        return [
            'success' => true,
            'challenge' => $challenge,
            'library' => $library,
        ];
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

    public function test_conversion()
    {
        $media = ChallengeLibraryMedia::find(1);

        $this->generate_thumbnail($media);
    }

    public function generate_thumbnail($media)
    {

        if (!$media->thumb || $media->thumb == null) {
            if ($this->endsWith($media->url, '.mp4')) {
                // dump('è un video');
                $globalPath = Storage::disk('local')->getDriver()->getAdapter();
                $filename = str_replace('.mp4', '', str_replace('/storage/propaganda/users/', '', $media->url));
                $path = str_replace('storage', 'public', $media->url);
                $filePath = $globalPath->applyPathPrefix($path);

                $timeToSnap = $this->get_clip_thumb_time($filePath);

                $pathToSave = storage_path('app/public/propaganda/users/').$filename.'.jpg';
                $saveThumb = $this->save_thumb_at_time($filePath, $timeToSnap, $pathToSave);
                $pathToDB = Storage::disk('local')->url('propaganda/users/'.$filename.'.jpg');

                $media->thumb = $pathToDB;
                $media->save();

                $media = $this->crop_thumbnail($media);
            } else if ($media->library_type_id == 2) {
                $filename = str_replace('/storage/propaganda/users/', '', $media->url);
                $path = str_replace('storage', 'public', $media->url);
                $newPath = '/public/propaganda/users/thumb-' . $filename;

                Storage::copy($path, $newPath);
                $src = str_replace('public', 'storage', $newPath);

                $media->thumb = $src;
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

    public function crop_thumbnail($media)
    {
        if ($media->thumb) {
            $globalPath = Storage::disk('local')->getDriver()->getAdapter();
            $path = str_replace('storage', 'public', $media->thumb);
            $filePath = $globalPath->applyPathPrefix($path);

            Image::make($filePath)->fit(
                400, 600, function ($constraint) {
                    $constraint->upsize();
                }
            )->save();
        }

            return $media;
    }
}
