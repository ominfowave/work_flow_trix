<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Admin, Notification};

class UserController extends Controller
{
    public function create()
    {
        return view('user_register');
    }

    public function store(Request $request)
    {
       try{
            $request->validate([
                'name' => 'required|string|max:100',
                'contact_number' => 'required|integer|min:10',
                'email' => 'required|email',
                'password' => 'required|min:6'
            ]);

            $input = $request->all();

            $input['password'] = bcrypt($input['password']);
            // $input['status'] = 'active';
            $input['full_name'] = $input['name'];

            $admin = Admin::create($input);

            auth()->guard('admin')->login($admin);

            $superAdmin = Admin::select('id', 'name')->where('name', 'vishal')->first();

            $notification = [
                'user_id' => $admin->id,
                'sender_id' => $admin->id,
                'receiver_id' => $superAdmin->id,
                'title' => $request->name ?? '',
                'message' => $request->email .'<br>'. $request->contact_number,
                'notification_label' => 'New User ' .'<b>'. $request->name . '</b>'. ' has been created',
                'table_id' => $admin->id,
                'table_name' => 'users',
                'is_read' => '1'
            ];

            Notification::create($notification);

            return redirect()->route('admin_dashboard');
        } catch (\Illuminate\Validation\ValidationException $th) {

            return back()->withErrors($th->validator)->withInput();            
        }
    }
}
