<?php

namespace App\Http\Controllers;

use App\Point;
use App\City;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
      $cities = City::all();
      $points = Point::all();
      $content = collect([
          'cities' => $cities,
          'points' => $points,
      ]);

      return view('map.index', collect(['cities' => $cities, 'points' => $points,]));
    }

}
