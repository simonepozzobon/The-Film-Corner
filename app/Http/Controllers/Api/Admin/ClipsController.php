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
                // 'title'=> 'fdjdjgldkf',
                // 'video'=> 'no',
                // 'period'=> "Second World War",
                // 'year'=> '1900',
                // 'format'=> "4/3",
                // 'age'=> "14-18",
                // 'genre'=> "tuo",
                // 'nationality'=> 'ital',
                // 'directors' => ["Gianni","Beppe","giovanni"],
                'clip_id' => 20,
                'abstract' => uniqid(),
                'tech_info' => uniqid(),
                'historical_context' => uniqid(),
                'food' => uniqid(),
            ]
        );

        $this->store_details($request);

        // $this->store($request);
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

    public function upload_video($file)
    {
        $extension = $file->getClientOriginalExtension();
        $original_name = $file->getClientOriginalName();

        $filename = uniqid() . '.' . $extension;
        $path = 'public/propaganda/clips';

        $src = $file->storeAs($path, $filename);
        $src = Storage::disk('local')->url($src);
        return $src;
    }

    public function store(Request $request)
    {
        $options_single = ['format', 'period', 'age', 'genre'];
        $options_multiple = ['directors', 'peoples', 'topics'];


        $clip = new Clip();
        $clip->video = $request->hasFile('video') ? $this->upload_video($request->file('video')) : 'no';
        $clip->year = $request->year;
        $clip->title = $request->title;
        $clip->nationality = $request->nationality;

        foreach ($options_single as $key => $value) {
            $clip->{$value.'_id'} = $this->check_single_option($value, $request);
        }
        $clip->save();

        foreach ($options_multiple as $key => $value) {
            $saved = $this->check_multiple_option($value, $request, $clip);
        }

        $clip = $clip->fresh(array_merge($options_single, $options_multiple));

        return [
          'success' => true,
          'clip' => $clip,
        ];
    }

    public function check_single_option($name, $request)
    {
        $model = ucwords('App\\Propaganda\\'.$name);

        $result = $model::where('title', '=', $request->{$name})->first();
        if ($result) {
            return $result->id;
        } else {
            $obj = \App::make($model);
            $columns = $obj->getTableColumns();

            foreach ($columns as $key => $column) {
                if ($column != 'id' && $column != 'created_at' && $column != 'updated_at') {
                    if ($request->input($column, false) == false) {
                        // va riempita con un random
                        $obj->{$column} = random_int(1, 100);
                    } else {
                        $obj->{$column} = $request->{$name};
                    }
                }
            }
            // $obj->save();
            return $obj->id;
        }
    }

    public function check_multiple_option($name, $request, $clip)
    {
        $clip->{$name}()->detach();
        $singular = rtrim($name, 's');
        $model = ucwords('App\\Propaganda\\'.$singular);

        $results = collect();

        if (isset($request->{$name})) {
            foreach (json_decode($request->{$name}) as $key => $value) {
                $field = $name == 'directors' ? 'name' : 'title';
                $result = $model::where($field, '=', $value)->first();

                if ($result) {
                    $results->push($result);
                } else {
                    $obj = \App::make($model);
                    $obj->{$field} = $value;

                    $obj->save();
                    $results->push($obj);
                }

                $clip->{$name}()->attach($result);
            }
        }
        return true;
    }

    public function store_details(Request $request)
    {
        $clip = Clip::find($request->clip_id);
        if ($clip) {
            if ($clip->details->count() > 0) {
                $detail = $clip->details->first();
            } else {
                $detail = new Detail();
            }
            $detail->clip_id = $request->clip_id;
            $detail->abstract = $request->abstract;
            $detail->tech_info = $request->tech_info;
            $detail->historical_context = $request->historical_context;
            $detail->foods = $request->food;
            $detail->save();

            return [
                'success' => true,
                'detail' => $detail
            ];
        } else {
            return [
                'success' => false,
            ];
        }
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
