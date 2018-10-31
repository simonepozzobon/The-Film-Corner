<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CinemafController extends Controller
{
    public function get_teachers() {
        $teachers = Teacher::where([
            ['streaming', 1]
        ])->with('school')->get();

        $data = collect();

        foreach ($teachers as $key => $teacher) {
            $obj = $this->format_teacher($teacher);
            $data->push($obj);
        }

        return response()->json($data);
    }

    public function auth(Request $request) {

        if (Auth::guard('teacher')->attempt(['email' => $request->email, 'password' => $request->password], null)) {

            // If succesfull redirect to teacher Panel
            $teacher = Teacher::where('email', $request->email)->with('school')->first();
            $obj = $this->format_teacher($teacher);
            return response()->json($obj);

        } else {
            return response('false');
        }
    }

    public function format_teacher($teacher) {
        if ($teacher->status = 1) {
            $status = 'active';
        } else {
            $status = 'suspended';
        }

        if ($teacher->school) {
            $s = $teacher->school;
            $school = [
                'id' => $s->id,
                'name' => $s->name,
                'address' => $s->address,
                'city' => $s->city,
                'postal_code' => $s->postal_code,
                'country' => $s->country,
            ];
        } else {
            $school = 'null';
        }

        $obj = [
            'id' => $teacher->id,
            'name' => $teacher->name,
            'email' => $teacher->email,
            'status' => $status,
            'school' => $school,
        ];

        return $obj;
    }
}
