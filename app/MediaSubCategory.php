<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaSubCategory extends Model
{
    protected $table = 'media_sub_categories';

    public function app()
    {
      return $this->belongsTo('App\App');
    }

    public function medias()
    {
      return $this->morphToMany('App\Media', 'mediaable');
    }

    public function videos()
    {
      return $this->morphToMany('App\Video', 'videoable');
    }

    public function audios()
    {
      return $this->morphToMany('App\Audio', 'audioable');
    }


}
