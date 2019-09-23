<?php

namespace App\Http\Controllers\Api;

use App\App;
use App\Caption;
use App\AppKeyword;
use App\AppSection;
use App\AppCategory;
use App\Filmography;
use App\GeneralText;
use App\AppCategoryTranslation;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TranslationController extends Controller
{
    public function get_translations()
    {
        $translations = array();

        $sections = AppSection::all();
        $categories = AppCategory::all();
        $apps = App::all();

        $captions = Caption::all();
        $texts = GeneralText::all();
        $keywords = AppKeyword::all();



        $translations = [
            'sections' => $this->get_translated($sections),
            'categories' => $this->get_translated($categories),
            'apps' => $this->get_translated($apps),
            'captions' => $this->get_translated($captions),
            'texts' => $this->get_translated($texts),
            'keywords' => $this->get_translated($keywords)
        ];

        return [
            'success' => true,
            'translations' => $translations,
        ];
    }

    public function get_translated($models)
    {
        foreach ($models as $key => $model) {
            $translated = $model->getTranslationsArray();
            $model->translation = $translated;
        }

        return $models;
    }
}
