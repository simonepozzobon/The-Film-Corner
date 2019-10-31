<?php

namespace App\Http\Controllers;

use Auth;
use App\Category;
use App\Student;
use App\Teacher;
use App\User;
use Illuminate\Http\Request;
use App\AppsSessions\StudentAppSession;
// use App\Http\Requests;

class TestController extends Controller
{   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:admin', ['except' => 'logout']);
    }

    public function index()
    {
        $category = Category::all();
        return response()->json($category);
    }

    public function store(Request $request)
    {
        $category = new Category;
        $category->name = $request->input('name');
        $category->save();
        return response()->json(array( 'success' => true ));
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['success' => true]);
    }

    public function show($id) {
        return $id;
    }

    public function test()
    {
        $student = Student::find(2);
        $session = StudentAppSession::where('token', '=', '5a6b3796c3b8a')->with('student', 'app')->first();
        $count = $session->count_currently_shared_sessions($student->id);
        dd($count);
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
}
