<?php

namespace App\Http\Controllers;

use Auth;
use App\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {
         $this->middleware('auth:teacher', ['except' => 'logout']);
     }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
        $teacher = Teacher::find($id);
        return view('teacher')->with('teacher', $teacher);
    }
}
