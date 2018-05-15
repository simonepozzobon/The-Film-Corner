<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\AppsSessions\AppsSession;
use App\AppsSessions\StudentAppSession;
use Spatie\Activitylog\Models\Activity;

use PragmaRX\Tracker\Vendor\Laravel\Facade as Tracker;

use Analytics;
use Spatie\Analytics\Period;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => 'logout']);
    }

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
        $now = Carbon::now();
        $start = Carbon::parse('first day of September 2017');

        $dateInMinutes = $start->diffInMinutes($now);
        $pageViews = Tracker::pageViews($dateInMinutes);
        $pageViewsTot = 0;
        foreach ($pageViews as $key => $day) {
            $pageViewsTot = $pageViewsTot + $day->total;
        }

        $teacher_sessions = AppsSession::where('is_empty', 0)->count();
        $student_sessions = StudentAppSession::where('is_empty', 0)->count();

        // Most Visited Page this week
        $mostVisitedPages = Analytics::fetchMostVisitedPages(Period::days(7));
        $mostVisitedPage = $mostVisitedPages->filter(function($page, $key) {
            return ($page['url'] != '/' && strpos($page['url'], 'admin') == false);
        })->first();


        // Visitors
        $period = Period::create($start, $now);
        $visitors = Analytics::fetchTotalVisitorsAndPageViews($period);
        $visitorsTot = 0;
        foreach ($visitors as $key => $day) {
            $visitorsTot = $visitorsTot + $day['visitors'];
        }

        // Browser
        $browsers = Analytics::fetchTopBrowsers($period, 10);

        // Users Type
        $usersType = Analytics::fetchUserTypes($period);

        // Durata media della sessione
        $sessionTime = Analytics::performQuery($period, 'ga:sessions,ga:sessionDuration');
        $sessionTimeSessions = $sessionTime->totalsForAllResults['ga:sessions'];
        $sessionTimeSessionsDuration = $sessionTime->totalsForAllResults['ga:sessionDuration'];
        $sessionTime = gmdate('H:i:s', ($sessionTimeSessionsDuration / $sessionTimeSessions));

        // Geo country
        $geos = Analytics::performQuery($period, 'ga:sessions', [
            'dimensions' => 'ga:country'
        ]);
        $results = $geos->rows;
        $geos = collect();
        foreach ($results as $key => $result) {
            $geo = (object) [
                'country' => $result[0],
                'views' => $result[1]
            ];
            $geos->push($geo);
        }
        // dump($geos);

        $stats = [
            'teacher_sessions' => $teacher_sessions,
            'student_sessions' => $student_sessions,
            'page_views_60dd' => $pageViewsTot,
            'most_visited_page' => $mostVisitedPage,
            'visitors_tot' => $visitorsTot,
            'browsers' => $browsers,
            'users_type' => $usersType,
            'session_time_avg' => $sessionTime,
            'geos' => $geos,
            'geosArr' => $results,
        ];

        return view('admin', compact('visited', 'stats'));
    }
}
