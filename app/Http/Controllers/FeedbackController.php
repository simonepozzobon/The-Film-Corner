<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feedback;

class FeedbackController extends Controller
{
    public function save(Request $request)
    {
      $data = $request->all();

      $feedback = new Feedback;
      $feedback->status = $data['status'];
      $feedback->comments = $data['comments'];
      $feedback->save();

      session()->flash('success', 'Thanks for your help!');

      return back();

    }
}
