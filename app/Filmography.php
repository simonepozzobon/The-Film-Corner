<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filmography extends Model
{
    protected $table = 'filmographies';

    public static function get_all()
    {
        $filmographies = Filmography::orderBy('title')->get();
        return $filmographies;
    }
}
