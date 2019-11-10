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
        $contents = [
            'sections' => AppSection::all(),
            'categories' => AppCategory::all(),
            'apps' => App::all(),
            'captions' => Caption::all(),
            'texts' => GeneralText::all(),
            'keywords' => AppKeyword::all()
        ];

        $locales = config('translatable.locales');

        $translated = array();
        foreach ($locales as $localeKey => $currentLocale) {
            // itero attraverso i vari locale
            $translated[$currentLocale] = $this->format_contents_by_locale($currentLocale, $contents);
        }

        return [
            'success' => true,
            'translations' => $translated,
        ];
    }

    public function format_contents_by_locale($locale, $contents)
    {
        $translatedContents = array();
        foreach ($contents as $key => $content) {
            $translatedContents[$key] = $this->get_content_translation($locale, $content);
        }
        return $translatedContents;
    }

    public function get_content_translation($locale, $items)
    {
        $translatedItems = collect();
        foreach ($items as $key => $item) {
            $translatedItem = $item->translate($locale, true);

            foreach ($translatedItem->getAttributes() as $attributeKey => $attributeValue) {
                if ($attributeKey == 'name' || $attributeKey == 'title') {
                    $translatedItem->{$attributeKey} = strip_tags($attributeValue);
                }
            }
            $translatedItems->push($translatedItem);
        }
        return $translatedItems;
    }
}
