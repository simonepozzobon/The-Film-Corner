<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\User;
use App\Network;
use App\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class ProfileController extends Controller
{
    public function test()
    {
        // $user = User::find(349);
        $request = new Request();
        // $notifications = $user->notifications()->get();
        // $test = $this->get_notifications($notifications);
        $test = $this->get_profile($request);
        dd($test);
    }

    public function get_profile(Request $request)
    {
        // $user = Auth::user();
        // return [
        //   $request->user(),
        // ];
        $user = $request->user();
        if ($user->role_id == 1) {
            $students = $user->students;
            $user->students = $students;

            $networks = $user->networks()->with('app', 'user', 'comments', 'likes')->get();

            foreach ($students as $key => $student) {
                $student_net = $student->networks()->with('app', 'user', 'comments', 'likes')->get();
                $networks = $networks->concat($student_net);
            }

            $notifications = $user->notifications()->get();
            $user->activities = $this->get_notifications($notifications);
            $user->networks = $networks;

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

    public function destroy_network($id)
    {
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

    public function get_notifications($notifications)
    {
        $activities = array();

        if ($notifications->count() > 0) {
            foreach ($notifications as $key => $notification) {
                // dd($notification->data);
                $sender = User::find($notification->data['sender']);
                $user = User::find($notification->data['user']);
                $session = Session::where('token', $notification->data['session'])->with('app', 'user')->first();

                if ($session->is_shared == 0) {
                    $notification->data = [
                      'sender' => $sender,
                      'user' => $user,
                      'session' => $session
                    ];

                    array_push($activities, $notification);
                } else {
                    $activity = Network::where('token', '=', $notification->data['session'])->with('app', 'user')->first();

                    if ($activity) {
                        $notification->data = [
                            'sender' => $sender,
                            'user' => $user,
                            'session' => $session
                        ];

                        $activity->notification = $notification;
                        array_push($activities, $activity);
                    }
                }
            }
        }
        return $activities;
    }

    public function destroy_activity($id)
    {
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

    public function save_student(Request $request)
    {
        $teacher = Auth::user();
        $check = User::where('email', $request->email)->first();
        if (!$check) {
            $user = new User();
            $columns = Schema::getColumnListing($user->getTable());
            foreach ($columns as $key => $column) {
                if ($column == 'password') {
                    $user->password = Hash::make($request->password);
                } elseif (isset($request->{$column})) {
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

    public function update_student(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $columns = Schema::getColumnListing($user->getTable());
            foreach ($columns as $key => $column) {
                if ($column == 'password') {
                    $user->password = Hash::make($request->password);
                } elseif (isset($request->{$column})) {
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
