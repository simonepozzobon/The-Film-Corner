<?php

namespace App\Http\Controllers\Main;

use Validator;
use Illuminate\Http\Request;
use App\Mail\ConferenceApply;
use App\ConferenceApplication;
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
      $validator = Validator::make($request->all(), [
        'name' => 'required|min:3',
        'surname' => 'required|min:3',
        'email' => 'required|email',
      ]);

      if ($validator->fails()) {

        return response()->json([
          'errors' => $validator->getMessageBag()->toArray()
        ]);

      } else {

        $data = [
          'name'      => $request->input('name'),
          'email'     => $request->input('email'),
          'success'   => '<b>Thanks '.$request->input('name').',</b> We send you an email at <b>'.$request->input('email').'</b> with the confirmation of your application.'
        ];

        $register = new ConferenceApplication;
        $register->name = $request->input('name');
        $register->surname = $request->input('surname');
        $register->email = $request->input('email');
        $register->institution = $request->input('institution');
        $register->role = $request->input('role');
        $register->notes = $request->input('notes');
        $register->save();

        Mail::to($request->input('email'))->send(new ConferenceApply($data));
        return response()->json([
          'success' => $data['success']
        ]);

      }


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
