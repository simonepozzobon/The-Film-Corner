<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lanin\Laravel\ApiDebugger\Facade;
use App\Test;
use App\Video;

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

    public function updateEditor(Request $request, Video $t)
    {
        $Video = new Video; // inizializzo la classe Video per utilizzarla dopo

        // Prendo i dati
        $data = $request->all();

        // Li ordino
        $start = array();
        foreach ($data as $key => $media) {
          $start[$key] = $media['start'];
        }
        array_multisort($start, SORT_ASC, $data);

        // Se c'è qualcosa all'inizio della timeline li salvo
        if ($data[0] == 0) {
          // Li salvo nel db per debug
          foreach ($data as $key => $media) {
            $save = new Test;
            $save->media_url = $media['media_url'];
            $save->start = $Video->tToS($media['start']);
            $save->duration = $Video->tToS($media['duration']);
            $save->save();
          }
        } else {
          // non c'è nulla all'inizio
          $distance = $data[0]['start'];

          foreach ($data as $key => $media) {
            $newStart = $media['start'] - $distance;
            $save = new Test;
            $save->media_url = $media['media_url'];
            $save->start = $Video->tTos($newStart);
            $save->duration = $Video->tToS($media['duration']);
            $save->save();
          }
        }





        return response()->json(compact('data'));
    }

}
