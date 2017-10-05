<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharedSession extends Model
{
    public function app()
    {
      return $this->belongsTo('App\App');
    }
}
