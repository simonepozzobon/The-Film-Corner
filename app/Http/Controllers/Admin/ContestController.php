<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\AppsSessions\AppsSession;
use App\Http\Controllers\Controller;
use App\AppsSessions\StudentAppSession;
use Illuminate\Support\Facades\Storage;

class ContestController extends Controller
{
    function index() {
        return view('admin.contest.index');
    }

    function get_video() {
        $teacher = AppsSession::where([
                ['app_id', '=', 16],
                ['title', '!=', 'Untitled']
            ])->orWhere([
                ['app_id', '=', 17],
                ['title', '!=', 'Untitled']
            ])->with('teacher', 'app')->get();

        $student = StudentAppSession::orWhere([
                ['app_id', '=', 16],
                ['teacher_approved', '=', 1],
                ['title', '!=', 'Untitled']
            ])->orWhere([
                ['app_id', '=', 17],
                ['teacher_approved', '=', 1],
                ['title', '!=', 'Untitled']
            ])->with('student', 'app')->get();

        $sessions = collect();

        foreach ($teacher as $key => $t) {
            $sessionJson = json_decode($t->content);
            $t->session = $sessionJson;
            $t->video = Storage::disk('local')->url($sessionJson->video->video);
            $t->img = $sessionJson->video->img;
            $sessions->push($t);
        }

        foreach ($student as $key => $s) {
            $sessionJson = json_decode($s->content);
            $s->session = $sessionJson;
            $s->video = Storage::disk('local')->url($sessionJson->video->video);
            $s->img = $sessionJson->video->img;
            $s->teacher = $s->student->teacher;
            $sessions->push($s);
        }

        return $sessions;
    }
}
