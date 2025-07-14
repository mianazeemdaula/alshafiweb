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

        // Redirect based on user role
        $user = auth()->user();
        if ($user && $user->hasRole('user')) {
            return redirect()->intended('/user/dashboard');
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

        $referrerId = null;
        if ($request->filled('ref_code')) {
            $refUser = \App\Models\User::where('ref_code', $request->ref_code)->first();
            if ($refUser) {
                $referrerId = $refUser->id;
            }
        }

        // Generate a unique random ref_code if not provided
        $ref_code = $request->input('ref_code');
        if (empty($ref_code)) {
            do {
                $ref_code = strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
            } while (\App\Models\User::where('ref_code', $ref_code)->exists());
        }

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => \Hash::make($request->password),
            'referrer' => $referrerId,
            'ref_code' => $ref_code,
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

    public function referrals()
    {
        $user = auth()->user();
        $referrals = \App\Models\User::where('referrer', $user->id)
            ->with(['orders' => function($q) { $q->select('user_id', 'total'); }])
            ->get()
            ->map(function($ref) use ($user) {
                $totalShopping = $ref->orders->sum('total');
                // Example: 5% earning on referral's shopping
                $earning = round($totalShopping * 0.05, 2);
                return (object) [
                    'name' => $ref->name,
                    'email' => $ref->email,
                    'total_shopping' => $totalShopping,
                    'earning' => $earning,
                ];
            });
        return view('user.referrals', compact('referrals'));
    }
}
