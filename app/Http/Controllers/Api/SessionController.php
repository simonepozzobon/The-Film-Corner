<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SessionController extends Controller
{
    public function new_session(Request $request) {
        $session = new Session();
        $user = Auth::user();
        return [
            'user' => $user
        ];
    }
}
