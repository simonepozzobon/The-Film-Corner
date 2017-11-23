<?php

namespace App\Http\Controllers;

use Auth;
use App\Teacher;
use App\AppSection;
use App\WelcomeForm;
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
      $section = AppSection::where('slug', '=', 'film-specific')->first();

      $teacher = Auth::guard('teacher')->user();
      $activities = Activity::where('description', '=', 'visited')->causedBy($teacher)->forSubject($section)->get();

      if ($activities->count() == 0) {
        activity()
          ->causedBy($teacher)
          ->performedOn($section)
          ->withProperties('visited', true)
          ->log('visited');
      } else {
        $visited = true;
      }

      return view('teacher.film-specific.index', compact('visited', 'section'));
    }

    public function creativeStudio()
    {
      $section = AppSection::where('slug', '=', 'creative-studio')->first();

      $teacher = Auth::guard('teacher')->user();
      $activities = Activity::where('description', '=', 'visited')->causedBy($teacher)->forSubject($section)->get();

      if ($activities->count() == 0) {
        activity()
          ->causedBy($teacher)
          ->performedOn($section)
          ->withProperties('visited', true)
          ->log('visited');
      } else {
        $visited = true;
      }

      return view('teacher.creative-studio.index', compact('visited', 'section'));
    }

    public function cinemaPav()
    {
      return view('teacher.cinema.index');
    }

    public function path()
    {
      return view('teacher.path.index');
    }

    public function welcome()
    {
      $user = Auth::guard('teacher')->user();
      $user_type = get_class($user);

      $form = WelcomeForm::where([
        ['userable_id', '=', $user->id],
        ['userable_type', '=', $user_type]
      ])->first();

      if (!$form) {
        $form = '';
      }

      return view('teacher.first_visit.index', compact('form'));
    }
}
