<?php

namespace App\Http\Controllers;

use Auth;
use App\Teacher;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class TeacherController extends Controller
{

     public function __construct()
     {
         $this->middleware('auth:teacher', ['except' => 'logout']);
     }

    public function index()
    {
        $teacher = Auth::guard('teacher')->user();

        $activities = Activity::where([
          ['log_name', '=', 'first-visit'],
          ['description', '=', 'visited']
        ])->causedBy($teacher)->get();

        if ($activities->count() == 0) {
            activity()
                ->causedBy($teacher)
                ->useLog('first-visit')
                ->log('visited');

            return view('teacher.first_visit.index', $teacher);

        } else {
            $visited = true;
            return view('teacher')->with('teacher', $teacher);
        }

    }

    public function filmSpecific()
    {
      return view('teacher.film-specific.index', compact('visited'));
    }

    public function creativeStudio()
    {
      return view('teacher.creative-studio.index');
    }

    public function cinemaPav()
    {
      return view('teacher.cinema.index');
    }

    public function path()
    {
      return view('teacher.path.index');
    }
}
