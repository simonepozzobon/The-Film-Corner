<?php

namespace App\Http\Controllers\Student;

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
      $this->middleware('auth:student', ['except' => 'logout']);

    }

    public function index()
    {
      $student = Auth::guard('student')->user();
      $students = Student::where('student_id', '=', $student->id)->get();

      return view('student.settings.index', compact('students', 'student'));
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
      $student = Auth::guard('student')->user();

      $student = new Student;
      $student->name = $request['name'];
      $student->email = $request['email'];
      $student->password = Hash::make($request['password']);
      $student->student_id = $student->id;
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
