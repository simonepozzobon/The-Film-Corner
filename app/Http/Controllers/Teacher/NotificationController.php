<?php

namespace App\Http\Controllers\Teacher;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
      $notification = Auth::guard('teacher')->user()->notifications()->where('id', $id)->first()->markAsRead();
      return response('success');
    }

    public function delete(Request $request)
    {
      $notification = Auth::guard('teacher')->user()->notifications()->where('id', $request['id'])->first()->delete();
      return response('success');
    }
}
