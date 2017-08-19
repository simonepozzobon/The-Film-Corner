<?php

namespace App\AppsSessions;

use Illuminate\Database\Eloquent\Model;

class AppsSession extends Model
{
    protected $table = 'teacher_apps_sessions';

    public function videos()
    {
      return $this->morphToMany('App\Video', 'videoable');
    }

    public function medias() {
      return $this->morphToMany('App\Media', 'mediaable');
    }
}
