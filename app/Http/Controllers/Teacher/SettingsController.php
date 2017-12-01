<?php

namespace App\Http\Controllers\Teacher;

use Validator;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:teacher', ['except' => 'logout']);
    }

    public function index()
    {
        $teacher = Auth::guard('teacher')->user();
        $students = Student::where('teacher_id', '=', $teacher->id)->get();

        $notifications = $teacher->notifications()->get();

        return view('teacher.settings.index', compact('students', 'teacher', 'notifications'));
    }

    public function storeStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        $teacher = Auth::guard('teacher')->user();

        $student = new Student;
        $student->name = $request['name'];
        $student->email = $request['email'];
        $student->password = Hash::make($request['password']);
        $student->teacher_id = $teacher->id;
        $student->save();

        $data = [
            'id' => $student->id,
            'name' => $student->email,
        ];

        return response()->json($data);
    }

    public function save_student(Request $r)
    {
        $teacher = Auth::guard('teacher')->user();

        $check = Student::where('email', '=', $r->email)->first();

        // Se lo studente collegato alla email non esiste ne creo uno nuovo
        if ($check == null) {
            $student = new Student;
        } else {
            return response('Error, mail already exist!', 400);
        }

        $student->name = $r->name;
        $student->email = $r->email;
        $student->password = Hash::make($r->password);
        $student->teacher_id = $teacher->id;
        $student->save();

        return response()->json($student, 200);
    }

    public function update_student(Request $r)
    {
        $student = Student::where('email', '=', $r->email)->first();

        if ($student == null) {
            return response('Error, student not found!', 400);
        } else {

            $teacher = Auth::guard('teacher')->user();

            if ($teacher == $student->teacher()->first()) {

                $student->name = $r->name;
                $student->email = $r->email;

                if ($r->password != null) {
                    $student->password = Hash::make($r->password);
                }

                $student->teacher_id = $teacher->id;
                $student->save();

                return response()->json($student, 200);

            } else {

                return response('Error, unauthorized request!', 400);

            }
        }
    }

    public function deleteStudent(Request $request)
    {
        $student = Student::find($request['id']);
        $student->delete();

        $data = [
            'id' => $request['id']
        ];

        return response()->json($data);
    }

    public function destroy_student(Request $r)
    {
        $student = Student::find($r->id);
        $student->delete();
        return response()->json($student, 200);
    }

    public function get_slots()
    {
        $teacher = Auth::guard('teacher')->user();
        $slots = $teacher->students_slots;
        $students = $teacher->students()->count();
        $slots_available = $slots - $students;

        return response()->json([
            'slots' => $slots,
            'slots_available' => $slots_available
        ], 200);
    }
}
