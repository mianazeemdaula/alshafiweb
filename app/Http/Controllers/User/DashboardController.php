<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProductReview;
use App\Models\ReferrProduct;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $stats = [
            'total_orders' => $user->orders()->count(),
            'pending_orders' => $user->orders()->where('status', 'open')->count(),
            'completed_orders' => $user->orders()->where('status', 'completed')->count(),
            'total_spent' => $user->orders()->where('status', 'completed')->sum('total') / 100, // Convert from cents
            'total_reviews' => $user->productReviews()->count(),
            'referral_products' => $user->referrProducts()->count(),
        ];

        $recent_orders = $user->orders()
            ->with(['orderDetails.product'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recent_reviews = $user->productReviews()
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('user.dashboard', compact('stats', 'recent_orders', 'recent_reviews'));
    }
}
