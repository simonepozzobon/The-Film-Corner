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

    public function deleteStudent(Request $request)
    {
      $student = Student::find($request['id']);
      $student->delete();

      $data = [
        'id' => $request['id']
      ];

      return response()->json($data);
    }
}
