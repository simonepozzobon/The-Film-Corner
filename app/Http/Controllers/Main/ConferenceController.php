<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConferenceController extends Controller
{
    public function index()
    {
      return view('public.conference');
    }

    public function about()
    {
      return view('public.conference.about');
    }

    public function schedule()
    {
      return view('public.conference.schedule');
    }

    public function application()
    {
      return view('public.conference.application');
    }

    public function download()
    {
      return view('public.conference.download');
    }

    public function contact()
    {
      return view('public.conference.contact');
    }
    
}
