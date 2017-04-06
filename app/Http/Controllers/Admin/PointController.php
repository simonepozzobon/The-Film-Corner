<?php

namespace App\Http\Controllers\Admin;

use App\Point;
use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PointController extends Controller
{
    public function index()
    {
        $cities = City::all();
        $points = Point::all();
        $test = [];
        foreach ($points as $key => $point) {
          $point->city_nome = $point->city->name;
        }
        $content = collect([
          'cities' => $cities,
          'points' => $points,
        ]);
        return response()->json($content);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $point = new Point;
        $point->title = $request->input('title');
        $point->lat = $request->input('lat');
        $point->lng = $request->input('lng');
        $point->place_name = $request->input('place_name');
        $point->genre = $request->input('genre');
        $point->director = $request->input('director');
        $point->actors = $request->input('actors');
        $point->video_link = $request->input('video_link');
        $point->sinossi = $request->input('sinossi');
        $point->city_id = $request->input('city_id');
        $point->save();
        return response()->json(['success' => true]);

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
      $cities = City::all();
      $point = Point::findOrFail($id);
      $point->city_name = $point->city->name;
      $content = collect([
        'cities' => $cities,
        'point' => $point,
      ]);
      return response($content);
    }

    public function update(Request $request, $id)
    {
        $point = Point::findOrFail($id);
        $point->title = $request->input('title');
        $point->lat = $request->input('lat');
        $point->lng = $request->input('lng');
        $point->place_name = $request->input('place_name');
        $point->genre = $request->input('genre');
        $point->director = $request->input('director');
        $point->actors = $request->input('actors');
        $point->video_link = $request->input('video_link');
        $point->sinossi = $request->input('sinossi');
        $point->city_id = $request->input('city_id');
        $point->save();
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $point = Point::findOrFail($id);
        $point->delete();
        return response()->json(['success' => true]);
    }
}
