<?php

namespace App\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function attempt_login(Request $r) {
        $credentials = $r->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return [
                'status' => true,
            ];
        }
        return [
            'status' => true,
        ];
    }

    public function logout(Request $r) {
        Auth::logout();
        return redirect()->url('/');
    }
}
