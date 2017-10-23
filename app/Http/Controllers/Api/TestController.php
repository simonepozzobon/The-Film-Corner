<?php

namespace App\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function test(Request $request)
    {



      $data = [
        'event' => 'newMessage',
        'from_id' => $request->from_id,
        'from_type' => $request->from_type,
        'to_id' => $request->to_id,
        'to_type' => $request->to_type,
        'data' => [
          'message' => $request->message
        ]
      ];

      Redis::publish('chat', json_encode($data));

      return response()->json($data, 200);
    }
}
