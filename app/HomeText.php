<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeText extends Model
{
    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ['content'];
    protected $table = 'home_texts';

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }
}
