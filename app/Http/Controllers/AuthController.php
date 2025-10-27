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
        if(!auth()->check()){
            return redirect('/login');
        }
        $user = auth()->user();
        
        // Redirect regular users to user dashboard
        if($user->hasRole('user')) {
            return redirect('/user/dashboard');
        }
        
        // Team Leader Dashboard
        if($user->hasRole('team_leader')) {
            // Get team members
            $teamMembers = $user->teamMembers()->with(['manualOrders', 'bonuses'])->get();
            
            // Get all orders visible to team leader (website orders + team manual orders)
            $visibleOrders = \App\Models\Order::visibleTo($user);
            
            $stats = [
                'team_members' => $teamMembers->count(),
                'total_orders' => $visibleOrders->count(),
                'website_orders' => (clone $visibleOrders)->where('order_source', 'website')->count(),
                'manual_orders' => (clone $visibleOrders)->where('order_source', 'manual')->count(),
                'pending_orders' => (clone $visibleOrders)->where('status', 'pending')->count(),
                'processing_orders' => (clone $visibleOrders)->where('status', 'processing')->count(),
                'shipped_orders' => (clone $visibleOrders)->where('status', 'shipped')->count(),
                'delivered_orders' => (clone $visibleOrders)->where('status', 'delivered')->count(),
                'cancelled_orders' => (clone $visibleOrders)->where('status', 'cancelled')->count(),
            ];
            
            // Team performance
            $teamStats = [
                'total_team_orders' => $teamMembers->sum(function($member) {
                    return $member->manualOrders->count();
                }),
                'total_team_bonuses' => $teamMembers->sum(function($member) {
                    return $member->bonuses->sum('bonus_amount');
                }),
            ];
            
            return view('admin.team-leader-dashboard', compact('stats', 'teamStats', 'teamMembers'));
        }
        
        // Order Taker Dashboard - Only Order Statistics (No Financial Data)
        if($user->hasRole('order_taker')) {
            // Get only manual orders for this order taker
            $manualOrders = \App\Models\Order::where('order_taker_id', $user->id)
                ->where('order_source', 'manual');
            
            $stats = [
                'total_orders' => $manualOrders->count(),
                'pending_orders' => (clone $manualOrders)->where('status', 'pending')->count(),
                'processing_orders' => (clone $manualOrders)->where('status', 'processing')->count(),
                'shipped_orders' => (clone $manualOrders)->where('status', 'shipped')->count(),
                'delivered_orders' => (clone $manualOrders)->where('status', 'delivered')->count(),
                'cancelled_orders' => (clone $manualOrders)->where('status', 'cancelled')->count(),
            ];
            
            // Get bonus information
            $bonuses = $user->bonuses;
            $bonusStats = [
                'total_bonuses' => $bonuses->sum('bonus_amount'),
                'pending_bonuses' => $bonuses->where('status', 'pending')->sum('bonus_amount'),
                'paid_bonuses' => $bonuses->where('status', 'paid')->sum('bonus_amount'),
                'bonus_count' => $bonuses->count(),
            ];
            
            return view('admin.order-taker-dashboard', compact('stats', 'bonusStats'));
        }
        
        // Admin Dashboard - Full Statistics Including Financial Data
        $stats = [
            'users' => \App\Models\User::count(),
            'products' => \App\Models\Product::count(),
            'categories' => \App\Models\Category::count(),
            'orders' => \App\Models\Order::count(),
            'revenue' => \App\Models\Order::sum('total'),
        ];
        return view('admin.dashboard', compact('stats'));
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
