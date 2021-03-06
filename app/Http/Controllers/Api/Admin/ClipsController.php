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
use App\Propaganda\Caption;
use App\Propaganda\Hashtag;
use App\Propaganda\Director;
use App\Propaganda\Paratext;
use App\Propaganda\Exercise;
use App\Propaganda\ParatextType;
use App\Propaganda\ClipTranslation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Intervention\Image\Facades\Image;
use \Done\Subtitles\Subtitles;

define('FFMPEG_LIB', '/usr/local/bin/ffmpeg');

class ClipsController extends Controller
{

    public function __construct()
    {
        // set default locale per admin su italiano
        \App::setLocale('it');

        $this->locales = ['en', 'fr', 'it', 'sr', 'ka', 'sl'];
        // $this->options_single = ['format', 'period', 'age', 'genre'];
        // $this->options_multiple = ['directors', 'peoples', 'topics', 'captions'];
        // $this->options = array_merge($this->options_single, $this->options_multiple);

        $this->options_single = ['format', 'period', 'age', 'genre'];
        $this->options_multiple = ['directors', 'peoples', 'topics'];
        $this->options_multiple_not_translated = ['captions'];
        $this->options_mixed = ['paratexts', 'libraries.exercise', 'libraries.medias.library_captions'];
        $this->options = array_merge($this->options_single, $this->options_multiple, $this->options_mixed, $this->options_multiple_not_translated);
    }

    public function test()
    {
        // $clips = $this->generate_thumbnails();
        // $medias = LibraryMedia::all();

        dd('commentato');
        // $request = new Request();
        // $request->replace(
        //     [
        //         // 'title'=> 'fdjdjgldkf',
        //         // 'video'=> 'no',
        //         // 'period'=> "Second World War",
        //         // 'year'=> '1900',
        //         // 'format'=> "4/3",
        //         // 'age'=> "14-18",
        //         // 'genre'=> "tuo",
        //         // 'nationality'=> 'ital',
        //         // 'directors' => ["Gianni","Beppe","giovanni"],
        //         // 'clip_id' => 20,
        //         // 'abstract' => uniqid(),
        //         // 'tech_info' => uniqid(),
        //         // 'historical_context' => uniqid(),
        //         // 'food' => uniqid(),
        //         'id' => 16,
        //         'period' => 'asfdsaasfasfdsaf',
        //         'directors' => json_encode(['Renny Arlin', 'gianni']),
        //         'peoples' => json_encode(['Rupert Friend','Richard Coyle','Emanuelle Chriqui']),
        //         'year' => 2011,
        //         'format' => uniqid(),
        //         'age' => '14 - 18',
        //         'genre' => 'guerra',
        //         'nationality' => 'USA',
        //         'topics' => json_encode(['confini','conflitto','guerra','giornalista','Indipendenza']),
        //     ]
        // );
        //
        // // $this->store_details($request);
        //
        // // $this->get_initials_edit(39);
        // $this->store_informations($request);
    }

    public function generate_thumbnails()
    {
        $clips = Clip::all();

        foreach ($clips as $key => $clip) {
            // echo '----- inizio clip -> '.$clip->id;
            $clip = $this->generate_thumbnail($clip);
            $clip = $this->crop_thumbnail($clip);
            // echo 'immagine croppata';
            // echo '----- inizio clip -> '.$clip->id;
        }

        return $clips;
    }

    public function crop_thumbnail($clip)
    {
        if ($clip->thumb) {
            $globalPath = Storage::disk('local')->getDriver()->getAdapter();
            $path = str_replace('storage', 'public', $clip->thumb);
            $filePath = $globalPath->applyPathPrefix($path);

            Image::make($filePath)->fit(
                1920, 1080, function ($constraint) {
                    $constraint->upsize();
                }
            )->save();
        }

        return $clip;
    }

    public function generate_thumbnail($clip, $destFolder = 'propaganda/clips/')
    {
        if (!$clip->thumb || $clip->thumb == null) {
            if ($clip->video != 'no') {
                $globalPath = Storage::disk('local')->getDriver()->getAdapter();
                // dump($clip->video);
                $path = str_replace('storage', 'public', $clip->video);
                $filename = str_replace('.mp4', '', str_replace('/storage/propaganda/clips/', '', $clip->video));
                // dump($filename);
                $filePath = $globalPath->applyPathPrefix($path);

                $timeToSnap = $this->get_clip_thumb_time($filePath);
                $pathToSave = storage_path('app/public/propaganda/clips/').$filename.'.jpg';

                $saveThumb = $this->save_thumb_at_time($filePath, $timeToSnap, $pathToSave);

                $pathToDB = Storage::disk('local')->url('propaganda/clips/'.$filename.'.jpg');
                $clip->thumb = $pathToDB;
                $clip->save();
                // dump($pathToDB);
                // echo 'completato thumb -> '.$clip->id;
            }
        }
        // else {
        //     // echo 'già fatto thumb -> '.$clip->id;
        // }

        return $clip;
    }

