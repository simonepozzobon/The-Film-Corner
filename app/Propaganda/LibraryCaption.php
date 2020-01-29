<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class LibraryCaption extends Model
{
    protected $connection = 'tfc_propaganda';

    public function library_media()
    {
        return $this->belongsTo('App\Propaganda\LibraryMedia');
    }
}
