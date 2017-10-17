<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaCategory extends Model
{
    protected $table = 'media_categories';

    public function videos()
    {
        return $this->hasMany('App\Video');
    }

}
