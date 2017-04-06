<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
  protected $table = 'points';

  protected $fillable = [
    'title',
    'lat',
    'lng',
    'place_name',
    'genre',
    'director',
    'actors',
    'video_link',
    'sinossi',
    'city_id',
  ];

    public function city()
    {
      return $this->belongsTo('App\City');
    }
}
