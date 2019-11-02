<?php

namespace App\Http\Controllers\Api\Admin;

use App\Propaganda\Age;
use App\Propaganda\Clip;
use App\Propaganda\Media;
use App\Propaganda\Topic;
use App\Propaganda\Genre;
use App\Propaganda\Detail;
use App\Propaganda\Format;
use App\Propaganda\People;
use App\Propaganda\Period;
use App\Propaganda\Hashtag;
use App\Propaganda\Director;
use App\Propaganda\Paratext;
use App\Propaganda\Exercise;
use App\Propaganda\ParatextType;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

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
        $clips = Clip::with('period')->get();

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
        $paraType = ParatextType::all();
        $exercises = Exercise::all();


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
            'paratext_types' => $paraType,
            'exercises' => $exercises,
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
        // $paraType = new ParatextType();
        // $paraType->type = $request->type;
        // $paraType->has_image = $request->has_image == true ? 1 : 0;
        //
        // $paraType->save();
        // return [
        //   'para' => $paraType
        // ];

        return ['deprecata'];
    }

    public function upload_paratext(Request $request)
    {
        $clip = Clip::find($request->clip_id);
        $paraType = ParatextType::find($request->paratext_type_id);

        $file = $this->uploadFile($request->file('file'), $paraType->type);
        // $file = Media::find(2);


        $p = new Paratext();
        $p->paratext_type_id = $paraType->id;
        $p->content = $request->content ? $request->content : 'null';
        $p->media_type = $paraType->type;
        $p->media = Storage::disk('local')->url($file->src);
        $p->save();

        $p->medias()->attach($file);
        $p->clip()->attach($clip);

        return [
          'clip' => $clip,
          'paratext' => $p,
        ];
    }

    public function destroy(Request $request)
    {
        $clip = Clip::find($request->clip_id);
        $paraType = ParatextType::find($request->paratext_type_id);


        $p = Paratext::find($request->paratext_id);
        $p->medias()->detach();
        $p->clip()->detach();
        $p->delete();

        return [
          'id' => $request->paratext_id,
        ];
    }

    public function uploadFile($file, $type)
    {
        $extension = $file->getClientOriginalExtension();
        $original_name = $file->getClientOriginalName();

        $filename = uniqid() . '.' . $extension;
        $path = 'public/propaganda/paratexts/' . $type;

        $src = $file->storeAs($path, $filename);

        $m = new Media();
        $m->media_type = $type;
        $m->name = $original_name;
        $m->src = $src;
        $m->save();

        return $m;
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
