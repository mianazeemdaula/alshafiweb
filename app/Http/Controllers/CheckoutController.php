<?php

namespace App\Http\Controllers;

use App\Facades\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * Show checkout page
     */
    public function index()
    {
        return view('web.checkout');
    }

    /**
     * Handle user registration during checkout
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            // Enforce mobile format starting with 03 and 11 digits total (e.g., 03123456789)
            'mobile' => ['required', 'regex:/^03[0-9]{9}$/', 'unique:users'],
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        // assign user role
        $user->assignRole('user');

        return response()->json([
            'success' => true,
            'message' => 'Account created successfully'
        ]);
    }

    /**
     * Handle user login during checkout
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => true,
                'message' => 'Login successful'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    /**
     * Place order
     */
    public function placeOrder(Request $request): JsonResponse
    {
        // Allow guest checkout: require minimal shipping info (name, phone, city, address)
        // If last_name is not provided, use first_name for both
        if (empty($request->input('shipping.last_name'))) {
            $shipping = $request->input('shipping', []);
            $shipping['last_name'] = $shipping['first_name'] ?? '';
            $request->merge(['shipping' => $shipping]);
        }

        $validator = Validator::make($request->all(), [
            'shipping.first_name' => 'required|string|max:255',
            // Enforce phone format starting with 03 and 11 digits total (e.g., 03123456789)
            'shipping.phone' => ['required', 'regex:/^03[0-9]{9}$/'],
            'shipping.address' => 'required|string|max:500',
            'shipping.city' => 'required|string|max:100',
            'shipping.postal_code' => 'nullable|string|max:20',
            'shipping.notes' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:cod',
        ], [
            'shipping.phone.regex' => 'Phone number must start with 03 and contain 11 digits, e.g. 03123456789',
            'mobile.regex' => 'Mobile number must start with 03 and contain 11 digits, e.g. 03123456789',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        // Get cart contents
        $cartItems = Cart::content();
        $cartTotal = Cart::total();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty'
            ], 400);
        }

        // Validate stock availability
        foreach ($cartItems as $item) {
            $product = Product::find($item['id']);
            if (!$product || $product->stock < $item['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock for ' . $item['name'][0]
                ], 400);
            }
        }

        try {
            // Get or create a default payment method for COD
            $paymentMethod = \App\Models\PaymentMethod::firstOrCreate([
                'slug' => 'cash-on-delivery'
            ], [
                'name' => 'Cash on Delivery',
                'slug' => 'cash-on-delivery',
                'status' => true
            ]);

            // Get or create a default city (you might want to make this dynamic)
            $city = \App\Models\City::first();
            if (!$city) {
                // Create a default state first if it doesn't exist
                $state = \App\Models\State::firstOrCreate([
                    'name' => 'Default State'
                ], [
                    'name' => 'Default State',
                ]);

                // Create a default city
                $city = \App\Models\City::create([
                    'name' => 'Default City',
                    'state_id' => $state->id,
                    'delivery_rate' => 0.00,
                ]);
            }

            // Generate order number
            $orderNumber = 'ORD-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

            // Create order
            $orderData = [
                'number' => $orderNumber,
                'payment_method_id' => $paymentMethod->id,
                'status' => 'open',
                'payment_status' => 'pending',
                'street_address' => $request->input('shipping.address'),
                'shipping_address' => $request->input('shipping'),
                'city_id' => $city->id, // You might want to make this dynamic based on user selection
                'country_id' => session('country_id'),
                'zip_code' => $request->input('shipping.postal_code') ? (int)$request->input('shipping.postal_code') : 0,
                'shipping_cost' => 0, // Free shipping
                'discount' => 0,
                'total' => floatval(str_replace(['RS.', 'Rs.', '$', ',', ' '], '', $cartTotal)), // Keep as rupees
                'extra_note' => $request->input('shipping.notes') ?? null,
                'order_source' => 'website', // Orders from website checkout
                'order_taker_id' => null, // No order taker for website orders
            ];

            // If user is authenticated, associate; otherwise leave as guest order
            if (Auth::check()) {
                $orderData['user_id'] = Auth::id();
            } else {
                $orderData['user_id'] = null;
                $orderData['customer_name'] = $request->input('shipping.first_name');
                $orderData['customer_phone'] = $request->input('shipping.phone');
            }

            $order = Order::create($orderData);

            // Create order details and update stock
            foreach ($cartItems as $item) {
                $product = Product::find($item['id']);
                
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'qty' => $item['quantity'],
                    'price' => $product->price,
                ]);

                // Update product stock and sales count
                $product->decrement('stock', $item['quantity']);
                $product->increment('sales_count', $item['quantity']);
            }

            // Clear cart
            Cart::clear();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'order_id' => $order->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while placing the order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show order confirmation page
     */
    public function orderConfirmation($orderId)
    {
        $order = Order::with(['orderDetails.product', 'user'])->find($orderId);

        if (!$order) {
            abort(404, 'Order not found');
        }

        // If the order belongs to an authenticated user, only that user or an admin can view it.
        if ($order->user_id) {
            if (!Auth::check()) {
                abort(403, 'Forbidden');
            }

            $current = Auth::user();
            if ($current->id !== $order->user_id && !$current->hasRole('admin')) {
                abort(403, 'Forbidden');
            }
        }

        // Guest orders (user_id == null) are viewable without authentication via order id.
        return view('web.order-confirmation', compact('order'));
    }
}
