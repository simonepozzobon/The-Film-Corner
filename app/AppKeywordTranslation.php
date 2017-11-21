<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppKeywordTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'desription'];
}
