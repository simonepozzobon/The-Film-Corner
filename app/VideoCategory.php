<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoCategory extends Model
{
    protected $table = 'video_categories';

    public function videos()
    {
        return $this->hasMany('App\Video');
    }

}
