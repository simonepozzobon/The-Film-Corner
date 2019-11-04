<?php

namespace App\Http\Controllers\Api;

use App\Propaganda\Clip;
use App\Propaganda\Period;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PropagandaController extends Controller
{
    public function get_clips()
    {
        $periods = Period::with('clips.period', 'clips.age', 'clips.directors', 'clips.peoples', 'clips.topics')->get();

        return [
            'success' => true,
            'periods' => $periods,
        ];
    }
}
