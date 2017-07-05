<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Utility extends Model
{
  static public function startWith($haystack, $needle)
  {
       $length = strlen($needle);
       return (substr($haystack, 0, $length) === $needle);
  }
}
