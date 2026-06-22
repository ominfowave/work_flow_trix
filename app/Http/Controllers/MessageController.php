<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Message, Admin, MessageFile};
use DB;
use App\Events\MessageSent;

class MessageController extends Controller
{
    public function index(Request $request){

        $receiver_id = '';
        $sender_id = auth()->guard('admin')->id();

        if($request->ajax()){
            $receiver_id = $request->receiver_active_id;
            $offset = $request->offset ?? 0;

            $totalCount = Message::where(function ($q) use ($receiver_id, $sender_id) {
                    $q->where('sender_id', $sender_id)
                        ->where('receiver_id', $receiver_id);
                    })->orWhere(function ($q) use ($receiver_id, $sender_id) {
                        $q->where('sender_id', $receiver_id)
                        ->where('receiver_id', $sender_id);
                    })->count();

                $showMore = ($offset + 10) < $totalCount;

              $messages = Message::with('messageFile')
                        ->where(function ($q) use ($receiver_id, $sender_id) {
                            $q->where('sender_id', $sender_id)
                                ->where('receiver_id', $receiver_id);
                        })->orWhere(function ($q) use ($receiver_id, $sender_id) {
                            $q->where('sender_id', $receiver_id)
                                ->where('receiver_id', $sender_id);
                        })->orderBy('id', 'desc')->skip($offset)->take(10)->get()->reverse()->values();

            Message::where('receiver_id', $sender_id)->update(['is_read' => '1']);

            return response()->json([
                    'html' => view('message.chat_list', compact(
                    'messages', 'receiver_id', 'sender_id'
                ))->render(),
                'count' => $messages->count(),
                'totalCount' => $totalCount,
                'showMore' => $showMore
            ]);
        }

        $currentUserId = auth()->guard('admin')->id();

        $userList = Admin::selectRaw(
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
                AND messages.sender_id = ?) ORDER BY messages.id DESC LIMIT 1
            ) as last_message,
             
            (
                SELECT created_at
                FROM messages
                WHERE (messages.sender_id = users.id
                AND messages.receiver_id = ?) OR (messages.receiver_id = users.id
                AND messages.sender_id = ?) ORDER BY messages.id DESC LIMIT 1
            ) as last_message_date
             ',

            [$currentUserId, $currentUserId, $currentUserId, $currentUserId, $currentUserId]
        )
        ->where('users.id', '!=', $currentUserId)
        ->where('users.status', 'active')
        ->get();

        $this->data['userList'] = $userList;
        $this->data['sender_id'] = $sender_id;

        return view('message.index', $this->data);
    }

    public function sendMessage(Request $request){
        $receiver_id = $request->receiver_id;
        $messageData = [
            'sender_id' => auth()->guard('admin')->id(),
            'receiver_id' => $receiver_id,
            'message' => $request->message,
            'is_read' => '0'
        ];
    
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
    
        // return response()->json([
        //     'success' => true,
        //     'message' => $message,
        //     'fileName' => $fileName ?? ''
        // ]);

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
