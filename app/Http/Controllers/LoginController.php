<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view("login");
    }

    public function submitLogin(Request $request){

        $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        $credentials = [
            'name' => $request->name,
            'password' => $request->password,
        ];

        if(auth()->guard('admin')->attempt($credentials)){
            $request->session()->regenerate();


            return redirect()->route('admin_dashboard')->with('success', 'Login Successfully');        
        }


        return back()->with('error', 'Invalid Username or Password');
    }

    public function logout(Request $request){
        auth()->guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['success' => 'Logout Successfully']);
    }
}
