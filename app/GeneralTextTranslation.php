<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralTextTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['description'];

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }
}
