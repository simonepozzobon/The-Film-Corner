<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use Notifiable;

    protected $guard = 'teacher';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function students() {
      return $this->hasMany('App\Student');
    }

    public function school() {
      return $this->belongsTo('App\School');
    }

    public function videos() {
      return $this->morphToMany('App\Video', 'videoable');
    }

    public function audios()
    {
      return $this->morphToMany('App\Audio', 'audioable');
    }

    public function medias() {
      return $this->morphToMany('App\Media', 'mediaable');
    }

    public function sessions()
    {
      return $this->hasMany('App\TeacherSession');
    }
}
