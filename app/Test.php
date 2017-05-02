<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = "tests";
    protected $fillable = [
        'media_url', 'start', 'duration'
    ];
}
