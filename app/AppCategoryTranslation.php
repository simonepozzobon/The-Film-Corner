<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppCategoryTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'desription'];
}
