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
}
