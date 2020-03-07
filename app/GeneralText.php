<?php

namespace App;

use App\Utility;
use Illuminate\Database\Eloquent\Model;

class GeneralText extends Model
{
    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ['description'];
    protected $table = 'general_texts';

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }

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
