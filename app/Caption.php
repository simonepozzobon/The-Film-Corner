<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caption extends Model
{
    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ['description'];
    protected $table = 'captions';
    protected $fillable = [];
}
