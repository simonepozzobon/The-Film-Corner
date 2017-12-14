<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FilmographyController extends Controller
{
    public function index()
    {
        
        return view('public.filmography.index');
    }
}
