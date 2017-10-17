<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'medias';

    // public function posts() {
    //   return $this->hasMany('App\Post');
    // }

    public function category()
    {
        return $this->belongsTo('App\MediaCategory');
    }

    public function appsSessions()
    {
        return $this->morphedByMany('App\AppsSessions\AppsSession', 'mediaable');
    }

    public function studentAppSessions()
    {
        return $this->morphedByMany('App\AppsSessions\StudentAppSession', 'mediaable');
    }

    public function teachers()
    {
        return $this->morphedByMany('App\Teacher', 'mediaable');
    }

    public function students()
    {
        return $this->morphedByMany('App\Student', 'mediaable');
    }

    public function apps()
    {
        return $this->morphedByMany('App\App', 'mediaable');
    }

    public function appCategories()
    {
        return $this->morphedByMany('App\AppCategory', 'mediaable');
    }

    public function appSection()
    {
        return $this->morphedByMany('App\AppSection', 'mediaable');
    }
}
