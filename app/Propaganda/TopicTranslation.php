<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class TopicTranslation extends Model
{
    public $timestamps = false;
    protected $connection = 'tfc_propaganda';
    protected $fillable = ['title'];

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }
}
