<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilmographyTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'description'];
}
