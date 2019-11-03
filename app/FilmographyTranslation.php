<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilmographyTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'description'];

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }
}
