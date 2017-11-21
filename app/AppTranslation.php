<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'description'];
}
