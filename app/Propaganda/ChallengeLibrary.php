<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class ChallengeLibrary extends Model
{
    protected $connection = 'tfc_propaganda';

    public function library()
    {
        return $this->belongsTo('App\Propaganda\Challenge');
    }

    public function medias()
    {
        return $this->hasMany('App\Propaganda\ChallengeLibraryMedia');
    }
}
