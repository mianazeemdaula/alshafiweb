<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\City;
use App\Mail\OrderStatus;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = \App\Models\User::all();
        $products = \App\Models\Product::with('category', 'country')->get();
        $cities = \App\Models\City::with('state')->get();
        $countries = \App\Models\Country::all();
        $paymentMethods = \App\Models\PaymentMethod::where('status', true)->get();
        
        return view('admin.orders.create', compact('users', 'products', 'cities', 'countries', 'paymentMethods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'city_id' => 'required|exists:cities,id',
            'country_id' => 'required|exists:countries,id',
            'street_address' => 'required|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'extra_note' => 'nullable|string|max:500',
            'shipping_cost' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        try {
            // Generate order number
            $orderNumber = 'ORD-' . time();

            // Calculate totals
            $subtotal = 0;
            foreach ($validated['products'] as $product) {
                $subtotal += $product['price'] * $product['quantity'];
            }

            $shippingCost = $validated['shipping_cost'] ?? 0;
            $discount = $validated['discount'] ?? 0;
            $total = $subtotal + $shippingCost - $discount;

            // Create order
            $order = Order::create([
                'number' => $orderNumber,
                'user_id' => $validated['user_id'],
                'payment_method_id' => $validated['payment_method_id'],
                'city_id' => $validated['city_id'],
                'country_id' => $validated['country_id'],
                'street_address' => $validated['street_address'],
                'zip_code' => $validated['zip_code'],
                'extra_note' => $validated['extra_note'],
                'shipping_cost' => (int)($shippingCost),
                'discount' => (int)($discount),
                'total' => (int)($total),
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            // Create order details
            foreach ($validated['products'] as $productData) {
                \App\Models\OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $productData['id'],
                    'qty' => $productData['quantity'],
                    'price' => $productData['price'],
                ]);

                // Update product stock
                $product = \App\Models\Product::find($productData['id']);
                $product->decrement('stock', $productData['quantity']);
            }

            return redirect()->route('admin.orders.show', $order->id)
                ->with('success', 'Order created successfully!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create order: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::find($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::find($id);
        $cities = City::all();
        return view('admin.orders.edit', compact('order', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required',
            'payment_status' => 'required',
            'city_id' => 'required',
            'street_address' => 'required',
            'zip_code' => 'required',
        ]);
        $order = Order::find($id);
        $order->status = $request->status;
        $order->payment_status = $request->payment_status;
        $order->city_id = $request->city_id;
        $order->street_address = $request->street_address;
        $order->zip_code = $request->zip_code;
        if($order->status !== $request->status) {
            // \Mail::to($order->user->email, $order->user->name)->send(new OrderStatus($order));
        }
        $order->save();
        return redirect()->route('admin.orders.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::find($id);
        if ($order) {
            // Delete associated order details
            $order->orderDetails()->delete();
            // Delete shippment if exists
            if ($order->shipment) {
                $order->shipment->delete();
            }
            // Finally, delete the order
            $order->delete();
            return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully');
        }
        return redirect()->route('admin.orders.index')->with('error', 'Order not found');
    }
}
