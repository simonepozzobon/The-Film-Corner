<?php

namespace App\Http\Controllers\Admin;

use App\Student;
use App\School;
use App\Teacher;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStudent;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {
         $this->middleware('auth:admin', ['except' => 'logout']);
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::all();
        $schools = School::all();
        $teachers = Teacher::all();
        return view('admin.students.index')
                      ->with('students', $students)
                      ->with('teachers', $teachers)
                      ->with('schools', $schools);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudent $request)
    {
      $student = new Student;
      $student->name = $request->input('name');
      $student->email = $request->input('email');
      $student->password = $request->input('password');
      $student->teacher_id = $request->input('teacher_id');
      $student->school_id = $request->input('school_id');

      $student->save();

      return redirect('admin/students')->with('status', 'New student created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
