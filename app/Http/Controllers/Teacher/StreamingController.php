<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StreamingController extends Controller
{
    public function index() {
        return view('teacher.streaming.index');
    }
}
