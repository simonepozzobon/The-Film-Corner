<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caption extends Model
{
    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ['title', 'description'];
    protected $table = 'captions';
    protected $fillable = [];

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }
}
