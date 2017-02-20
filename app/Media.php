<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'medias';

    public function posts() {
      return $this->hasMany('App\Post');
    }
}
