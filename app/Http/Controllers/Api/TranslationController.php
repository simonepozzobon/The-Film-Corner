<?php

namespace App\Http\Controllers\Api;

use App\AppCategory;
use App\AppCategoryTranslation;
use App\AppKeyword;
use App\AppSection;
use App\App;
use App\Caption;
use App\Filmography;
use App\GeneralText;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TranslationController extends Controller
{
    public function get_translations()
    {
        $translations = array();

        $categories = AppCategoryTranslation::all();
        $categories = $this->get_translation($categories);

        dd($categories);

        $keywords = AppKeyword::all();
        $keywords = $this->get_translations($keywords);

        $sections = AppSection::all();
        $sections = $this->get_translations($sections);

        $apps = App::all();
        $apps = $this->get_translations($apps);

        $captions = Caption::all();
        $captions = $this->get_translations($captions);
        dd($categories);
    }

    public function merge_translation($translations, $column)
    {
        $merged = collect();

        foreach ($translations as $key => $translation) {
            $id = $translation->{$column};

            foreach ($merged as $key => $item) {
                if ($item->id == $id) {
                    $item->translations->push($translation);
                } else {
                    $object = collect();
                    $object->id = $id;

                    dump($translation);
                }
            }
            dump($id);
        }
    }

    public function get_translation($collection)
    {
        return $collection->transform(
            function ($object, $key) {
                $object->translations = $object->getTranslationsArray();
                return $object;
            }
        );
    }
}
