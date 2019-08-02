<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'description'];

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }
}
