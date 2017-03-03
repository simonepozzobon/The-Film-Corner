<?php

namespace App\Http\Controllers\Admin;

use App\Teacher;
use App\School;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTeacher;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;

class TeacherController extends Controller
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
      $teachers = Teacher::all();
      $schools = School::all();
      return view('admin.teachers.index')
                    ->with('teachers', $teachers)
                    ->with('schools', $schools);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeacher $request)
    {
        $teacher = new Teacher;
        $teacher->name = $request->input('name');
        $teacher->email = $request->input('email');
        $teacher->password = $request->input('password');
        $teacher->school_id = $request->input('school_id');

        $teacher->save();

        return redirect('admin/teachers')->with('status', 'New teacher created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $teacher = Teacher::findOrFail($id);
      return view('admin.teachers.show')->with('teacher', $teacher);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $teacher = Teacher::findOrFail($id);
      return view('admin.teachers.edit')->with('teacher', $teacher);
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
      $teacher = Teacher::findOrFail($id);
      $teacher->delete();
      return redirect('/admin/teachers')->with('status', 'Teacher deleted!');
    }
}
