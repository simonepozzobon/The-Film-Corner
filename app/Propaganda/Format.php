<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    protected $connection = 'tfc_propaganda';

    public function clip()
    {
        return $this->hasMany('App\Propaganda\Clip');
    }
}
