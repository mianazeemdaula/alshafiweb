<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductOffer;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProductOffer::with('product');

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $offers = $query->orderBy('priority', 'desc')->paginate(20);
        $products = Product::where('is_active', true)->get();

        return view('admin.product-offers.index', compact('offers', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where('is_active', true)->orderBy('name')->get();
        return view('admin.product-offers.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'title' => 'required|string|max:100',
            'min_quantity' => 'required|integer|min:1',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'priority' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['priority'] = $validated['priority'] ?? 0;

        ProductOffer::create($validated);

        return redirect()->route('admin.product-offers.index')
            ->with('success', 'Product offer created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductOffer $productOffer)
    {
        $productOffer->load('product');
        return view('admin.product-offers.show', compact('productOffer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductOffer $productOffer)
    {
        $products = Product::where('is_active', true)->orderBy('name')->get();
        return view('admin.product-offers.edit', compact('productOffer', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductOffer $productOffer)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'title' => 'required|string|max:100',
            'min_quantity' => 'required|integer|min:1',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'priority' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['priority'] = $validated['priority'] ?? 0;

        $productOffer->update($validated);

        return redirect()->route('admin.product-offers.index')
            ->with('success', 'Product offer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductOffer $productOffer)
    {
        $productOffer->delete();

        return redirect()->route('admin.product-offers.index')
            ->with('success', 'Product offer deleted successfully!');
    }

    /**
     * Toggle offer active status
     */
    public function toggle(ProductOffer $productOffer)
    {
        $productOffer->update(['is_active' => !$productOffer->is_active]);

        return back()->with('success', 'Offer status updated successfully!');
    }
}