    public function get_filename($arr, $str)
    {
        foreach ($arr as $key => $item) {
            $str = str_replace($key, '', $str);
        }

        return $str;
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

    public function upload_caption(Request $request)
    {
        $clip = Clip::find($request->clip_id);
        if ($clip) {
            $caption = new Caption();
            $caption->clip_id = $clip->id;
            $caption->locale = $request->cap_locale;

            $file = $request->file('cap_file');
            $original_name = $file->getClientOriginalName();
            $path = 'public/propaganda/clips/captions';

            $extension = $file->getClientOriginalExtension();

            if ($extension == 'srt') {
                $filename = uniqid() . '.srt';

            } else if ($extension == 'vtt') {
                $filename = uniqid() . '.vtt';
            }

            $src = $file->storeAs($path, $filename);
            $src = Storage::disk('local')->url($src);
            $globalPath = Storage::disk('local')->getDriver()->getAdapter();
            $srt = str_replace('/storage', 'public', $src);
            $filePath = $globalPath->applyPathPrefix($srt);

            if ($extension == 'srt') {
                $destPath = str_replace('.srt', '.vtt', $filePath);
                $subtitles = Subtitles::convert($filePath, $destPath);
                $caption->src = str_replace('.srt', '.vtt', $src);
            } else if ($extension == 'vtt') {
                $caption->src = $src;
            }

            $caption->save();

            $clip = $clip->fresh($this->options);
            return [
              'success' => true,
              'debug' => $extension,
              'clip' => $clip,
              'caption' => $caption,
              'message' => 'salvato',
            ];
        }

        return [
            'success' => false,
            'message' => 'non trovato',
        ];
    }

    public function destroy_caption(Request $request)
    {
        $caption = Caption::find($request->id);
        $clip = $caption->clip;
        $caption->delete();

        $clip = $clip->fresh($this->options);

        return [
            'success' => true,
            'id' => $request->id,
            'clip' => $clip
        ];
    }

    public function get_clips()
    {
        $clips = Clip::with('period')->get();


        return [
            'success' => true,
            'clips' => $clips
        ];
    }

    public function add_exercise(Request $request)
    {
        $exercise_id = "exercise_$request->exercise_id";
        $clip = Clip::find($request->clip_id);
        if ($clip) {
            $clip->{$exercise_id} = 1;
            $clip->save();

            return [
                'success' => true,
                'clip' => $clip,
            ];
        }

        return [
            'success' => false,
            'message' => 'non trovato',
        ];
    }

    public function remove_exercise(Request $request)
    {
        $exercise_id = "exercise_$request->exercise_id";
        $clip = Clip::find($request->clip_id);
        if ($clip) {
            $clip->{$exercise_id} = 0;
            $clip->save();

            return [
                'success' => true,
                'clip' => $clip,
            ];
        }

        return [
            'success' => false,
            'message' => 'non trovato',
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

    public function get_initials_edit($id = null)
    {
        $response = $this->get_initials();

        if ($id) {
            $clip = Clip::where('id', $id)->first();
            $clip = $clip->fresh($this->options);

            if ($clip) {
                $details = $clip->details()->first();
                if ($details) {
                    $details = $details->setDefaultLocale('it');
                }
                $clip->details = $details;

                $response['success'] = true;
                $response['initial'] = $clip;
            } else {
                $response['success'] = true;
            }
        } else {
            $response['success'] = true;
        }


        return $response;
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

    public function store_clip(Request $request)
    {
        $is_new = false;

        if (isset($request->id)) {
            $clip = Clip::find($request->id);
        } else {
            $clip = new Clip();
            $clip->year = 'no';
            $clip->nationality = 'no';
            $clip->period_id = 0;
            $clip->genre_id = 0;
            $clip->format_id = 0;
            $clip->age_id = 0;
            $is_new = true;

            $t = new ClipTranslation();
        }


        // Upload Clip
        $filename = uniqid() . '.mp4';
        $path = 'public/propaganda/clips';
        $file = $request->file('video');

        if ($file) {
            $src = $file->storeAs($path, $filename);
            $src = Storage::disk('local')->url($src);
        } else {
            $src = 'no';
        }

        if ($is_new == false) {
            if ($src != 'no') {
                $clip->video = $src;
            } else {
                $clip->video = $clip->video;
            }
        } else {
            $clip->video = $src;
        }

        $clip->save();

        $clip = $this->generate_thumbnail($clip);
        $clip = $this->crop_thumbnail($clip);

        // Upload Titolo
        $t = $clip->translateOrNew('it');
        $t->clip_id = $clip->id;
        $t->title = $request->title;
        $t->locale = 'it';
        $t->save();

        $clip = $clip->fresh($this->options);

        return [
          'success' => true,
          'clip' => $clip,
          'translation' => $t,
        ];
    }

    public function store_title_translation(Request $request)
    {
        $id = $request->id;
        $translations = json_decode($request->translations);

        $clip = Clip::find($id);

        foreach ($translations as $key => $translation) {
            $current = $clip->translateOrNew($translation->locale);
            $current->clip_id = $clip->id;
            $current->title = $translation->value;
            $current->save();
        }

        $clip = $clip->fresh($this->options);

        return response()->json(
            [
            'clip' => $clip,
            'translations' => $translations
            ]
        );
    }

    public function store_informations(Request $request)
    {
        $id = $request->id;
        $clip = Clip::find($id);

        $clip->year = $request->year;
        $clip->nationality = $request->nationality;

        // $debug = collect();

        foreach ($this->options_single as $key => $value) {
            // $debug->push($this->check_single_option($value, $request));
            $clip->{$value.'_id'} = $this->check_single_option($value, $request);
        }

        $clip->save();

        foreach ($this->options_multiple as $key => $value) {
            $saved = $this->check_multiple_option($value, $request, $clip);
        }

        $clip = $clip->fresh($this->options);
        return response()->json(
            [
                'clip' => $clip,
                // 'debug' => $debug,
            ]
        );
    }

    public function store_details_new(Request $request)
    {
        $clip = Clip::find($request->id);

        if ($clip->details->count() > 0) {
            $detail = $clip->details->first();
        } else {
            $detail = new Detail();
            $detail->clip_id = $clip->id;
            $detail->save();
        }

        $t = $detail->translateOrNew('it');
        $t->detail_id = $detail->id;
        $t->tech_info = $request->tech_info;
        $t->abstract = $request->abstract;
        $t->historical_context = $request->historical_context;
        $t->foods = $request->foods;
        $t->locale = 'it';

        $t->save();

        $clip = $clip->fresh($this->options);

        return response()->json(
            [
            'clip' => $clip,
            ]
        );
    }

    public function store_details_translation(Request $request)
    {
        $id = $request->id;
        $translations = json_decode($request->translations);
        $clip = Clip::find($id);
        $detail = $clip->details->first();

        foreach ($translations as $key => $translation) {
            $t = $translation->value;
            $current = $detail->translateOrNew($translation->locale);
            $current->detail_id = $detail->id;
            $current->tech_info = $t->tech_info;
            $current->abstract = $t->abstract;
            $current->historical_context = $t->historical_context;
            $current->foods = $t->foods;
            $current->save();
        }

        $clip = $clip->fresh($this->options);

        return response()->json(
            [
            'clip' => $clip,
            ]
        );
    }

    public function store_paratext_translation(Request $request)
    {
        $id = $request->id;
        $translations = json_decode($request->translations);
        $p = Paratext::find($id);

        foreach ($translations as $key => $translation) {
            $t = $translation->value;
            $current = $p->translateOrNew($translation->locale);
            $current->paratext_id = $p->id;
            $current->content = $t ? $t : 'null';
            $current->locale = $translation->locale;
            $current->save();
        }

        $clip = Clip::where('id', $request->clip_id)->with('format', 'period', 'age', 'genre', 'directors', 'peoples', 'topics', 'paratexts', 'libraries.exercise')->first();

        return response()->json(
            [
            'clip' => $clip,
            'paratext' => $p,
            ]
        );
    }

    public function store(Request $request)
    {
        $clip = new Clip();
        $clip->video = $request->hasFile('video') ? $this->upload_video($request->file('video')) : 'no';
        $clip->year = $request->year;
        $clip->title = $request->title;
        $clip->nationality = $request->nationality;

        foreach ($this->options_single as $key => $value) {
            $clip->{$value.'_id'} = $this->check_single_option($value, $request);
        }
        $clip->save();

        $clip = $this->generate_thumbnail($clip);
        $clip = $this->crop_thumbnail($clip);

        foreach ($this->options_multiple as $key => $value) {
            $saved = $this->check_multiple_option($value, $request, $clip);
        }

        $clip = $clip->fresh($this->options);

        return [
          'success' => true,
          'clip' => $clip,
        ];
    }

    public function destroy_clip($id)
    {
        $clip = Clip::findOrFail($id);

        $relations = ['peoples', 'directors', 'topics', 'hashtags'];

        foreach ($relations as $key => $relation) {
            if ($clip->{$relation} && $clip->{$relation}->count() > 0) {
                $clip->{$relation}->detach();
            }
        }

        // elimina i paratesti
        $paratexts = $clip->paratexts()->get();
        foreach ($paratexts as $key => $paratext) {
            // elimina i media collegati ai paratesti
            $medias = $paratext->medias()->get();
            foreach ($medias as $key => $media) {
                $media->delete();
            }
            $paratext->delete();
        }

        // elimina le librerie
        $libraries = $clip->libraries()->get();
        foreach ($libraries as $key => $library) {

            // elimina i media collegati
            $medias = $library->medias()->get();
            foreach ($medias as $key => $media) {
                $media->delete();
            }
            $library->delete();
        }

        $clip->delete();
        return [
            'success' => true,
            'id' => $id
        ];
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
                'clip' => $clip->fresh($this->options),
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

        if ($paraType->has_media == 1) {
            $file = $this->uploadFile($request->file('file'), $paraType->type);
        }
        // $file = Media::find(2);


        $p = new Paratext();
        $p->paratext_type_id = $paraType->id;
        // $p->content = $request->content ? $request->content : 'null';
        $p->media_type = $paraType->type;
        $p->media = $paraType->has_media == 1 ? Storage::disk('local')->url($file->src) : 'no-file';
        $p->save();

        if ($paraType->has_media == 1) {
            $p->medias()->attach($file);
        }
        $p->clip()->attach($clip);

        $t = $p->translateOrNew('it');
        $t->paratext_id = $p->id;
        $t->content = $request->content ? $request->content : 'null';
        $t->locale = 'it';
        $t->save();

        $clip = $clip->fresh($this->options);

        return [
          'clip' => $clip,
          'paratext' => $p,
        ];
    }

    public function destroy_paratext(Request $request)
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

    public function check_single_option($name, $request)
    {
        $model = ucwords('App\\Propaganda\\'.ucfirst($name));
        $modelTranslation = ucwords('App\\Propaganda\\'.ucfirst($name).'Translation');
        $translation = $modelTranslation::where('title', $request->{$name})->where('locale', 'it')->first();

        if ($translation) {
            $result = $model::find($translation->{$name.'_id'});
        } else {
            $result = false;
        }

        if ($result) {
            // return 'il risultato esiste già';
            return $result->id;
        } else {
            $obj = \App::make($model);
            $obj->save();
            $t = $obj->translateOrNew('it');
            $columns = $t->getTableColumns();

            foreach ($columns as $key => $column) {
                if ($column != 'id' && $column != 'locale' && $column != $name.'_id') {
                    if ($request->input($column, false) == false) {
                        // va riempita con un random
                        $t->{$column} = $request->{$name};
                    } else {
                        $t->{$column} = $request->{$name};
                    }
                } elseif ($column == 'locale') {
                    $t->locale = 'it';
                } elseif ($column == $name.'_id') {
                    $t->{$name.'_id'} = $obj->id;
                }
            }
            $t->save();
            return $obj->id;
        }
    }

    public function check_multiple_option($name, $request, $clip)
    {
        $clip->{$name}()->detach();
        // return true;

        $singular = rtrim($name, 's');
        $model = ucwords('App\\Propaganda\\'.ucfirst($singular));
        $modelTranslation = ucwords('App\\Propaganda\\'.ucfirst($singular).'Translation');

        $results = collect();
        if (isset($request->{$name})) {
            foreach (json_decode($request->{$name}) as $key => $value) {
                $field = $name == 'directors' ? 'name' : 'title';
                $translation = $modelTranslation::where($field, $value)->where('locale', 'it')->first();

                if ($translation) {
                    $result = $model::find($translation->{$singular.'_id'});
                } else {
                    $result = false;
                }

                if ($result) {
                    $results->push($result);
                } else {
                    $obj = \App::make($model);
                    $obj->save();
                    $t = $obj->translateOrNew('it');
                    $columns = $t->getTableColumns();

                    foreach ($columns as $key => $column) {
                        if ($column == $singular.'_id') {
                            $t->{$column} = $obj->id;
                        } elseif ($column == 'locale') {
                            $t->locale = 'it';
                        } elseif ($column == $field) {
                            $t->{$field} = $value;
                        }
                    }

                    $t->save();
                    $results->push($obj);
                }

                $clip->{$name}()->attach($result);
            }
        }

        return $results;
    }
}
