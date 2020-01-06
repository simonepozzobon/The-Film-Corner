<?php

namespace App\AppsSessions;

use Illuminate\Database\Eloquent\Builder;
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

    public function teacher()
    {
        $student = $this->student;
        $teacher = $student->teacher;
        return $teacher;
    }

    public function count_currently_shared_sessions($studentId)
    {
        return StudentAppSession::where([
            ['student_id', '=', $studentId],
            ['teacher_shared', '=', 1],
            ['teacher_approved', '=', 0],
        ])->count();
    }

    public function check_if_already_shared($studentId, $token)
    {
        return StudentAppSession::where([
            ['student_id', '=', $studentId],
            ['teacher_shared', '=', 1],
            ['teacher_approved', '=', 0],
            ['token', '=', $token]
        ])->count();
    }
}
