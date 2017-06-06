<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{

     public function __construct()
     {
         $this->middleware('auth:student', ['except' => 'logout']);
     }

    public function index()
    {
        return view('student');
    }

    public function filmSpecific()
    {
      return view('student.film-specific.index');
    }

    public function creativeStudio()
    {
      return view('student.creative-studio.index');
    }

    public function cinemaPav()
    {
      return view('student.cinema.index');
    }
}
