<?php

namespace App\Http\Controllers;

use Auth;
use App\Student;
use App\AppSection;
use App\WelcomeForm;
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

            $form = WelcomeForm::where([
                      ['userable_id', '=', $student->id],
                      ['userable_type', '=', get_class($student)]
                  ])->first();

        } else {
            $visited = true;
            return view('student', compact('student', 'form'));
        }

    }

    public function filmSpecific()
    {
      $section = AppSection::where('slug', '=', 'film-specific')->first();

      $student = Auth::guard('student')->user();
      $activities = Activity::where('description', '=', 'visited')->causedBy($student)->forSubject($section)->get();

      if ($activities->count() == 0) {
        activity()
          ->causedBy($student)
          ->performedOn($section)
          ->withProperties('visited', true)
          ->log('visited');
      } else {
        $visited = true;
      }

      return view('student.film-specific.index', compact('visited', 'section'));
    }

    public function creativeStudio()
    {
      $section = AppSection::where('slug', '=', 'creative-studio')->first();

      $student = Auth::guard('student')->user();
      $activities = Activity::where('description', '=', 'visited')->causedBy($student)->forSubject($section)->get();

      if ($activities->count() == 0) {
        activity()
          ->causedBy($student)
          ->performedOn($section)
          ->withProperties('visited', true)
          ->log('visited');
      } else {
        $visited = true;
      }

      return view('student.creative-studio.index', compact('visited', 'section'));
    }

    public function cinemaPav()
    {
      return view('student.cinema.index');
    }

    public function path()
    {
      return view('student.path.index');
    }

    public function welcome()
    {
      $user = Auth::guard('student')->user();
      $user_type = get_class($user);

      $form = WelcomeForm::where([
        ['userable_id', '=', $user->id],
        ['userable_type', '=', $user_type]
      ])->first();

      if (!$form) {
        $form = '';
      }

      return view('student.first_visit.index', compact('form'));
    }
}
