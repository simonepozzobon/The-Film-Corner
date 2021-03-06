<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class LibraryType extends Model
{
    protected $connection = 'tfc_propaganda';

    public function library()
    {
        return $this->belongsTo('App\Propaganda\Library');
    }
}
