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
      return view('map.index')->with('points', $points);
    }

}
