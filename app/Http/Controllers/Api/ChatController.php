<?php

namespace App\Http\Controllers\Api;

use App\Student;
use App\Teacher;
use App\SharedSession;
use App\Conversation;
use App\Notifications\ChatNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AppsSessions\StudentAppSession;
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
                'message' => $request->message,
                'session' => $request->token,
            ]
        ];

        Redis::publish('chat', json_encode($data));

        $student = $this->checkStudent($request);
        $teacher = $this->checkTeacher($request);

        $conversation = Conversation::where([
            ['teacher_id', '=', $teacher],
            ['student_id', '=', $student],
            ['token', '=', $request->token],
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
        }
        else
        {
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
            $conversation->token = $request->token;
            $conversation->content = $messages;
            $conversation->save();
            // return response()->json([
            //   $conversation
            // ], 200);
        }

        // get the sender object
        $senderController = 'App\\'.ucfirst($request->to_type);
        $senderClass = new $senderController;
        $sender = $senderClass->find($request->to_id);

        // get the receiver object
        $receiverController = 'App\\'.ucfirst($request->to_type);
        $receiverClass = new $receiverController;
        $receiver = $receiverClass->find($request->to_id);

        // get the session object
        $session = StudentAppSession::where('token', $request->token)->with('app', 'student')->first();

        if ($sender && $receiver && $session) {
            $app = $session->app;
            $receiver->notify( new ChatNotification($session, $sender, $receiver) );

            $notification = [
              'event' => 'chatMessage',
              'from_id' => $sender->id,
              'from_type' => get_class($sender),
              'to_id' => $receiver->id,
              'to_type' => get_class($receiver),
              'data' => [
                  'sender' => $sender,
                  'session' => $session,
                  'app' => $app
              ]
            ];

            Redis::publish('notification', json_encode($notification));

            return response()->json($data, 200);
        }

        return response()->json($data, 200);
    }

    public function typing(Request $request)
    {
        $data = [
            'event' => 'typing',
            'from_id' => $request->from_id,
            'from_type' => $request->from_type,
            'to_id' => $request->to_id,
            'to_type' => $request->to_type,
            'data' => []
        ];
        Redis::publish('chat', json_encode($data));
        return response()->json($data, 200);
    }

    public function history(Request $request)
    {
        $student = $this->checkStudent($request);
        $teacher = $this->checkTeacher($request);

        $conversation = Conversation::where([
            ['teacher_id', '=', $teacher],
            ['student_id', '=', $student],
            ['token', '=', $request->token],
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

    public function checkStudent($request)
    {
        if ($request->from_type == 'student') {
            $student = $request->from_id;
        } elseif ($request->to_type == 'student') {
            $student = $request->to_id;
        }

        return $student;
    }

    public function checkTeacher($request)
    {
        if ($request->from_type == 'teacher') {
            $teacher = $request->from_id;
        } elseif ($request->to_type == 'teacher') {
            $teacher = $request->to_id;
        }

        return $teacher;
    }

    public function removeNotifications(Request $request)
    {
        // get the sender object
        $userController = 'App\\'.ucfirst($request->user_class);
        $userClass = new $userController;
        $user = $userClass->find($request->user_id);

        $notifications = $user->notifications()->where('type', '=', 'App\\Notifications\\ChatNotification')->get();

        foreach ($notifications as $key => $notification) {
            $decode = $notification->data;
            if ($decode['session']['token'] == $request->token) {
                $notification->delete();
            }
        }

        return 'success';
    }
}
