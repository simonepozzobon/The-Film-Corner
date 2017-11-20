<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    protected $table = 'static_pages';

    public function medias() {
        return $this->morphToMany('App\Media', 'mediaable');
    }
}
