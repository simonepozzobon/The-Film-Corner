<?php

namespace App\Http\Controllers\Admin;

use App\App;
use App\Caption;
use App\Language;
use App\AppKeyword;
use App\AppSection;
use App\AppCategory;
use App\GeneralText;
use App\AppKeywordTranslation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class TranslateController extends Controller
{

    public function get_languages()
    {
        $locales = Language::all();
        return response($locales, 200);
    }

    public function index()
    {
        // $locales = Language::all();
        // $apps = App::all();
        // $apps = $apps->transform(function($item, $key) use ($locales) {
        //     $item->model = get_class($item).'Translation';
        //     $item->table = $item->getTable();
        //
        //     $translated = [];
        //     foreach ($locales as $key => $locale) {
        //         if ($item->hasTranslation($locale->short)) {
        //             array_push($translated, $locale->short);
        //         }
        //     }
        //     $item->translated = $translated;
        //     return $item;
        // });
        return view('admin.translate.index', compact('apps'));
    }

    public function get_elements(Request $r)
    {
        switch ($r->type) {
            case 'apps':
                $items = App::all();
                break;

            case 'app_keywords':
                $items = AppKeyword::all();
                break;

            case 'app_sections':
                $items = AppSection::all();
                break;

            case 'app_categories':
                $items = AppCategory::all();
                break;

            case 'general_texts':
                $items = GeneralText::all();
                break;

            case 'captions':
                $items = Caption::all();
                break;
        }

        $locales = Language::all();

        $items = $items->transform(function($item, $key) use ($locales) {
            $item->model = get_class($item).'Translation';
            $item->original_model = get_class($item);
            $item->table = $item->getTable();

            $translated = [];
            foreach ($locales as $key => $locale) {
                if ($item->hasTranslation($locale->short)) {
                    array_push($translated, $locale);
                }
            }
            $item->translated = $translated;

            return $item;
        });

        return response()->json($items, 200);
    }

    public function save(Request $r)
    {
        // Recupero il locale dalla tabella delle lingue
        $language = Language::find($r->language);

        // Prendo il modello e la tabella
        $model = $r->translable_type;

        $model_check = new $model;

        $table = $model_check->getTable();

        // Dalla tabella recupero il nome della seconda colonna che corrisponde all'id dell'elemento da tradurre
        $columns = Schema::getColumnListing($table);
        $column_id = $columns[1];

        // verifico se esiste già
        $t = $model::where([
            [$column_id, '=', $r->translable_id],
            ['locale', '=', $language->short]
        ])->first();

        // Se non esiste allora ne creo uno nuovo
        if ($t == null) {
            $t = new $model;
        }

        // salvo l'id nel model
        $t->{$column_id} = $r->translable_id;

        // decodifico l'oggetto con le traduzioni e per ogni proprietà da tradurre la salvo nel model
        $translations = json_decode($r->translations);
        foreach ($translations as $key => $translation) {
            $t->{$translation->title} = $translation->value;
        }

        // Salvo il locale nel model
        $t->locale = $language->short;

        // Salvo il modello e quindi la traduzione
        $t->save();


        return response()->json($t, 200);
    }


    public function get_translation(Request $r)
    {
        $model = $r->original_model;
        $item = $model::find($r->id);
        $translation = $item->translate($r->language);

        return response()->json($translation, 200);
    }


    public function translate()
    {
        $items = AppKeyword::all();
        foreach ($items as $key => $item) {
            $t = new AppKeywordTranslation;
            $t->app_keyword_id = $item->id;
            $t->name = $item->name;
            $t->description = $item->description;
            $t->locale = 'en';
            $t->save();
        }

        return redirect()->route('admin');
    }
}
