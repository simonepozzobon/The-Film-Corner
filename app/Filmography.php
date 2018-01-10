<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filmography extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['title', 'description'];
    protected $table = 'filmographies';

}
