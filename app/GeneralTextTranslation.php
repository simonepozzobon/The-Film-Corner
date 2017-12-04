<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralTextTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['description'];
}
