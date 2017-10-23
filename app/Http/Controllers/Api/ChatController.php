<?php

namespace App\Http\Controllers\Api;

use App\Student;
use App\Teacher;
use App\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class ChatController extends Controller
{
    public function message(Request $request)
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

        if ($request->from_type == 'student') {
            $student = $request->from_id;
        } elseif ($request->to_type == 'student') {
            $student = $request->to_id;
        }

        if ($request->from_type == 'teacher') {
            $teacher = $request->from_id;
        } elseif ($request->to_type == 'teacher') {
            $teacher = $request->to_id;
        }

        $conversation = Conversation::where([
            ['teacher_id', '=', $teacher],
            ['student_id', '=', $student]
        ])->first();

        if ($conversation != null)
        {
            $messages = json_decode($conversation->content);

            $content = [
                'timestamp' => date('Y-m-d H:i:s' ),
                'message' => $request->message,
                'from' => $request->from_id,
                'to' => $request->to_id
            ];

            array_push($messages, $content);

            $conversation->content = json_encode($messages);
            $conversation->save();
            // return response()->json([
            //   $conversation
            // ], 200);
        }
        else {
            $messages = collect();

            $content = [
                'timestamp' => date('Y-m-d H:i:s' ),
                'message' => $request->message,
                'from' => $request->from_id,
                'to' => $request->to_id
            ];
            $messages->push($content);

            $conversation = new Conversation();
            $conversation->teacher_id = $teacher;
            $conversation->student_id = $student;
            $conversation->token = 'prova';
            $conversation->content = $messages;
            $conversation->save();
            // return response()->json([
            //   $conversation
            // ], 200);
        }
        return response()->json($data, 200);
    }


    public function history(Request $request)
    {
        if ($request->from_type == 'student') {
            $student = $request->from_id;
        } elseif ($request->to_type == 'student') {
            $student = $request->to_id;
        }

        if ($request->from_type == 'teacher') {
            $teacher = $request->from_id;
        } elseif ($request->to_type == 'teacher') {
            $teacher = $request->to_id;
        }

        $conversation = Conversation::where([
            ['teacher_id', '=', $teacher],
            ['student_id', '=', $student],
        ])->first();

        if ($conversation != null) {
          return response($conversation->content);
        }
        else {
          return response()->json([
            'success' => false,
            'status' => 'No message history'
          ], 200);
        }

    }
}
