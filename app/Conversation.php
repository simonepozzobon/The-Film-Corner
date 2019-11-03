<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table = 'conversations';

    public function student()
    {
      return $this->belongsTo('App\Student');
    }

    public function teacher()
    {
      return $this->belongsTo('App\Teacher');
    }
}
