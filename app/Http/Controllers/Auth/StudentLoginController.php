<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class StudentLoginController extends Controller
{
    public function __contstruct()
    {
        $this->middleware('guest:student');
    }

    public function showLoginForm()
    {
      return view('auth.student-login');
    }

    public function login(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required',
      ]);

      // Attempt to log the user in
      if (Auth::guard('student')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {

        // If succesfull redirect to student Panel
        return redirect()->intended('student');

      }

      // If unseccesfull redirect back
      return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    // Logout function
    public function logout(Request $request)
    {
        Auth::guard('student')->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/student');
    }
}
