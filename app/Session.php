<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function app() {
        return $this->belongsTo(App::class);
    }

}
