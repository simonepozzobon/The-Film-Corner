<?php

namespace App\Http\Controllers\Api;

use App\Like;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
    public function addLike(Request $request)
    {
        $user = json_decode($request->user);

        $check = Like::where([
          ['userable_id', '=', $user->id],
          ['userable_type', '=', $request->user_type],
          ['likeable_id', '=', $request->likeable_id],
          ['likeable_type', '=', $request->likeable_type]
        ])->first();

        if (!empty($check)) {
          return response()->json(false, 200);
        } else {
          $like = new Like();
          $like->userable_id = $user->id;
          $like->userable_type = $request->user_type;
          $like->likeable_id = $request->likeable_id;
          $like->likeable_type = $request->likeable_type;
          $like->save();
        }

        return response()->json($like, 200);

    }

    public function destroy(Request $request)
    {
        $user = json_decode($request->user);

        $like = Like::where([
          ['userable_id', '=', $user->id],
          ['userable_type', '=', $request->user_type],
          ['likeable_id', '=', $request->likeable_id],
          ['likeable_type', '=', $request->likeable_type]
        ])->first();
        $like->delete();

        return response()->json([
          'success' => true
        ], 200);
    }
}
