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

        // Preserve referral session across authentication (session regeneration)
        $referralData = [
            'referral_code' => session('referral_code'),
            'referral_user_id' => session('referral_user_id'),
            'referral_product_id' => session('referral_product_id'),
        ];
        
        if (!auth()->attempt($request->only('email', 'password'))) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }
            return redirect()->back()->withErrors(['password' => 'Invalid Credentials']);
        }

        // Restore referral session after login
        foreach ($referralData as $key => $value) {
            if ($value !== null) {
                session([$key => $value]);
            }
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
        if($user->hasRole('label_printer')) {
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
        
        // Web Order Taker Dashboard - Only Website Orders
        if($user->hasRole('web_order_taker')) {
            // Get only website orders
            $websiteOrders = \App\Models\Order::where('order_source', 'website');
            
            $stats = [
                'total_orders' => $websiteOrders->count(),
                'pending_orders' => (clone $websiteOrders)->where('status', 'pending')->count(),
                'processing_orders' => (clone $websiteOrders)->where('status', 'processing')->count(),
                'shipped_orders' => (clone $websiteOrders)->where('status', 'shipped')->count(),
                'delivered_orders' => (clone $websiteOrders)->where('status', 'delivered')->count(),
                'cancelled_orders' => (clone $websiteOrders)->where('status', 'cancelled')->count(),
                'today_orders' => (clone $websiteOrders)->whereDate('created_at', today())->count(),
                'week_orders' => (clone $websiteOrders)->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                'month_orders' => (clone $websiteOrders)->whereMonth('created_at', now()->month)->count(),
            ];
            
            return view('admin.web-order-taker-dashboard', compact('stats'));
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

        // Label Printer Dashboard
        if($user->hasRole('label_printer')) {
            // Get team members
            $teamMembers = $user->teamMembers()->with(['manualOrders', 'bonuses'])->get();
            
            // Get visible orders (website + team manual orders)
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
        
        // Admin Dashboard - Full Statistics Including Financial Data
        $orders = \App\Models\Order::query();
        $todayOrders = \App\Models\Order::whereDate('created_at', today());
        $monthOrders = \App\Models\Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
        
        // Basic Stats
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_products' => \App\Models\Product::count(),
            'active_products' => \App\Models\Product::where('is_active', true)->count(),
            'total_categories' => \App\Models\Category::count(),
            'total_orders' => $orders->count(),
            'today_orders' => $todayOrders->count(),
            'month_orders' => $monthOrders->count(),
        ];
        
        // Revenue Stats
        $revenueStats = [
            'total_revenue' => $orders->sum('total'),
            'today_revenue' => $todayOrders->sum('total'),
            'month_revenue' => $monthOrders->sum('total'),
            'average_order_value' => $orders->count() > 0 ? $orders->avg('total') : 0,
        ];
        
        // Order Status Breakdown
        $orderStatus = [
            'pending' => \App\Models\Order::where('status', 'pending')->count(),
            'processing' => \App\Models\Order::where('status', 'processing')->count(),
            'shipped' => \App\Models\Order::where('status', 'shipped')->count(),
            'delivered' => \App\Models\Order::where('status', 'delivered')->count(),
            'cancelled' => \App\Models\Order::where('status', 'cancelled')->count(),
        ];
        
        // Order Source Breakdown
        $orderSource = [
            'website' => \App\Models\Order::where('order_source', 'website')->count(),
            'manual' => \App\Models\Order::where('order_source', 'manual')->count(),
        ];
        
        // Top Products
        $topProducts = \App\Models\Product::withCount(['orderDetails as total_sold' => function($query) {
            $query->selectRaw('sum(qty)');
        }])
        ->withSum('orderDetails as total_revenue', 'price')
        ->orderBy('total_sold', 'desc')
        ->take(5)
        ->get();
        
        // Recent Orders
        $recentOrders = \App\Models\Order::with(['user', 'orderTaker'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // Sales Chart Data (Last 30 Days)
        $salesChartData = [];
        $ordersChartData = [];
        $chartLabels = [];
        
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('M d');
            
            $dayOrders = \App\Models\Order::whereDate('created_at', $date)->get();
            $salesChartData[] = $dayOrders->sum('total');
            $ordersChartData[] = $dayOrders->count();
        }
        
        // Team Performance
        $teamStats = [
            'order_takers' => \App\Models\User::role('order_taker')->count(),
            'label_printers' => \App\Models\User::role('label_printer')->count(),
            'total_bonuses_paid' => \App\Models\Bonus::where('status', 'paid')->sum('bonus_amount'),
            'pending_bonuses' => \App\Models\Bonus::where('status', 'pending')->sum('bonus_amount'),
        ];
        
        // Product Offers Stats
        $offerStats = [
            'total_offers' => \App\Models\ProductOffer::count(),
            'active_offers' => \App\Models\ProductOffer::where('is_active', true)->count(),
            'products_with_offers' => \App\Models\Product::has('activeOffers')->count(),
        ];
        
        // Shipment Stats
        $shipmentStats = [
            'total_shipments' => \App\Models\Shipment::count(),
            'pending_shipments' => \App\Models\Shipment::where('status', 'pending')->count(),
            'in_transit' => \App\Models\Shipment::where('status', 'in_transit')->count(),
            'delivered_shipments' => \App\Models\Shipment::where('status', 'delivered')->count(),
        ];
        
        // User Growth (Last 12 Months)
        $userGrowthData = [];
        $userGrowthLabels = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $userGrowthLabels[] = $month->format('M Y');
            $userGrowthData[] = \App\Models\User::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }
        
        return view('admin.dashboard', compact(
            'stats',
            'revenueStats',
            'orderStatus',
            'orderSource',
            'topProducts',
            'recentOrders',
            'salesChartData',
            'ordersChartData',
            'chartLabels',
            'teamStats',
            'offerStats',
            'shipmentStats',
            'userGrowthData',
            'userGrowthLabels'
        ));
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

        // Preserve referral session across authentication (session regeneration)
        $referralData = [
            'referral_code' => session('referral_code'),
            'referral_user_id' => session('referral_user_id'),
            'referral_product_id' => session('referral_product_id'),
        ];

        $referrerId = null;
        if ($request->filled('ref_code')) {
            $refUser = \App\Models\User::where('ref_code', $request->ref_code)->first();
            if ($refUser) {
                $referrerId = $refUser->id;
            }
        }

        // Generate a unique random ref_code (never reuse the referral code as the new user's own code)
        do {
            $newRefCode = strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
        } while (\App\Models\User::where('ref_code', $newRefCode)->exists());

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => \Hash::make($request->password),
            'referrer' => $referrerId,
            'ref_code' => $newRefCode,
        ]);

        // Assign the 'user' role to the newly registered user
        $user->assignRole('user');

        auth()->login($user);

        // Restore referral session after login
        foreach ($referralData as $key => $value) {
            if ($value !== null) {
                session([$key => $value]);
            }
        }

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

        // Users who registered via this user's referral code
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

        // Orders placed via this user's shared product links
        $referredOrders = \App\Models\Order::where('referrer_id', $user->id)
            ->with(['orderDetails.product', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $referredOrdersTotal = $referredOrders->sum('total');
        $referredOrdersCount = $referredOrders->count();

        return view('user.referrals', compact('referrals', 'referredOrders', 'referredOrdersTotal', 'referredOrdersCount'));
    }
}
