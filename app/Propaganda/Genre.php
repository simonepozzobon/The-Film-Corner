<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $connection = 'propagandapp';

    public function clip()
    {
        return $this->hasMany('App\Propaganda\Clip');
    }
}
