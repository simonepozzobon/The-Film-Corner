<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Clip extends Model
{
    use \Dimsav\Translatable\Translatable;

    protected $connection = 'tfc_propaganda';

    public $translatedAttributes = ['title'];

    protected $fillable = ['video', 'year', 'nationality'];

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
        return $this->belongsToMany('App\Propaganda\Director');
    }

    public function topics()
    {
        return $this->belongsToMany('App\Propaganda\Topic', 'clip_topic', 'clip_id', 'topic_id');
    }

    public function peoples()
    {
        return $this->belongsToMany('App\Propaganda\People', 'clip_people', 'clip_id', 'people_id');
    }

    public function hashtags()
    {
        return $this->belongsToMany('App\Propaganda\Hashtag', 'clip_hashtag', 'clip_id', 'hashtag_id');
    }

    public function paratexts()
    {
        return $this->belongsToMany('App\Propaganda\Paratext');
    }

    public function libraries()
    {
        return $this->hasMany('App\Propaganda\Library');
    }

    public function details()
    {
        return $this->hasMany('App\Propaganda\Detail');
    }
}
