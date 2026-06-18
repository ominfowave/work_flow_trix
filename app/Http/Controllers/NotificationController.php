<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index(){

        $user = auth()->guard('admin')->user();
        $notification = Notification::where('receiver_id', $user->id)->orderBy('id', 'desc')->get();

        $this->data['notifications'] = $notification; 

        return view("notification.index", $this->data);
    }
}
