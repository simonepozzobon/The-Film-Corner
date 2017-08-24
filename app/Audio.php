<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
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