<?php

namespace App\Http\Controllers\Admin;

use App\App;
use App\Caption;
use App\Partner;
use App\Language;
use App\AppKeyword;
use App\AppSection;
use App\AppCategory;
use App\GeneralText;
use App\Filmography;
use App\AppTranslation;
use App\CaptionTranslation;
use App\PartnerTranslation;
use App\LanguageTranslation;
use App\AppSectionTranslation;
use App\AppCategoryTranslation;
use App\GeneralTextTranslation;
use App\FilmographyTranslation;
use App\AppKeywordTranslation;
use App\Propaganda\Exercise;
use App\Propaganda\ExerciseTranslation;
use App\Propaganda\Challenge;
use App\Propaganda\ChallengeTranslation;
use App\Propaganda\Director;
use App\Propaganda\DirectorTranslation;
use App\Propaganda\Format;
use App\Propaganda\FormatTranslation;
use App\Propaganda\Genre;
use App\Propaganda\GenreTranslation;
use App\Propaganda\People;
use App\Propaganda\PeopleTranslation;
use App\Propaganda\Period;
use App\Propaganda\PeriodTranslation;
use App\Propaganda\Topic;
use App\Propaganda\TopicTranslation;
use App\Propaganda\Age;
use App\Propaganda\AgeTranslation;

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
        return view('admin.translate.index');
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

        case 'filmographies':
            $items = Filmography::all();
            break;

        case 'partners':
            $items = Partner::all();
            break;

        case 'exercises':
            $items = Exercise::all();
            break;

        case 'challenges':
            $items = Challenge::all();
            break;

        case 'propaganda_period':
            $items = Period::all();
            break;

        case 'propaganda_director':
            $items = Director::all();
            break;

        case 'propaganda_people':
            $items = People::all();
            break;

        case 'propaganda_format':
            $items = Format::all();
            break;

        case 'propaganda_genre':
            $items = Genre::all();
            break;

        case 'propaganda_topic':
            $items = Topic::all();
            break;

        case 'propaganda_age':
            $items = Age::all();
            break;
        }

        $locales = Language::all();

        $items = $items->transform(
            function ($item, $key) use ($locales) {
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
            }
        );

        return response()->json($items, 200);
    }

    public function save(Request $r)
    {
        $test =[];
        // Prendo il modello e la tabella
        $model = 'App\\'.$r->type;
        $model_check = new $model();

        $table = $model_check::get_db_table();

        // Dalla tabella recupero il nome della seconda colonna che corrisponde all'id dell'elemento da tradurre
        $columns = array();
        if ($table == 'exercise_translations' || $table == 'challenge_translations') {
            $columns = Schema::connection('tfc_propaganda')->getColumnListing($table);
        } elseif (substr($r->type, 0, 10) == 'Propaganda') {
            $columns = Schema::connection('tfc_propaganda')->getColumnListing($table);
        } else {
            $columns = Schema::getColumnListing($table);
        }
        $column_id = $columns[1];

        // decodifico le traduzioni
        $translations = json_decode($r->translations);
        $new_translations = [];

        foreach ($translations as $locale => $languages) {

            // verifico se esiste già
            $t = $model::firstOrNew(
                [
                    [$column_id, '=', $r->item_id],
                    ['locale', '=', $locale]
                ]
            );
            // array_push($test, $t);


            // salvo l'id nel model
            $t->{$column_id} = $r->item_id;
            $t->locale = $locale;

            foreach ($languages as $field => $translation) {
                // array_push($test, $translation);

                if (gettype($translation) == 'string') {
                    if ($field == 'title' || $field == 'name') {
                        $t->{$field} = strip_tags($translation);
                    } else {
                        $t->{$field} = $translation;
                    }
                } else {
                    array_push($test, $field);
                }
            }

            array_push($new_translations, $t);
            try {
                $t->save();
            } catch (\Exception $e) {
                array_push($test, $e);
            }
        }


        return [
            'success' => true,
            'columns' => $columns,
            'test' => $test,
            'translations' => $new_translations,
        ];
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
