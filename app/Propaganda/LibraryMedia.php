<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class LibraryMedia extends Model
{
    protected $connection = 'tfc_propaganda';
    
    protected $table = 'library_medias';

    public function library()
    {
        return $this->belongsTo('App\Propaganda\Library');
    }
}
