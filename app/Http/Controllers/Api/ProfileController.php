<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\User;
use App\Network;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

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

    public function destroy_network($id) {
        $network = Network::find($id);
        if ($network) {
            $network->delete();
            return [
                'success' => true,
            ];
        } else {
            return [
                'success' => false,
                'error' => 'not found'
            ];
        }
    }

    public function destroy_activity($id) {
        $notification = Auth::user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->delete();
            return [
                'success' => true,
            ];
        } else {
            return [
                'success' => false,
                'error' => 'not found'
            ];
        }
    }

    public function save_student(Request $request) {
        $teacher = Auth::user();
        $check = User::where('email', $request->email)->first();
        if (!$check) {
            $user = new User();
            $columns = Schema::getColumnListing($user->getTable());
            foreach ($columns as $key => $column) {
                if ($value == 'password') {
                    $user->password = Hash::make($request->password);
                } else if (isset($request->{$column})) {
                    $user->{$column} = $request->{$column};
                }
            }
            $user->role_id = 2;
            $user->old_id = 0;
            $user->save();
            $teacher->add_student($user);

            return [
                'success' => true,
                'user' => $user,
                'request' => $request->all(),
                'columns' => $columns,
            ];

        } else {
            return [
                'success' => false,
                'error' => 'email-exists',
            ];
        }
    }

    public function update_student(Request $request) {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $columns = Schema::getColumnListing($user->getTable());
            foreach ($columns as $key => $column) {
                if ($column == 'password') {
                    $user->password = Hash::make($request->password);
                } else if (isset($request->{$column})) {
                    $user->{$column} = $request->{$column};
                }
            }

            $user->save();
            
            return [
                'success' => true,
                'user' => $user,
                'request' => $request->all(),
                'columns' => $columns,
            ];

        } else {
            return [
                'success' => false,
                'error' => 'email-exists',
            ];
        }
    }
}
