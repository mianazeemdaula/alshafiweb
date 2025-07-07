<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->orders()->with(['orderDetails.product', 'paymentMethod']);

        // Filter by status if provided
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search by order number
        if ($request->has('search') && $request->search != '') {
            $query->where('number', 'like', '%' . $request->search . '%');
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Auth::user()->orders()
            ->with(['orderDetails.product', 'paymentMethod', 'city', 'user'])
            ->findOrFail($id);

        return view('user.orders.show', compact('order'));
    }

    public function cancel($id)
    {
        $order = Auth::user()->orders()->findOrFail($id);

        if ($order->status == 'open') {
            $order->update(['status' => 'cancelled']);
            return redirect()->route('user.orders.show', $order->id)
                ->with('success', 'Order cancelled successfully!');
        }

        return redirect()->route('user.orders.show', $order->id)
            ->with('error', 'This order cannot be cancelled.');
    }

    public function track($id)
    {
        $order = Auth::user()->orders()
            ->with(['orderDetails.product'])
            ->findOrFail($id);

        return view('user.orders.track', compact('order'));
    }
}
