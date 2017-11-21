<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppKeyword extends Model
{
    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ['name', 'description'];
    protected $table = 'app_keywords';
}
