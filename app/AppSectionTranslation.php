<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppSectionTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'description'];
}
