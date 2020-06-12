<?php

namespace App\Http\Controllers\Api\Admin;

use App\Filmography;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\School;

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
}
