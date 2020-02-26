<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\App;
use App\User;
use App\Session;
use App\Network;
use App\Propaganda\Clip;
use App\Propaganda\Period;
use App\Propaganda\Library;
use App\Propaganda\Exercise;
use App\Propaganda\Challenge;
use App\Propaganda\ParatextType;
use App\Propaganda\ChallengeLibrary;
use App\Propaganda\ChallengeLibraryMedia;

use Illuminate\Http\Request;
use App\Notifications\SharedSession;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class PropagandaController extends Controller
{
    public function test()
    {
        $clip = $this->get_exercise_single(23, 1, null, true);
        dd($clip);
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

        $media->url = $src;
        $media->library_type_id = 0;
        $media->save();

        return $media;
    }

    public function get_challenge($id)
    {
        $challenge = Challenge::find($id);
        $libraries = ChallengeLibrary::where('challenge_id', $id)->with('medias')->get();

        return [
            'success' => true,
            'challenge' => $challenge
        ];
    }
}
