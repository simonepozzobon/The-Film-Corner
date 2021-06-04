<?php

namespace App\Http\Controllers\Api\Admin;

use App\Filmography;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\School;
use App\HomeText;
use App\HomeTextTranslation;

class HomeController extends Controller
{
    public function get_all()
    {
        app()->setLocale('it');
        $schools = School::all();
        $filmographies = Filmography::all();

        return response()->json(
            [
                'schools' => $schools,
                'filmography' => $filmographies
            ]
        );
    }

    public function save(Request $request)
    {
    }

    public function add_list(Request $request)
    {
        $type = $request->type;
        $fields = json_decode($request->fields);
        $model = null;

        if ($type == 'schools') {
            $model = 'App\\School';
        } else if ($type == 'filmography') {
            $model = 'App\\FilmographyTranslation';
        }

        $item = new $model();
        if ($type == 'filmography') {
            $original = new Filmography();
            $original->save();

            $item->locale = 'it';
            $item->filmography_id = $original->id;
        }
        foreach ($fields as $key => $field) {
            $reqKey = $field->key;
            $item->{$reqKey} = $request->{$reqKey};
        }
        $item->save();

        return response()->json($item);
    }

    public function remove_item(Request $request)
    {
        $type = $request->type;

        if ($type == 'schools') {
            $model = 'App\\School';
        } else if ($type == 'filmography') {
            $model = 'App\\FilmographyTranslation';
        }

        $item = $model::find($request->item_id);
        $item->delete();
        return response()->json($item);
    }

    public function update_list_translations(Request $request)
    {
        $type = $request->type;
        $fields = json_decode($request->fields);
        $translations = json_decode($request->translations);
        $model = null;

        if ($type == 'schools') {
            $model = 'App\\SchoolTranslation';
            $column_id = 'school_id';
        } else if ($type == 'filmography') {
            $model = 'App\\FilmographyTranslation';
            $column_id = 'filmography_id';
        }

        foreach ($translations as $locale => $translation) {
            $t = $model::firstOrNew(
                [
                    [$column_id, '=', $request->id],
                    ['locale', '=', $translation->locale]
                ]
            );
            $t->{$column_id} = $request->id;

            foreach ($translation->values as $key => $single) {
                $reqKey = $single->key;
                $t->{$reqKey} = $single->value;
            }

            try {
                $t->save();
            } catch (\Exception $e) {
            }
        }

        if ($type == 'schools') {
            $model = 'App\\School';
        } else if ($type == 'filmography') {
            $model = 'App\\Filmography';
        }
        $item = $model::find($request->id);
        return response()->json($item);
    }

    public function get_project()
    {
        $text = HomeText::find(1);
        return response()
            ->json(
                [
                    'text' => $text
                ]
            );
    }

    public function save_project(Request $request)
    {
        $text = $this->save_home_text($request, 1);

        return response()
            ->json(
                [
                    'text' => $text
                ]
            );
    }

    public function get_conference()
    {
        $text = HomeText::find(2);
        return response()
            ->json(
                [
                    'text' => $text
                ]
            );
    }

    public function save_conference(Request $request)
    {
        $text = $this->save_home_text($request, 2);

        return response()
            ->json(
                [
                    'text' => $text
                ]
            );
    }

    public function save_home_text($request, $id)
    {
        $languages = ['it', 'en', 'fr', 'sr', 'sl', 'ka'];
        foreach ($languages as $lang) {
            $content = $request->{$lang};

            if ($content && $content != 'null') {
                $t = HomeTextTranslation::firstOrNew(
                    [
                        ['home_text_id', '=', $id],
                        ['locale', '=', $lang]
                    ]
                );
                $t->home_text_id = $id;
                $t->locale = $lang;
                $t->content = $content;
                $t->save();
            }
        }

        return HomeText::find($id);
    }
}
