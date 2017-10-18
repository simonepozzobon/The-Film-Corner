<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    protected $table = 'apps';

    public function category()
    {
      return $this->belongsTo('App\AppCategory', 'app_category_id', 'id');
    }

    public function videos()
    {
      return $this->morphToMany('App\Video', 'videoable');
    }

    public function audios()
    {
      return $this->morphToMany('App\Audio', 'audioable');
    }

    public function medias()
    {
      return $this->morphToMany('App\Media', 'mediaable');
    }

    public function mediaCategory()
    {
      return $this->hasMany('App\MediaSubCategory');
    }
}
