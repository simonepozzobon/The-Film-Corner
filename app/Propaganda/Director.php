<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    protected $connection = 'tfc_propaganda';

    public function clip()
    {
        return $this->belongsToMany('App\Propaganda\Director', 'clip_director', 'director_id', 'clip_id');
    }
}
