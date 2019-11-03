<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WelcomeForm extends Model
{
    protected $table = 'welcome_forms';

    public function student()
    {
        return $this->belongsTo('App\Student');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Teacher');
    }
}
