<?php

namespace App\Http\Controllers\Api;

use App\Propaganda\Clip;
use App\Propaganda\Period;
use App\Propaganda\Library;
use App\Propaganda\Exercise;
use App\Propaganda\ParatextType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PropagandaController extends Controller
{
    public function test()
    {
        $clip = $this->get_exercise_single(19, 1);
        dd($clip);
    }

    public function get_clips()
    {
        $periods = Period::with('clips.period', 'clips.format', 'clips.age', 'clips.directors', 'clips.peoples', 'clips.topics')->get();

        return [
            'success' => true,
            'periods' => $periods,
        ];
    }

    public function get_clip_single($id)
    {
        $clip = Clip::with('period', 'format', 'age', 'directors', 'details', 'peoples', 'topics', 'paratexts.type', 'paratexts.medias', 'libraries.exercise')->where('id', $id)->first();
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

    public function get_exercise_single($id, $exercise_id)
    {
        $get_clip = $this->get_clip_single($id);
        $clip = $get_clip['clip'];

        if ($exercise_id == 1) {
            $library = $clip->libraries()->with('exercise', 'medias')->first();
            $exercise = $clip->exercises->filter(
                function ($exercise, $key) use ($exercise_id) {
                    return $exercise->id == $exercise_id;
                }
            )->first();

            $medias = $library->medias->transform(
                function ($media, $key) {
                    $url = Storage::disk('local')->url($media->url);
                    $media->url = $url;
                    return $media;
                }
            );

            $library->medias = $medias;

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



        return [
            'success' => true,
            'clip' => $clip,
            'exercise' => $exercise,
        ];
    }
}
