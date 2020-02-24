<?php

namespace App\Http\Controllers\Api;

use App\Propaganda\Clip;
use App\Propaganda\Period;
use App\Propaganda\ParatextType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PropagandaController extends Controller
{
    public function test()
    {
        $clip = $this->get_clip_single(19);
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
        $clip = Clip::with('period', 'format', 'age', 'directors', 'peoples', 'topics', 'paratexts.type', 'paratexts.medias', 'libraries.exercise')->where('id', $id)->first();

        $exercises = collect();
        foreach ($clip->libraries as $key => $library) {
            $exercises->push($library->exercise);
        }
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

        $exercise = collect();
        $exercises = $clip->exercises;
        foreach ($exercises as $key => $item) {
            if ($item->id == $exercise_id) {
                $exercise = $item;
            }
        }

        return [
            'success' => true,
            'clip' => $clip,
            'exercise' => $exercise,
        ];
    }
}
