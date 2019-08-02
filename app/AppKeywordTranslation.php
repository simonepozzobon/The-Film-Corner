<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppKeywordTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'description'];

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }
}
