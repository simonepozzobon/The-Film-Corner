<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Paratext extends Model
{
    use \Dimsav\Translatable\Translatable;

    protected $connection = 'tfc_propaganda';

    public $translatedAttributes = ['content'];

    protected $fillable = ['media', 'media_type'];

    public function clip()
    {
        return $this->belongsToMany('App\Propaganda\Clip');
    }

    public function medias()
    {
        return $this->morphToMany('App\Propaganda\Media', 'mediable');
    }

    public function type()
    {
        return $this->belongsTo('App\Propaganda\ParatextType', 'paratext_type_id');
    }
}
