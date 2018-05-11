<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\AppsSessions\AppsSession;
use App\AppsSessions\StudentAppSession;
use Spatie\Activitylog\Models\Activity;

use PragmaRX\Tracker\Vendor\Laravel\Facade as Tracker;

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

        $tracker = new Tracker();
        $now = Carbon::now()->toDateString();
        $start = Carbon::parse('first day of September 2017');

        $dateInMinutes = $start->diffInMinutes($now);

        // $sessions = Tracker::sessions(60 * 24);
        // $users = Tracker::onlineUsers();
        $pageViews = Tracker::pageViews($dateInMinutes);
        $pageViewsTot = 0;
        foreach ($pageViews as $key => $day) {
            $pageViewsTot = $pageViewsTot + $day->total;
        }

        $sessions = 0;
        $users = 0;
        $page_views_tot = 0;

        $teacher_sessions = AppsSession::where('is_empty', 0)->count();
        $student_sessions = StudentAppSession::where('is_empty', 0)->count();

        $stats = [
            'teacher_sessions' => $teacher_sessions,
            'student_sessions' => $student_sessions,
            'page_views_60dd' => $pageViewsTot,
        ];

        // foreach ($page_views as $key => $page_view) {
        //   $page_views_tot = $page_views_tot + $page_view->total;
        // }

        return view('admin', compact('users', 'sessions', 'page_views_tot', 'visited', 'stats'));
    }
}
