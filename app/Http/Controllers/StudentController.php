<?php

namespace App\Http\Controllers;

use Auth;
use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{

     public function __construct()
     {
         $this->middleware('auth:student', ['except' => 'logout']);
     }

    public function index()
    {
        $id = Auth::id();
        $student = Student::find($id);
        return view('student')->with('student', $student);
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

    public function path()
    {
      return view('teacher.path.index');
    }
}
