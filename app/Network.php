<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    protected $table = 'networks';

    public function app() {
        return $this->belongsTo(App::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
