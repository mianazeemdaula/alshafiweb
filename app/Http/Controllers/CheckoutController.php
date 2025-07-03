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
            'mobile' => 'required|string|max:18|unique:users',
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
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to place an order'
            ], 401);
        }

        // If last_name is not provided, use first_name for both
        if (empty($request->shipping['last_name'])) {
            $request->merge([
                'shipping' => array_merge($request->shipping, [
                    'last_name' => $request->shipping['first_name'] ?? ''
                ])
            ]);
        }

        $validator = Validator::make($request->all(), [
            'shipping.first_name' => 'required|string|max:255',
            'shipping.last_name' => 'required|string|max:255',
            'shipping.phone' => 'required|string|max:20',
            'shipping.address' => 'required|string|max:500',
            'shipping.city' => 'required|string|max:100',
            'shipping.postal_code' => 'nullable|string|max:20',
            'shipping.notes' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:cod',
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
            $order = Order::create([
                'number' => $orderNumber,
                'user_id' => Auth::id(),
                'payment_method_id' => $paymentMethod->id,
                'status' => 'open',
                'payment_status' => 'pending',
                'street_address' => $request->shipping['address'],
                'city_id' => $city->id, // You might want to make this dynamic based on user selection
                'zip_code' => $request->shipping['postal_code'] ? (int)$request->shipping['postal_code'] : 0,
                'shipping_cost' => 0, // Free shipping
                'discount' => 0,
                'total' => (int)(floatval(str_replace(['$', ','], '', $cartTotal)) * 100), // Convert to cents, removing any currency symbols
                'extra_note' => $request->shipping['notes'] ?? null,
            ]);

            // Create order details and update stock
            foreach ($cartItems as $item) {
                $product = Product::find($item['id']);
                
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'total' => $product->price * $item['quantity'],
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
                'message' => 'Failed to place order. Please try again.'
            ], 500);
        }
    }

    /**
     * Show order confirmation page
     */
    public function orderConfirmation($orderId)
    {
        $order = Order::with(['orderDetails.product', 'user'])
                     ->where('id', $orderId)
                     ->where('user_id', Auth::id())
                     ->first();

        if (!$order) {
            abort(404, 'Order not found');
        }

        return view('web.order-confirmation', compact('order'));
    }
}
