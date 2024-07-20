<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){
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
