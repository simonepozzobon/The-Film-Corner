<?php

namespace App\Http\Controllers\Admin;

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

        foreach ($teachers as $key => $t) {

            if ($t->status = 1) {
                $status = 'active';
            } else {
                $status = 'suspended';
            }

            if ($t->school) {
                $s = $t->school;
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
                'id' => $t->id,
                'name' => $t->name,
                'email' => $t->email,
                'status' => $status,
                'school' => $school,
            ];
            $data->push($obj);
        }

        return response()->json($data);
    }
}
