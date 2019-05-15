<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\User;
use App\Network;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function get_profile(Request $request) {
        $user = Auth::user();
        if ($user->role_id == 1) {
            $user->students = $user->students;
            $user->networks = $user->networks()->with('app')->get();

            $notifications = $user->notifications()->get();
            $activities = array();
            if ($notifications->count() > 0) {
                foreach ($notifications as $key => $notification) {
                    $token = $notification->data['session']['token'];
                    $activity = Network::where('token', '=', $token)->with('app', 'user')->first();
                    if ($activity) {
                        $activity->notification = $notification;
                        array_push($activities, $activity);
                    }

                }
            }
            $user->activities = $activities;

            return [
                'success' => true,
                'user' => $user,
            ];
        }

        return [
            'success' => false,
            'error' => 'unauthorized',
        ];
    }
}
