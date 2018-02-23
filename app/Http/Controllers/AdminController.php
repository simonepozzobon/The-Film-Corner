<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
// use PragmaRX\Tracker\Vendor\Laravel\Facade as Tracker;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {
         $this->middleware('auth:admin', ['except' => 'logout']);
     }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $admin = Auth::guard('admin')->user();
      $activities = Activity::where([
        ['log_name', '=', 'first-visit'],
        ['description', '=', 'visited']
      ])->causedBy($admin)->get();

      if ($activities->count() == 0) {
          activity()
              ->causedBy($admin)
              ->useLog('first-visit')
              ->withProperties('video-update')
              ->log('visited');
      } else {
          $visited = true;
      }

      // $sessions = Tracker::sessions(60 * 24);
      // $users = Tracker::onlineUsers();
      // $page_views = Tracker::pageViews(60 * 24 * 30);
      $sessions = 0;
      $users = 0;
      $page_views = 0;
      $page_views_tot = 0;
      foreach ($page_views as $key => $page_view) {
        $page_views_tot = $page_views_tot + $page_view->total;
      }

      return view('admin', compact('users', 'sessions', 'page_views_tot', 'visited'));
    }
}
