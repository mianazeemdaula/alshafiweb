<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(){
        return view('auth.signin');
    }

    public function logout(){
        auth()->logout();
        return redirect('/');
    }

    public function dologin(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (!auth()->attempt($request->only('email', 'password'))) {
            return redirect()->back()->withErrors(['password' => 'Invalid Credentials']);
        }
        return redirect()->intended('/');
    }
}
