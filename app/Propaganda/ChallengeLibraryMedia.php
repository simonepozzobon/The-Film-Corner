<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class ChallengeLibraryMedia extends Model
{
    protected $connection = 'tfc_propaganda';
    protected $table = 'challenge_library_medias';

    public function library()
    {
        return $this->belongsTo('App\Propaganda\ChallengeLibrary');
    }
}
