<?php

namespace App\Http\Controllers;

use Auth;
use App\Guest;
use App\AppSection;
use App\WelcomeForm;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class GuestController extends Controller
{

     public function __construct()
     {
         $this->middleware('auth:guest', ['except' => 'logout']);
     }

    public function index()
    {
        $guest = Auth::guard('guest')->user();

        $activities = Activity::where([
          ['log_name', '=', 'first-visit'],
          ['description', '=', 'visited']
        ])->causedBy($guest)->get();

        if ($activities->count() == 0) {
            activity()
                ->causedBy($guest)
                ->useLog('first-visit')
                ->log('visited');

            $form = WelcomeForm::where([
                ['userable_id', '=', $guest->id],
                ['userable_type', '=', get_class($guest)]
            ])->first();

            return view('guest.first_visit.index', compact('guest', 'form'));
        } else {
            $visited = true;
            return view('guest')->with('guest', $guest);
        }

    }

    public function filmSpecific()
    {
      $section = AppSection::where('slug', '=', 'film-specific')->first();

      $guest = Auth::guard('guest')->user();
      $activities = Activity::where('description', '=', 'visited')->causedBy($guest)->forSubject($section)->get();

      if ($activities->count() == 0) {
        activity()
          ->causedBy($guest)
          ->performedOn($section)
          ->withProperties('visited', true)
          ->log('visited');
      } else {
        $visited = true;
      }

      return view('guest.film-specific.index', compact('visited', 'section'));
    }

    public function creativeStudio()
    {
      $section = AppSection::where('slug', '=', 'creative-studio')->first();

      $guest = Auth::guard('guest')->user();
      $activities = Activity::where('description', '=', 'visited')->causedBy($guest)->forSubject($section)->get();

      if ($activities->count() == 0) {
        activity()
          ->causedBy($guest)
          ->performedOn($section)
          ->withProperties('visited', true)
          ->log('visited');
      } else {
        $visited = true;
      }

      return view('guest.creative-studio.index', compact('visited', 'section'));
    }

    public function cinemaPav()
    {
      return view('guest.cinema.index');
    }

    public function path()
    {
      return view('guest.path.index');
    }

    public function welcome()
    {
      $user = Auth::guard('guest')->user();
      $user_type = get_class($user);

      $form = WelcomeForm::where([
        ['userable_id', '=', $user->id],
        ['userable_type', '=', $user_type]
      ])->first();

      if (!$form) {
        $form = '';
      }

      return view('guest.first_visit.index', compact('form'));
    }
}
