<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function sendComment(Request $request)
    {
        $user = json_decode($request->user);

        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->userable_id = $user->id;
        $comment->userable_type = $request->user_type;
        $comment->commentable_id = $request->commentable_id;
        $comment->commentable_type = $request->commentable_type;
        $comment->save();

        $dt = new Carbon($comment->created_at);
        $comment->time = $dt->diffForHumans();
        $comment->author = $comment->userable()->first();

        return response()->json($comment, 200);
    }

    public function destroy(Request $request)
    {
        $comment = Comment::find($request->id);

        if ($comment->userable_id == $request->user_id && $comment->userable_type == $request->user_type) {
          $cache = $comment;
          // Elimino anche le risposte
          foreach ($comment->comments()->get() as $key => $reply) {
            $reply->delete();
          }
          $comment->delete();
          return response()->json([
            'success' => true,
            'comment' => $cache
          ], 200);
        } else {
          return response()->json([
            'success' => false,
            'error' => 'Auth required'
          ], 200);
        }


    }
}
