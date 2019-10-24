<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    protected $connection = 'tfc_propaganda';

    public function clip()
    {
        return $this->belongsTo('App\Propaganda\Clip');
    }
}
