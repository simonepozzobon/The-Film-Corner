<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => 'logout']);
    }

    public function index()
    {
      $admins = Admin::all();
      return view('admin.admins.index')->with('admins', $admins);
    }
}
