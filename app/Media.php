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

    public function guests()
    {
        return $this->morphedByMany('App\Guest', 'mediaable');
    }

    public function static_pages()
    {
        return $this->morphedByMany('App\StaticPage', 'mediaable');
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

    public function mediaSubCategories()
    {
        return $this->morphedByMany('App\MediaSubCategory', 'mediaable');
    }

    public function library()
    {
        $link = $this->morphOne('App\MultiSubcategory', 'mediable')->first();
        if ( $link->sub_category() != null ) {
            $library = $link->sub_category()->first();
            return $library;
        } else {
            return $library = '';
        }
    }

}
