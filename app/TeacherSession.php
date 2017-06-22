<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherSession extends Model
{
    protected $table = 'teacher_sessions';

    public function teacher()
    {
      return $this->belongsTo('App\Teacher');
    }

    public function app()
    {
      return $this->belongsTo('App\App');
    }
}
