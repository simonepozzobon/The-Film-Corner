<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppSection extends Model
{
    protected $table = 'app_sections';

    public function appCategories()
    {
      return $this->hasMany('App\AppCategory');
    }
}
