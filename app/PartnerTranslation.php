<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartnerTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'location', 'description'];

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }
}
