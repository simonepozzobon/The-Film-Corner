<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $connection = 'tfc_propaganda';

    protected $table = 'exercises';

    public function libraries()
    {
        return $this->hasMany('App\Propaganda\Library');
    }
}
