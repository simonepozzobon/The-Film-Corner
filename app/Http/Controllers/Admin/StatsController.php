<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PragmaRX\Tracker\Vendor\Laravel\Facade as Tracker;

class StatsController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth:admin', ['except' => 'logout']);
    }

    public function index()
    {
      $sessions = Tracker::sessions(60 * 24);
      $users = Tracker::onlineUsers();
      $page_views = Tracker::pageViews(60 * 24 * 30);
      $page_views_tot = 0;
      foreach ($page_views as $key => $page_view) {
        $page_views_tot = $page_views_tot + $page_view->total;
      }

      return view('admin.stats.index', compact('users', 'sessions', 'page_views_tot'));
    }
}
