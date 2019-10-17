<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    protected $connection = 'propagandapp';

    public function clip()
    {
        return $this->hasMany('App\Propaganda\Clip');
    }
}
