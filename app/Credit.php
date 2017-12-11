<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $table = 'credits';

    public static function get_all()
    {
        $credits = Credit::orderBy('name')->get();
        return $credits;
    }
}
