<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(){
        if(auth()->check()){
            return redirect('/dashboard');
        }
        return view('auth.login');
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
        return redirect()->intended('/dashboard');
    }

    public function dashboard(){
        $stats = [
            'users' => \App\Models\User::count(),
            'products' => \App\Models\Product::count(),
            'categories' => \App\Models\Category::count(),
            'orders' => \App\Models\Order::count(),
            'revenue' => \App\Models\Order::sum('total'),
        ];
        return view('auth.dashboard', compact('stats'));
    }
}
