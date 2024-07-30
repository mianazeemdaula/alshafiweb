<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $orders = $user->orders()->with(['details','user','paymentMethod','city'])
        ->orderBy('id','desc')->get();
        return response()->json($orders);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.qty' => 'required|integer|min:1',
            'address' => 'required|string',
            'zip' => 'required|string',
            'city' => 'required|exists:cities,id',
            // 'payment_method' => 'required|exists:payment_methods,id',
        ]);

        $user = auth()->user();
        $order = new Order();
        $order->user_id = $user->id;
        $order->status = 'pending';
        $order->payment_method_id = 1;
        $order->number  = 'ORD-'.time();
        $order->street_address = $request->address;
        $order->zip_code = $request->zip;
        $order->city_id = $request->city;
        $order->save();
        $totalPrice = 0;
        foreach ($request->products as $product) {
            $detail = new OrderDetail();
            $detail->order_id = $order->id;
            $detail->product_id = $product['id'];
            $detail->qty = $product['qty'];
            $detail->price = Product::find($product['id'])->price;
            $detail->save();
            $totalPrice += $detail->price * $detail->qty;
        }
        $order->shipping_cost = 200;
        $order->total = $totalPrice + 200;
        $order->save();
        return response()->json($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['details','user','paymentMethod','city'])->find($id);
        return response()->json($order);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
