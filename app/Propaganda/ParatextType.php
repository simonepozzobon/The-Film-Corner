<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class ParatextType extends Model
{
    protected $connection = 'tfc_propaganda';


    public function paratext()
    {
        return $this->hasMany('App\Propaganda\Paratext');
    }
}
