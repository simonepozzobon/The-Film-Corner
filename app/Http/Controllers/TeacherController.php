<?php

namespace App\Http\Controllers;

use Auth;
use App\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{

     public function __construct()
     {
         $this->middleware('auth:teacher', ['except' => 'logout']);
     }

    public function index()
    {
        $id = Auth::id();
        $teacher = Teacher::find($id);
        return view('teacher')->with('teacher', $teacher);
    }

    public function filmSpecific()
    {
      return view('teacher.film-specific.index');
    }

    public function creativeStudio()
    {
      return view('teacher.creative-studio.index');
    }

    public function cinemaPav()
    {
      return view('teacher.cinema.index');
    }
}
