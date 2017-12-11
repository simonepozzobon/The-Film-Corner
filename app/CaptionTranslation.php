<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaptionTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['description'];
}
