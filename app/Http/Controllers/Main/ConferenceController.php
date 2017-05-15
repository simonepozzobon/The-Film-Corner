<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Mail\ConferenceApply;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;


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

    public function sendApplication(Request $request)
    {
      $this->validate($request, [
        'name' => 'required|min:3',
        'surname' => 'required|min:3',
        'email' => 'required|email',
      ]);

      $data = [
        'name' => $request->input('name'),
        'email' => $request->input('email')
      ];

      Mail::to($request->input('email'))
            ->send(new ConferenceApply($data));

      return back();

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
