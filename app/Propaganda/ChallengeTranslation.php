<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class ChallengeTranslation extends Model
{
    public $timestamps = false;
    protected $connection = 'tfc_propaganda';
    protected $fillable = ['title', 'description'];

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }
}
