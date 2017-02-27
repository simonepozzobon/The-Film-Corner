<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeacherLoginController extends Controller
{
  public function showLoginForm()
  {
    return view('auth.teacher-login')
  }

  public function login()
  {
    return true;
  }
}
