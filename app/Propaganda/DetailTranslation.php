<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class DetailTranslation extends Model
{
    public $timestamps = false;
    protected $connection = 'tfc_propaganda';
    protected $fillable = ['tech_info', 'abstract', 'historical_context', 'foods'];

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }
}
