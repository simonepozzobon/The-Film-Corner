<?php

namespace App\AppsSessions;

use Illuminate\Database\Eloquent\Model;

class StudentAppSession extends Model
{
    protected $table = 'student_apps_sessions';

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

    public function student()
    {
      return $this->belongsTo('App\Student');
    }

    public function app()
    {
      return $this->belongsTo('App\App');
    }
}
