<?php

namespace App\Http\Controllers\Api\Admin;

use App\Propaganda\Clip;
use App\Propaganda\Period;
use App\Propaganda\Director;
use App\Propaganda\Genre;
use App\Propaganda\Format;
use App\Propaganda\Detail;
use App\Propaganda\Age;
use App\Propaganda\Topic;
use App\Propaganda\People;
use App\Propaganda\Hashtag;
use App\Propaganda\ParatextType;
use App\Propaganda\Paratext;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ClipsController extends Controller
{
    public function test()
    {
        $request = new Request();
        $request->replace(
            [
                'title'=> 'fdjdjgldkf',
                'video'=> 'no',
                'period'=> uniqid(),
                'year'=> '1900',
                'format'=> uniqid(),
                'age'=> uniqid(),
                'genre'=> uniqid(),
                'nationality'=> 'ital',
            ]
        );

        $this->store($request);
    }

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

    public function store(Request $request)
    {
        $clip = new Clip();
        $options = ['format', 'period', 'age', 'genre'];
        $clip->video = 'no';
        $clip->year = $request->year;
        $clip->title = $request->title;
        $clip->nationality = $request->nationality;

        foreach ($options as $key => $value) {
            $model = ucwords('App\\Propaganda\\'.$value);
            $result = $model::where('title', '=', $request->{$value})->first();
            if ($result) {
                $clip->{$value.'_id'} = $result->id;
            } else {
                $obj = \App::make($model);
                $columns = $obj->getTableColumns();

                foreach ($columns as $key => $column) {
                    if ($column != 'id' && $column != 'created_at' && $column != 'updated_at') {
                        if ($request->input($column, false) == false) {
                            // va riempita con un random
                            $obj->{$column} = random_int(1, 100);
                        } else {
                            $obj->{$column} = $request->{$value};
                        }
                    }
                }
                $obj->save();
                $clip->{$value.'_id'} = $obj->id;
            }
        }
        $clip->save();

        return [
          'clip' => $clip,
        ];
    }

    public function store_details(Request $request)
    {
        $detail = new Detail();
        $detail->clip_id = $request->clip_id;
        $detail->abstract = $request->abstract;
        $detail->tech_info = $request->tech_info;
        $detail->historical_context = $request->historical_context;
        $detail->foods = $request->food;

        $detail->save();
        return [
          'detail' => $detail
        ];
    }

    public function store_paratexts(Request $request)
    {
        $paraType = new ParatextType();
        $paraType->type = $request->type;
        $paraType->has_image = $request->has_image == true ? 1 : 0;

        $paraType->save();
        return [
          'para' => $paraType
        ];
    }

    public function add_paratext_file(Request $request)
    {
        $p = new Paratext();
        $p->paratext_type_id = $request->para_id;
        $p->img = 'file';
        $p->content = 'è un file';
        $p->save();

        return [
          'para' => $p
        ];
    }
    public function add_paratext_content(Request $request)
    {
        $p = new Paratext();
        $p->paratext_type_id = $request->para_id;
        $p->img = 'content';
        $p->content = 'è un content';
        $p->save();

        return [
          'para' => $p
        ];
    }
}
