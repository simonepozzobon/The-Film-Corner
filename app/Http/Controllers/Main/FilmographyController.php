<?php

namespace App\Http\Controllers\Main;

use Filmography;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FilmographyController extends Controller
{
    public function index()
    {
        $filmographies = Filmography::all();
        return view('public.filmography.index', compact('filmographies'));
    }
}
