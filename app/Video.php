<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    public function tToS ($t)
    {
      // converte i tick in secondi
      $s = $t * 5 / 100;
      return $s;
    }
}
