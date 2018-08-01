<?php

namespace App\Http\Controllers\Student;

use Auth;
use App\Like;
use App\Utility;
use App\Comment;
use Carbon\Carbon;
use App\SharedSession;
use AppsSession\AppsSession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;

class NetworkController extends Controller
{
    public function index()
    {
        $user = Auth::guard('student')->user();

        $utility = new Utility;
        $shared = SharedSession::orderBy('created_at', 'desc')->with('app', 'app.category', 'comments')->get();
        $items = collect();
        $items_color = collect();

        foreach ($shared as $key => $share) {

            // Creo l'oggetto
            $item = $utility->formatNetworkContent($share);
            $item = $utility->assignColor($item, $key, $items_color);

            // Views
            $item->views = Activity::where('description', '=', 'network_views')->forSubject($share)->count();

            // Likes
            $likes = $share->likes()->get();
            $check = $likes->contains(function ($like, $key) use ($user) {
                return $like->userable_type == get_class($user) && $like->userable_id == $user->id;
            });
            $item->likes = $likes->count();
            $item->liked = $check;

            // Comments
            $comments = $share->comments()->get();
            $replies = 0;
            foreach ($comments as $key => $comment) {
                $comment_replies = $comment->comments()->count();
                $replies = $replies + $comment_replies;
            }
            $item->comments = $comments->count() + $replies;

            $items->push($item);
        }

        return view('student.network.index', compact('items'));
    }

    public function single(string $token)
    {
        $utility = new Utility;
        $shared = SharedSession::where('token', '=', $token)->with('comments')->first();
        $item = $utility->formatNetworkContent($shared);

        $views = Activity::where('description', '=', 'visit')->forSubject($shared)->count();

        activity()->causedBy(Auth::guard('student')->user())->performedOn($shared)->withProperties('visited', true)->log('network_views');

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

        $comments = json_encode($comments, JSON_UNESCAPED_UNICODE);

        return view('student.network.single', compact('item', 'shared', 'comments'));
    }
}
