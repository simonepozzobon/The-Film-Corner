<?php

namespace App\Http\Controllers\Api\Admin;

use App\User;

use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function test() {
        $this->destroy(11);
    }

    public function get_users() {
        $users = User::all();
        return [
            'success' => true,
            'users' => $users,
        ];
    }

    public function save_user(Request $request) {
        if (isset($request->id)) {
            $user = User::find($request->id)->first();
        } else {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                $user = new User();
            }
        }

        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->role_id = $request->role_id;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if (isset($user->old_id) && $user->old_id != 0) {
            $user->old_id = $user->old_id;
        } else {
            $user->old_id = 0;
        }

        $user->save();

        return [
            'success' => true,
            'user' => $user,
        ];
    }

    public function destroy($id) {
        $user = User::find($id);
        if (isset($user->students) && $user->students->count() > 0) {
            $students = $user->students;
            foreach ($students as $key => $student) {
                $user->remove_student($student);
            }
        }
        $user->delete();
        return [
            'success' => true,
            'id' => $id
        ];
    }
}
