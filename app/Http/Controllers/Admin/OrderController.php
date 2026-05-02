<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\City;
use App\Models\Bonus;
use App\Mail\OrderStatus;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Start with orders visible to current user based on role
        $query = Order::visibleTo($user);

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                    ->orWhere('number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhereJsonContains('shipping_address->first_name', 'like', "%{$search}%")
                    ->orWhereJsonContains('shipping_address->last_name', 'like', "%{$search}%")
                    ->orWhereJsonContains('shipping_address->phone', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($qu) use ($search) {
                        $qu->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($status = request('status')) {
            $query->where('status', $status);
        }

        if ($payment = request('payment_status')) {
            $query->where('payment_status', $payment);
        }

        if ($type = request('type')) {
            $query->where('type', $type);
        }

        if ($source = request('order_source')) {
            $query->where('order_source', $source);
        }

        if ($dateFrom = request('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo = request('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $orders = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $types = Order::getTypes();

        return view('admin.orders.index', compact('orders', 'types'));
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
        $types = Order::getTypes();
        
        // Get team members if user is a team leader
        $teamMembers = collect();
        $defaultOrderTakerId = session('default_order_taker_id');
        if (auth()->user()->hasRole('label_printer')) {
            $teamMembers = auth()->user()->teamMembers;
        }

        return view('admin.orders.create', compact('users', 'products', 'cities', 'countries', 'paymentMethods', 'types', 'teamMembers', 'defaultOrderTakerId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Base validation rules
        $rules = [
            'customer_type' => 'required|in:existing,manual',
            'payment_method_id' => 'required_if:customer_type,existing|exists:payment_methods,id',
            'payment_method_id_manual' => 'required_if:customer_type,manual|exists:payment_methods,id',
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
            'order_taker_id' => 'nullable|exists:users,id', // For team leaders to assign to team members
        ];

        // Add conditional validation based on customer type
        if ($request->customer_type === 'existing') {
            $rules['user_id'] = 'required|exists:users,id';
        } else {
            $rules['customer_name'] = 'required|string|max:255';
            $rules['customer_email'] = 'nullable|email|max:255';
            $rules['customer_phone'] = 'nullable|string|max:20';
        }

    $allowedTypes = implode(',', array_keys(Order::getTypes()));
    $rules['type'] = 'nullable|in:' . $allowedTypes;

    $validated = $request->validate($rules);

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

            // Determine payment method ID based on customer type
            $paymentMethodId = $validated['customer_type'] === 'existing' 
                ? $validated['payment_method_id'] 
                : $validated['payment_method_id_manual'];

            // Create order
            $orderData = [
                'number' => $orderNumber,
                'payment_method_id' => $paymentMethodId,
                'city_id' => $validated['city_id'],
                'country_id' => $validated['country_id'],
                'street_address' => $validated['street_address'],
                'zip_code' => $validated['zip_code'],
                'extra_note' => $validated['extra_note'],
                'shipping_cost' => $shippingCost,
                'discount' => $discount,
                'type' => $validated['type'] ?? null,
                'total' => $total,
                'status' => 'pending',
                'payment_status' => 'pending',
                'order_source' => 'manual', // Orders created in admin panel are manual
                'order_taker_id' => $validated['order_taker_id'] ?? auth()->id(), // Use assigned or current user
            ];

            // Store the selected order_taker_id in session for future use
            if (isset($validated['order_taker_id'])) {
                session(['default_order_taker_id' => $validated['order_taker_id']]);
            }

            // Add customer information based on type
            if ($validated['customer_type'] === 'existing') {
                $orderData['user_id'] = $validated['user_id'];
            } else {
                $orderData['user_id'] = null;
                $orderData['customer_name'] = $validated['customer_name'];
                $orderData['customer_email'] = $validated['customer_email'] ?? null;
                $orderData['customer_phone'] = $validated['customer_phone'] ?? null;
            }

            $order = Order::create($orderData);

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
        $types = Order::getTypes();
        
        // Get team members if user is a team leader
        $teamMembers = collect();
        if (auth()->user()->hasRole('label_printer')) {
            $teamMembers = auth()->user()->teamMembers;
        }
        
        return view('admin.orders.edit', compact('order', 'cities', 'types', 'teamMembers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $allowedTypes = implode(',', array_keys(Order::getTypes()));
        $request->validate([
            'status' => 'required',
            'payment_status' => 'required',
            'city_id' => 'required',
            'street_address' => 'required',
            'zip_code' => 'required',
            'type' => 'nullable|in:' . $allowedTypes,
            'order_taker_id' => 'nullable|exists:users,id',
        ]);
        $order = Order::find($id);
        $order->status = $request->status;
        $order->payment_status = $request->payment_status;
        $order->city_id = $request->city_id;
        $order->street_address = $request->street_address;
        $order->zip_code = $request->zip_code;
        $order->type = $request->type;
        
        // Update order_taker_id if provided
        if ($request->has('order_taker_id')) {
            $order->order_taker_id = $request->order_taker_id ?: auth()->id();
        }
        
        if($order->status !== $request->status) {
            // \Mail::to($order->user->email, $order->user->name)->send(new OrderStatus($order));
        }
        $order->save();

        // Reverse label_printer bonus if order is being cancelled
        if ($request->status === 'cancelled') {
            $bonus = Bonus::where('order_id', $order->id)->first();
            if ($bonus && $bonus->status !== 'cancelled') {
                $bonus->update([
                    'status' => 'cancelled',
                    'notes' => $bonus->notes . ' | Reversed: order cancelled on ' . now()->format('Y-m-d H:i:s'),
                ]);
            }
        }

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

    /**
     * Export orders as CSV, respecting active filters and role visibility.
     */
    public function export(Request $request)
    {
        $user = auth()->user();
        $query = Order::visibleTo($user)->with(['user', 'city', 'paymentMethod', 'shipment.courierService', 'orderTaker']);

        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                    ->orWhere('number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }
        if ($status = $request->status) {
            $query->where('status', $status);
        }
        if ($payment = $request->payment_status) {
            $query->where('payment_status', $payment);
        }
        if ($type = $request->type) {
            $query->where('type', $type);
        }
        if ($source = $request->order_source) {
            $query->where('order_source', $source);
        }

        if ($dateFrom = $request->date_from) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->date_to) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $orders = $query->orderBy('id', 'desc')->get();

        $filename = 'orders_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($orders) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM for Excel compatibility
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Order ID', 'Order Number', 'Reference No.', 'Source',
                'Customer Name', 'Customer Phone', 'Customer Email',
                'City', 'Street Address',
                'Status', 'Payment Status', 'Payment Method',
                'Subtotal (Rs.)', 'Shipping (Rs.)', 'Discount (Rs.)', 'Total (Rs.)',
                'Courier', 'Tracking Number', 'Shipment Status',
                'Order Taker', 'Date',
            ]);

            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->id,
                    $order->number,
                    $order->reference_number ?? '',
                    ucfirst($order->order_source ?? ''),
                    $order->user->name ?? $order->customer_name ?? 'Guest',
                    $order->user->mobile ?? $order->customer_phone ?? '',
                    $order->user->email ?? $order->customer_email ?? '',
                    $order->city->name ?? '',
                    $order->street_address ?? '',
                    ucfirst($order->status),
                    ucfirst($order->payment_status),
                    $order->paymentMethod->name ?? '',
                    $order->total - ($order->shipping_cost ?? 0) + ($order->discount ?? 0),
                    $order->shipping_cost ?? 0,
                    $order->discount ?? 0,
                    $order->total,
                    $order->shipment ? ucfirst($order->shipment->courierService->courier ?? '') : '',
                    $order->shipment->tracking_number ?? '',
                    $order->shipment ? ucfirst($order->shipment->status) : '',
                    $order->orderTaker->name ?? '',
                    $order->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Return order data as JSON for API calls
     */
    public function apiShow(Order $order)
    {
        $order->load(['orderDetails.product', 'user', 'city', 'country']);
        
        return response()->json([
            'id' => $order->id,
            'order_number' => $order->order_number,
            'total_amount' => $order->total_amount,
            'status' => $order->status,
            'street_address' => $order->street_address,
            'customer_name' => $order->customer_name,
            'customer_email' => $order->customer_email,
            'customer_phone' => $order->customer_phone,
            'city_id' => $order->city_id,
            'country_id' => $order->country_id,
            'zip_code' => $order->zip_code,
            'user' => $order->user ? [
                'id' => $order->user->id,
                'name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone,
            ] : null,
            'city' => $order->city ? [
                'id' => $order->city->id,
                'name' => $order->city->name,
            ] : null,
            'country' => $order->country ? [
                'id' => $order->country->id,
                'name' => $order->country->name,
            ] : null,
            'order_details' => $order->orderDetails->map(function ($detail) {
                return [
                    'id' => $detail->id,
                    'qty' => $detail->qty,
                    'price' => $detail->price,
                    'product' => $detail->product ? [
                        'id' => $detail->product->id,
                        'name' => $detail->product->name,
                    ] : null
                ];
            })
        ]);
    }
}
