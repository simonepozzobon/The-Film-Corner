<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppKeyword extends Model
{
    protected $table = 'app_keywords';

    public function category()
    {
      return $this->belongsTo('App\Category');
    }
}
