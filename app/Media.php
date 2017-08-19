<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'medias';

    // public function posts() {
    //   return $this->hasMany('App\Post');
    // }

    public function apssSessions()
    {
        return $this->morphedByMany('App\AppsSessions\AppsSession', 'mediaable');
    }

    public function teachers()
    {
        return $this->morphedByMany('App\Teacher', 'mediaable');
    }
}
