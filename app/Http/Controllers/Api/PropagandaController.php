<?php

namespace App\Http\Controllers\Api;

use App\Propaganda\Clip;
use App\Propaganda\Period;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PropagandaController extends Controller
{
    public function test()
    {
        $clip = $this->get_clip_single(41);
        dd($clip['clip']->exercises);
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
        $clip = Clip::with('period', 'format', 'age', 'directors', 'peoples', 'topics', 'paratexts', 'libraries.exercise')->where('id', $id)->first();

        $exercises = collect();
        foreach ($clip->libraries as $key => $library) {
            $exercises->push($library->exercise);
        }
        $clip->exercises = $exercises;

        return [
            'success' => true,
            'clip' => $clip,
        ];
    }
}
