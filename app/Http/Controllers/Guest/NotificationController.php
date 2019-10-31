<?php

namespace App\Http\Controllers\Guest;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = Auth::guard('guest')->user()->notifications()->where('id', $id)->first()->markAsRead();
        return response('success');
    }

    public function markAsUnread(Request $r)
    {
        $notification = Auth::guard('guest')->user()->notifications()->where('id', $r->id)->first();
        $notification->read_at = null;
        $notification->save();
        return response('success');
    }

    // deprecated (vd. funzione destroy)
    public function delete(Request $request)
    {
        $notification = Auth::guard('guest')->user()->notifications()->where('id', $request['id'])->first()->delete();
        return response('success');
    }

    // Nuovo sistema per eliminare le notifiche
    public function destroy(Request $r)
    {
        $notification = Auth::guard('guest')->user()->notifications()->where('id', $r->id)->first();
        $notification->delete();
        return response('success', 200);
    }

    public function getNotifications()
    {
        $notifications = Auth::guard('guest')->user()->unreadNotifications()->get();
        return response()->json($notifications);
    }
}
