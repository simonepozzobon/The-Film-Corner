<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeTextTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['content'];

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }
}
