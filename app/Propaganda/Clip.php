<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Clip extends Model
{
    protected $connection = 'propagandapp';

    // One to many
    public function period()
    {
        return $this->belongsTo('App\Propaganda\Period');
    }

    public function genre()
    {
        return $this->belongsTo('App\Propaganda\Genre');
    }

    public function format()
    {
        return $this->belongsTo('App\Propaganda\Format');
    }

    public function age()
    {
        return $this->belongsTo('App\Propaganda\Age');
    }

    // Many to many
    public function directors()
    {
        return $this->belongsToMany('App\Propaganda\Director', 'clip_director', 'clip_id', 'director_id');
    }

    public function topics()
    {
        return $this->belongsToMany('App\Propaganda\Topic', 'clip_topic', 'clip_id', 'topic_id');
    }

    public function peoples()
    {
        return $this->belongsToMany('App\Propaganda\People', 'clip_people', 'clip_id', 'people_id');
    }
}
