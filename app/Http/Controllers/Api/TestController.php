<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Teacher;
use App\Student;
use App\User;
use App\Network;
use App\SharedSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class TestController extends Controller
{
    public function test() {
        $user = User::find(1);
        $networks = $user->networks;
        dd($networks);
    }

    public function convert_shared_sessions_to_networs() {
        $sessions = SharedSession::all();

        foreach ($sessions as $key => $session) {
            $n = new Network();
            $columns = Schema::getColumnListing($n->getTable());
            foreach ($columns as $key => $value) {
                if ($value == 'user_id') {
                    $type = $session->userable_type;
                    $role_id = 1;
                    if ($type == 'App\\Teacher') {
                        $role_id = 2;
                    }

                    $user = User::where([
                        ['role_id', '=', $role_id],
                        ['old_id', '=', $session->userable_id],
                    ])->first();

                    if ($user) {
                        $n->user_id = $user->id;
                    } else {
                        $n->user_id = 1;
                    }
                } else {
                    $n->{$value} = $session->{$value};
                }
            }
            $n->save();
            dump($n->title);
        }

    }

    public function convert_teacher_to_user() {
        $teachers = Teacher::all();

        foreach ($teachers as $key => $teacher) {
            $user = new User();
            $user->role_id = 1;
            $user->old_id = $teacher->id;
            $user->name = $teacher->name;
            $user->email = $teacher->email;
            $user->password = $teacher->password;
            $user->remember_token = $teacher->remember_token;
            $user->created_at = $teacher->created_at;
            $user->updated_at = $teacher->updated_at;
            $user->save();
            dump('Insegnante convertito -> ' . $user->email);
        }

        dd('completato');
    }

    public function convert_student_to_user() {
        $students = Student::all();

        foreach ($students as $key => $student) {
            $check = User::where('email', $student->email)->first();
            if ($check) {
                var_dump('stessa mail', $student->email);
            } else {
                $old_teacher = $student->teacher;
                $new_teacher = User::where('old_id', $old_teacher->id)->first();

                if ($new_teacher) {
                    $user = new User();
                    $user->role_id = 2;
                    $user->name = $student->name;
                    $user->email = $student->email;
                    $user->password = $student->password;
                    $user->remember_token = $student->remember_token;
                    $user->old_id = $student->id;
                    $user->save();

                    $new_teacher->add_student($user);
                    dump('studente aggiunto');
                    dump($new_teacher->email);
                    dump($user->email);
                } else {
                    dd('nuovo insegnante non trovato');
                }
            }
        }
        dd($students);
    }
}
