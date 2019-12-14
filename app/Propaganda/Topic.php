<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $connection = 'tfc_propaganda';

    public function clip()
    {
        return $this->belongsToMany('App\Propaganda\Clip', 'clip_topic', 'topic_id', 'clip_id');
    }
}
