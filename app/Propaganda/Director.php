<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    protected $connection = 'propagandapp';

    public function clip()
    {
        return $this->belongsToMany('App\Propaganda\Director', 'clip_director', 'director_id', 'clip_id');
    }
}
