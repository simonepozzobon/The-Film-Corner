<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    protected $connection = 'tfc_propaganda';
    protected $table = 'peoples';

    public function clip()
    {
        return $this->belongsToMany('App\Propaganda\Clip', 'clip_people', 'people_id', 'clip_id');
    }
}
