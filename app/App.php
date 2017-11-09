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

    public function examples()
    {
      $videos = $this->morphToMany('App\Video', 'videoable')->where('category_id', 3)->get();
      $images = $this->morphToMany('App\Media', 'mediaable')->where('category_id', 3)->get();
      $audios = $this->morphToMany('App\Audio', 'audioable')->where('category_id', 3)->get();

      $count = $videos->count() + $audios->count() + $images->count();

      $items = [
        'count' => $count,
        'videos' => $videos,
        'images' => $images,
        'audios' => $audios,
      ];

      return $items;
    }
}
