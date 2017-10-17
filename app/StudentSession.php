<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentSession extends Model
{
    protected $table = 'student_sessions';

    public function student()
    {
      return $this->belongsTo('App\Student');
    }

    public function app()
    {
      return $this->belongsTo('App\App');
    }

}
