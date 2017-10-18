<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
  protected $table = 'audios';

  public function category()
  {
    return $this->belongsTo('App\MediaCategory');
  }

  public function appsSessions()
  {
      return $this->morphedByMany('App\AppsSessions\AppsSession', 'audioable');
  }

  public function studentAppSessions()
  {
      return $this->morphedByMany('App\AppsSessions\StudentAppSession', 'audioable');
  }

  public function teachers()
  {
      return $this->morphedByMany('App\Teacher', 'audioable');
  }

  public function students()
  {
      return $this->morphedByMany('App\Student', 'audioable');
  }

  public function apps()
  {
      return $this->morphedByMany('App\App', 'audioable');
  }

  public function appCategories()
  {
      return $this->morphedByMany('App\AppCategory', 'audioable');
  }

  public function appSection()
  {
      return $this->morphedByMany('App\AppCategory', 'audioable');
  }

  public function mediaSubCategories()
  {
      return $this->morphedByMany('App\MediaSubCategory', 'audioable');
  }

  public function tToS ($t)
  {

    // converte i tick in secondi
    $s = $t * 5 / 100;
    return $s;

  }

  public function trimStart($data)
  {
    // se non c'è nulla all'inizio sposto tutto
    if ($data[0]['start'] == 0) {
      // è già tutto all'inizio
      return $data;
    } else {
      // calcolo la distanza dall'inizio
      $distance = $data[0]['start'];
      foreach ($data as $key => $media) {
        $newStart = $media['start'] - $distance;
        $media['start'] = $newStart;
      }
      return $data;
    }
  }
}
