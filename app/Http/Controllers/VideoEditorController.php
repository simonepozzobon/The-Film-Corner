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
        // Prendo i dati
        $data = $request->all();

        // Li ordino
        $start = array();
        foreach ($data as $key => $media) {
          $start[$key] = $media['start'];
        }
        array_multisort($start, SORT_ASC, $data);

        // Li salvo nel db per debug
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
