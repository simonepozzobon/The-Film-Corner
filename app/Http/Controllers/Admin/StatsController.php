<?php

namespace App\Http\Controllers\Admin;

use Analytics;
use Carbon\Carbon;
use App\AnalyticsUtility;
use Illuminate\Http\Request;
use Spatie\Analytics\Period;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PragmaRX\Tracker\Vendor\Laravel\Facade as Tracker;

class StatsController extends Controller
{
    public function index()
    {
        //old
        $sessions = Tracker::sessions(60 * 24);
        $users = Tracker::onlineUsers();
        $page_views = Tracker::pageViews(60 * 24 * 30);
        $page_views_tot = 0;
        foreach ($page_views as $key => $page_view) {
            $page_views_tot = $page_views_tot + $page_view->total;
        }

      return view('admin.stats.index', compact('users', 'sessions', 'page_views_tot'));
    }

    public function get_app_chart(Request $request) {
        $now = Carbon::now();
        $start = Carbon::parse('first day of September 2017');
        $period = Period::create($start, $now);

        $mostUsedAppList = AnalyticsUtility::get_most_used_app($period);
        $mostUsedAppSorted = $mostUsedAppList->sortByDesc('count')->values();

        return $mostUsedAppSorted;
    }

    public function get_page_views(Request $request) {
        $now = Carbon::now();
        $start = Carbon::parse('first day of September 2017');
        $period = Period::create($start, $now);

        $pageViews = AnalyticsUtility::get_page_views($period);
        return $pageViews;
    }

    public function test() {
        $now = Carbon::now();
        $start = Carbon::parse('first day of September 2017');

        $dateInMinutes = $start->diffInMinutes($now);
        $sessions = Tracker::sessions($dateInMinutes);
        dd($sessions);

        $counts = 0;
        $countsAdmin = 0;
        $countsInside = 0;
        $countsOutside = 0;

        $adminPaths = ['admin'];
        $insidePaths = ['teacher', 'student', 'guest'];

        foreach ($sessions as $session) {
            foreach ($session->log as $log) {
                $path = $log->path->path;
                if ($this->is_contained($path, $adminPaths)) {
                    $countsAdmin ++;
                } else if ($this->is_contained($path, $insidePaths)) {
                    $countsInside ++;
                } else {
                    $countsOutside ++;
                }
                $counts ++;
            }
        }


        dump('admin -> '.$countsAdmin);
        dump('inside -> '.$countsInside);
        dump('outside -> '.$countsOutside);
        dd('globali -> '.$counts);
    }

    public function is_contained($path, $arr) {
        foreach ($arr as $word) {
            if (strpos($path, $word) !== false) {
                return true;
            }
            return false;
        }
    }
}
