<?php

namespace App\Http\Controllers\Teacher;

use App\Utility;
use Carbon\Carbon;
use App\SharedSession;
use AppsSession\AppsSession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class NetworkController extends Controller
{
    public function index()
    {
        $utility = new Utility;
        $shared = SharedSession::orderBy('created_at', 'desc')->with('app', 'app.category', 'comments')->get();
        $items = collect();
        $items_color = collect();

        foreach ($shared as $key => $share) {

            // Creo l'oggetto
            $item = $utility->formatNetworkContent($share);
            $item = $utility->assignColor($item, $key, $items_color);
            $item->comments = $share->comments()->count();
            $items->push($item);

        }

        return view('teacher.network.index', compact('items'));
    }

    public function single(string $token)
    {
        $utility = new Utility;
        $shared = SharedSession::where('token', '=', $token)->with('comments')->first();
        $item = $utility->formatNetworkContent($shared);

        $comments = $shared->comments()->get();
        foreach ($comments as $key => $comment) {
          $dt = new Carbon($comment->created_at);
          $comment->time = $dt->diffForHumans();
          $comment->author = $comment->userable()->first();
          $replies = collect();
          // $replies = [];
          foreach ($comment->comments()->get() as $key => $reply) {
              $dtR = new Carbon($reply->created_at);
              $reply->time = $dtR->diffForHumans();
              $reply->author = $reply->userable()->first();
              // array_push($replies, $reply);
              $replies->push($reply);
          }
          $comment->replies = $replies;
        }

        return view('teacher.network.single', compact('item', 'shared', 'comments'));
    }

}
