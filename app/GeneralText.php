<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralText extends Model
{
    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ['description'];
    protected $table = 'general_texts';

    public static function field ($field)
    {
        $text = GeneralText::where('field', '=', $field)->first();
        if ($text) {
            return $text->description;
        } else {
            return '';
        }
    }
}
