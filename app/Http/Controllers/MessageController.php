<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Message, Admin, MessageFile};
use DB;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Cache;

class MessageController extends Controller
{
    public function index(Request $request){

        $receiver_id = '';
        $sender_id = auth()->guard('admin')->id();

        if($request->ajax()){
            $receiver_id = $request->receiver_active_id;
            $offset = $request->offset ?? 0;

               $cacheKey = "chat_messages_{$sender_id}_{$receiver_id}_{$offset}";

                $chatData = Cache::remember($cacheKey, 60, function () use ($receiver_id, $sender_id, $offset) {

                $totalCount = Message::where(function ($q) use ($receiver_id, $sender_id) {
                        $q->where('sender_id', $sender_id)
                            ->where('receiver_id', $receiver_id);
                    })
                    ->orWhere(function ($q) use ($receiver_id, $sender_id) {
                        $q->where('sender_id', $receiver_id)
                            ->where('receiver_id', $sender_id);
                    })
                    ->count();

                $messages = Message::with('messageFile')
                    ->where(function ($q) use ($receiver_id, $sender_id) {
                        $q->where('sender_id', $sender_id)
                            ->where('receiver_id', $receiver_id);
                    })
                    ->orWhere(function ($q) use ($receiver_id, $sender_id) {
                        $q->where('sender_id', $receiver_id)
                            ->where('receiver_id', $sender_id);
                    })
                    ->orderBy('id', 'desc')
                    ->skip($offset)
                    ->take(10)
                    ->get()
                    ->reverse()
                    ->values();

                return [
                    'messages' => $messages,
                    'totalCount' => $totalCount,
                ];
            });

            $showMore = ($offset + 10) < $chatData['totalCount'];

            Message::where('receiver_id', $sender_id)
                ->update(['is_read' => '1']);

            return response()->json([
                'html' => view('message.chat_list', [
                    'messages' => $chatData['messages'],
                    'receiver_id' => $receiver_id,
                    'sender_id' => $sender_id,
                ])->render(),
                'count' => $chatData['messages']->count(),
                'totalCount' => $chatData['totalCount'],
                'showMore' => $showMore,
            ]);
        }

        $currentUserId = $sender_id;

        $userList = Cache::remember(
            "chat_users_{$currentUserId}",
            60, // seconds
            function () use ($currentUserId) {

                return Admin::selectRaw(
                    'users.*,
                    (
                        SELECT COUNT(*)
                        FROM messages
                        WHERE messages.sender_id = users.id
                        AND messages.receiver_id = ?
                        AND messages.is_read = "0"
                    ) as read_count,

                    (
                        SELECT message
                        FROM messages
                        WHERE (messages.sender_id = users.id
                        AND messages.receiver_id = ?) OR (messages.receiver_id = users.id
                        AND messages.sender_id = ?)
                        ORDER BY messages.id DESC
                        LIMIT 1
                    ) as last_message,

                    (
                        SELECT created_at
                        FROM messages
                        WHERE (messages.sender_id = users.id
                        AND messages.receiver_id = ?) OR (messages.receiver_id = users.id
                        AND messages.sender_id = ?)
                        ORDER BY messages.id DESC
                        LIMIT 1
                    ) as last_message_date',
                    [
                        $currentUserId,
                        $currentUserId,
                        $currentUserId,
                        $currentUserId,
                        $currentUserId
                    ]
                )
                ->where('users.id', '!=', $currentUserId)
                ->where('users.status', 'active')
                ->get();
            }
        );

        $this->data['userList'] = $userList;
        $this->data['sender_id'] = $sender_id;

        return view('message.index', $this->data);
    }

    public function sendMessage(Request $request){
        $receiver_id = $request->receiver_id;
        $sender_id = auth()->guard('admin')->id();

        $messageData = [
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'message' => $request->message,
            'is_read' => '0'
        ];

        foreach ([0,10,20,30,40,50] as $offset) {
            Cache::forget("chat_messages_{$sender_id}_{$receiver_id}_{$offset}");
            Cache::forget("chat_messages_{$receiver_id}_{$sender_id}_{$offset}");
        }
    
        $message = Message::create($messageData);

        if ($request->hasFile('files')) {
            $fileName = [];
            foreach ($request->file('files') as $file) {
                $name = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('chat-files'), $name);

                $fileData = [
                    'message_id' => $message->id,
                    'file_name' => $name
                ]; 

                MessageFile::create($fileData);

                $fileName[] = $name;
            }
        }

        $messages = Message::with('messageFile')->find($message->id);
    
        broadcast(new MessageSent($messages))->toOthers();
    
        return response()->json([
                'html' => view('message.new_message', compact(
                'messages', 'receiver_id'
            ))->render(),
            'success' => true,
            'message' => $message,
            'fileName' => $fileName ?? ''
        ]);
    }
}
