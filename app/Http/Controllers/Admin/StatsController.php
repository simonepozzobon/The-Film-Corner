<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PragmaRX\Tracker\Vendor\Laravel\Facade as Tracker;
use Analytics;
use App\AnalyticsUtility;
use Spatie\Analytics\Period;

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
}
