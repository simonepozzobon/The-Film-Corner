<?php

namespace App\AppsSessions;

use Illuminate\Database\Eloquent\Model;

class GuestAppSession extends Model
{
    protected $table = 'guest_app_sessions';

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

    public function teacher()
    {
        return $this->belongsTo('App\Teacher');
    }

    public function app()
    {
        return $this->belongsTo('App\App');
    }
}
