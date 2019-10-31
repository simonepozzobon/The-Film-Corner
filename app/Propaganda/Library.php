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

    public function type()
    {
        return $this->belongsTo('App\Propaganda\LibraryType');
    }

    public function medias()
    {
        return $this->hasMany('App\Propaganda\LibraryMedia');
    }
}
