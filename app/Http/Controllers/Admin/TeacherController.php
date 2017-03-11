<?php

namespace App\Http\Controllers\Admin;

use App\School;
use App\Teacher;
use App\Student;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTeacher;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
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
        $filename = $request->file('media')->getClientOriginalName();
        $teacherName = $request->input('name');
        $file = $request->file('media')->storeAs('public/teachers/'.$teacherName, $filename);

        // Path where files are stored according to Filesystem.php
        $path = storage_path('app/public/teachers/'.$teacherName);

        // Edit files
        $img_square = Image::make($path.'/'.$filename)->fit(500)->save();

        $teacher = new Teacher;
        $teacher->name = $request->input('name');
        $teacher->email = $request->input('email');
        $teacher->profile_img = $file;
        $teacher->password = $request->input('password');
        $teacher->school_id = $request->input('school_id');
        $teacher->save();

        $request->session()->flash('success', 'New teacher created!');
        return redirect('admin/teachers');
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
      $students = Student::where('teacher_id', '=', $id)->get();
      $students_num = count($students);
      return view('admin.teachers.show')
                  ->with('teacher', $teacher)
                  ->with('students', $students)
                  ->with('students_num', $students_num);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $schools = School::all();
      $teacher = Teacher::findOrFail($id);
      return view('admin.teachers.edit')
                  ->with('teacher', $teacher)
                  ->with('schools', $schools);
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
      $this->validate($request, array(
        'name' => 'required',
        'email' => 'required',
        'password' => 'required',
        'school_id' => 'required',
      ));

      $teacher = Teacher::findOrFail($id);

      // If image has changed
      if ($request->file('media')) {
        $file = $teacher->profile_img;
        Storage::delete($file);
        $filename = $request->file('media')->getClientOriginalName();
        $teacherName = $request->input('name');
        $file = $request->file('media')->storeAs('public/teachers/'.$teacherName, $filename);
        $path = storage_path('app/public/teachers/'.$teacherName);
        $img_square = Image::make($path.'/'.$filename)->fit(500)->save();
        $teacher->profile_img = $file;
      }

      $teacher->status = $request->input('status');
      $teacher->name = $request->input('name');
      $teacher->email = $request->input('email');
      $teacher->password = $request->input('password');
      $teacher->students_slots = $request->input('students_slots');
      $teacher->school_id = $request->input('school_id');
      $teacher->save();

      $request->session()->flash('success', 'Teacher updated!');
      $redirect = 'admin/teachers/'.$teacher->id;
      return redirect()->route('teachers.show', $id);
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
      $file = $teacher->profile_img;
      Storage::delete($file);
      $teacher->delete();
      session()->flash('success', 'Teacher Deleted!');
      return redirect('/admin/teachers');
    }

    public function storeStudent(Request $request, $id)
    {
      $teacher = Teacher::findOrFail($id);
      $this->validate($request, array(
        'name' => 'required',
        'email' => 'required',
        'password' => 'required'
      ));
      $student = new Student;
      $student->name = $request->input('name');
      $student->email = $request->input('email');
      $student->password = $request->input('password');
      $student->teacher_id = $teacher->id;
      $student->school_id = $teacher->school_id;
      $student->save();
      $request->session()->flash('success', 'New student created!');
      return redirect()->route('teachers.show', $id);
    }
}
