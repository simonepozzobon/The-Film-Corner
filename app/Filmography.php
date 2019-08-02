<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filmography extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['title', 'description'];
    protected $table = 'filmographies';

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }

    public static function get_all()
    {
        $filmographies = Filmography::all();
        return $filmographies;
    }
}
