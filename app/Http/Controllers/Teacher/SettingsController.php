<?php

namespace App\Http\Controllers\Teacher;

use Validator;
use App\Student;
use App\SharedSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\AppsSessions\StudentAppSession;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:teacher', ['except' => 'logout']);
    }

    public function index()
    {
        // Raccolgo i dati sugli utenti
        $teacher = Auth::guard('teacher')->user();
        $students = Student::where('teacher_id', '=', $teacher->id)->get();

        // prendo le notifiche dell'insegnante
        $notifications = $teacher->notifications()->get();

        // preparo la formattazione delle notifiche
        $sessions = collect();
        if ($notifications->count() > 0) {
            foreach ($notifications as $key => $notification) {
                $token = $notification->data['session']['token'];
                $session = StudentAppSession::where('token', '=', $token)->first();
                if ($session) {
                    $session->notification = $notification;
                    $sessions->push($session);
                }

            }
        }

        // Estraggo gli id degli studenti appartenenti all'insegnante e li
        // converto in array
        $studentsIds = $students->pluck('id')->toArray();

        // Trovo le sessioni condivise appartenenti all'insegnante e quelle
        // appartenenti ai suoi studenti con una query avanzata
        $shared_sessions = SharedSession::where([
            ['userable_type', '=', 'App\Teacher'],
            ['userable_id', '=', $teacher->id]
        ])->orWhere(function($q) use ($studentsIds){
            $q->where('userable_type', 'App\Student')
                ->whereIn('userable_id', $studentsIds);
        })->with('comments', 'likes', 'author', 'app')->get();

        // Conteggio le risposte insieme ai commenti
        foreach ($shared_sessions as $key => $shared) {
            $comments = $shared->comments()->get();
            $replies = 0;
            foreach ($comments as $key => $comment) {
                $comment_replies = $comment->comments()->count();
                $replies = $replies + $comment_replies;
            }
            $shared->comments_count = $comments->count() + $replies;
        }


        return view('teacher.settings.index', compact('students', 'teacher', 'notifications', 'sessions', 'shared_sessions'));
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
