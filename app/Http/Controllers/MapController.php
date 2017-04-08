<?php

namespace App\Http\Controllers;

use App\Point;
use App\City;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
      $points = Point::all();
      foreach ($points as $key => $point) {
        $videoID = '';
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+|(?<=embed/)[^&\n]+#", $point->video_link, $videoID);
        $point->video_id = $videoID[0];
      }
      return view('map.index')->with('points', $points);
    }

}
