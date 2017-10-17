<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
      $sessions = Tracker::sessions(60 * 24);
      $users = Tracker::onlineUsers();
      $page_views = Tracker::pageViews(60 * 24 * 30);
      $page_views_tot = 0;
      foreach ($page_views as $key => $page_view) {
        $page_views_tot = $page_views_tot + $page_view->total;
      }

      return view('admin', compact('users', 'sessions', 'page_views_tot'));
    }
}
