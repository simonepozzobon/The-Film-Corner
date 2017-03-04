<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function author()
    {
      return $this->belongsTo('App\User', 'user_id');
    }

    public function featuredImage()
    {
      return $this->belongsTo('App\Media', 'media_id');
    }

    public function category()
    {
      return $this->belongsTo('App\Category');
    }

    public function tags()
    {
      return $this->belongsToMany('App\Tag');
    }

}
