<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    protected $connection = 'tfc_propaganda';

    public function clip()
    {
        return $this->belongsToMany('App\Propaganda\Clip');
    }
}
