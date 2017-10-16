<?php

namespace App\Http\Controllers;

use Auth;
use App\Student;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class StudentController extends Controller
{

     public function __construct()
     {
         $this->middleware('auth:student', ['except' => 'logout']);
     }

    public function index()
    {
        $student = Auth::guard('student')->user();

        $activities = Activity::where([
          ['log_name', '=', 'first-visit'],
          ['description', '=', 'visited']
        ])->causedBy($student)->get();

        if ($activities->count() == 0) {
            activity()
                ->causedBy($student)
                ->useLog('first-visit')
                ->log('visited');

            return view('student.first_visit.index', $student);

        } else {
            $visited = true;
            return view('student')->with('teacher', $student);
        }

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

    public function welcome()
    {
      return view('student.first_visit.index');
    }
}
