<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class GuestLoginController extends Controller
{
    public function __contstruct()
    {
        $this->middleware('guest:guest');
    }

    public function showLoginForm()
    {
        return view('auth.guest-login');
    }

    public function login(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the user in
        if (Auth::guard('guest')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {

            // If succesfull redirect to guest Panel
            return redirect()->intended('guest');

        }

        // If unseccesfull redirect back
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    // Logout function
    public function logout(Request $request)
    {
        Auth::guard('guest')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/guest');
    }
}
