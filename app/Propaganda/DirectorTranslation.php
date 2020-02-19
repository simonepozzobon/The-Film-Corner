<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class DirectorTranslation extends Model
{
    public $timestamps = false;
    protected $connection = 'tfc_propaganda';
    protected $fillable = ['name'];

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }
}
