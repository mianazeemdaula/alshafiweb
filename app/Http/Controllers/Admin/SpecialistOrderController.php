<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\City;
use App\Models\Country;
use App\Models\PaymentMethod;
use App\Models\SpecialistPenalty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SpecialistOrderController extends Controller
{
    /**
     * Display a listing of specialist orders
     */
    public function index()
    {
        $user = Auth::user();
        
        // Only specialists can view this page, or admins
        if (!$user->isSpecialist() && !$user->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $query = Order::query();
        
        // Filter by specialist if not admin
        if ($user->isSpecialist()) {
            $query->where('order_taker_id', $user->id);
        }
        
        $query->where('order_source', 'specialist');

        // Search functionality
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status = request('status')) {
            $query->where('status', $status);
        }

        $orders = $query->with(['city', 'country', 'paymentMethod', 'orderDetails.product', 'penalty'])
                       ->orderBy('id', 'desc')
                       ->paginate(15)
                       ->withQueryString();

        // Calculate totals
        $totalOrders = Order::where('order_source', 'specialist')
                           ->when($user->isSpecialist(), fn($q) => $q->where('order_taker_id', $user->id))
                           ->count();
                           
        $totalRevenue = Order::where('order_source', 'specialist')
                            ->when($user->isSpecialist(), fn($q) => $q->where('order_taker_id', $user->id))
                            ->sum('total');
                            
        $totalPenalties = SpecialistPenalty::where('status', 'applied')
                                          ->when($user->isSpecialist(), fn($q) => $q->where('specialist_id', $user->id))
                                          ->sum('penalty_amount');

        return view('admin.specialist-orders.index', compact('orders', 'totalOrders', 'totalRevenue', 'totalPenalties'));
    }

    /**
     * Show the form for creating a new specialist order
     */
    public function create()
    {
        $user = Auth::user();
        
        if (!$user->isSpecialist() && !$user->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $products = Product::where('is_active', true)->with('category', 'country')->get();
        $cities = City::with('state')->get();
        $countries = Country::all();
        $paymentMethods = PaymentMethod::where('status', true)->get();
        $types = Order::getTypes();

        return view('admin.specialist-orders.create', compact('products', 'cities', 'countries', 'paymentMethods', 'types'));
    }

    /**
     * Store a newly created specialist order
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isSpecialist() && !$user->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'city_id' => 'required|exists:cities,id',
            'country_id' => 'required|exists:countries,id',
            'street_address' => 'required|string|max:500',
            'zip_code' => 'nullable|string|max:20',
            'extra_note' => 'nullable|string|max:500',
            'type' => 'required|in:call,clinic,website,repeat,complain,gift',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'shipping_cost' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Generate order number
            $orderNumber = 'SPEC-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

            // Calculate totals
            $subtotal = 0;
            foreach ($validated['products'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $subtotal += $product->price * $item['quantity'];
            }

            $shippingCost = $validated['shipping_cost'] ?? 0;
            $discount = $validated['discount'] ?? 0;
            $total = $subtotal + $shippingCost - $discount;

            // Create order
            $order = Order::create([
                'number' => $orderNumber,
                'order_source' => 'specialist',
                'order_taker_id' => $user->id,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'],
                'payment_method_id' => $validated['payment_method_id'],
                'city_id' => $validated['city_id'],
                'country_id' => $validated['country_id'],
                'street_address' => $validated['street_address'],
                'zip_code' => $validated['zip_code'],
                'extra_note' => $validated['extra_note'],
                'type' => $validated['type'],
                'status' => 'open',
                'payment_status' => 'pending',
                'shipping_cost' => $shippingCost,
                'discount' => $discount,
                'total' => $total,
            ]);

            // Create order details
            foreach ($validated['products'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'qty' => $item['quantity'],
                    'price' => $product->price,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.specialist-orders.index')
                ->with('success', 'Specialist order created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to create order: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified specialist order
     */
    public function show(Order $order)
    {
        $user = Auth::user();
        
        // Check if order belongs to specialist or user is admin
        if (!$user->isAdmin() && $order->order_taker_id !== $user->id) {
            abort(403, 'Unauthorized access');
        }

        $order->load(['orderDetails.product', 'city', 'country', 'paymentMethod', 'penalty']);

        return view('admin.specialist-orders.show', compact('order'));
    }

    /**
     * Show penalties for specialist orders
     */
    public function penalties()
    {
        $user = Auth::user();
        
        if (!$user->isSpecialist() && !$user->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $query = SpecialistPenalty::with(['order', 'specialist']);
        
        if ($user->isSpecialist()) {
            $query->where('specialist_id', $user->id);
        }

        $penalties = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $totalPenalties = SpecialistPenalty::where('status', 'applied')
                                          ->when($user->isSpecialist(), fn($q) => $q->where('specialist_id', $user->id))
                                          ->sum('penalty_amount');

        return view('admin.specialist-orders.penalties', compact('penalties', 'totalPenalties'));
    }
}
