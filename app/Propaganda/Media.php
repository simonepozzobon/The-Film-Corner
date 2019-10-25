<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $connection = 'tfc_propaganda';
    protected $table = 'medias';

    public function paratexts()
    {
        return $this->morphedByMany('App\Propaganda\Paratext', 'mediable');
    }
}
