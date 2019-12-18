<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class ClipTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title'];

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }
}
