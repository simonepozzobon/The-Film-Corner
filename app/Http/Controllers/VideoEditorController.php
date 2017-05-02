<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lanin\Laravel\ApiDebugger\Facade;
use App\Test;

class VideoEditorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function updateEditor(Request $request)
    {
        $data = $request->all();
        foreach ($data as $key => $media) {
          $save = new Test;
          $save->media_url = $media['media_url'];
          $save->start = $media['start'];
          $save->duration = $media['duration'];
          $save->save();
        }



        return response()->json(compact('data'));
    }

}
