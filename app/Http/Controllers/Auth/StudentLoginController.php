<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentLoginController extends Controller
{
  public function showLoginForm()
  {
    return view('auth.student-login')
  }

  public function login()
  {
    return true;
  }
}
