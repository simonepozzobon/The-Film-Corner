<?php

namespace App\Http\Controllers\Api\Admin;

use App\Propaganda\Clip;
use App\Propaganda\Period;
use App\Propaganda\Director;
use App\Propaganda\Genre;
use App\Propaganda\Format;
use App\Propaganda\Age;
use App\Propaganda\Topic;
use App\Propaganda\People;
use App\Propaganda\Hashtag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClipsController extends Controller
{
    public function get_clips()
    {
        $clips = Clip::all();

        return [
            'success' => true,
            'clips' => $clips
        ];
    }

    public function get_initials()
    {
        $periods = Period::all();
        $directors = Director::all();
        $genres = Genre::all();
        $formats = Format::all();
        $ages = Age::all();
        $topics = Topic::all();
        $peoples = People::all();
        $hashtags = Hashtag::all();


        return [
            'success' => true,
            'periods' => $periods,
            'directors' => $directors,
            'genres' => $genres,
            'formats' => $formats,
            'ages' => $ages,
            'topics' => $topics,
            'peoples' => $peoples,
            'hashtags' => $hashtags,
        ];
    }
}
