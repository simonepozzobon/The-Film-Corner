<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharedSession extends Model
{
    public function app()
    {
        return $this->belongsTo('App\App');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }
}
