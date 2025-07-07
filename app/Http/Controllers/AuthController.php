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
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }
            return redirect()->back()->withErrors(['password' => 'Invalid Credentials']);
        }
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Login successful'
            ]);
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

    public function register(){
        if(auth()->check()){
            return redirect('/dashboard');
        }
        return view('auth.register');
    }

    public function doregister(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|string|max:18|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => \Hash::make($request->password),
        ]);

        // Assign the 'user' role to the newly registered user
        $user->assignRole('user');

        auth()->login($user);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Account created successfully'
            ]);
        }

        return redirect()->intended('/dashboard');
    }
}
