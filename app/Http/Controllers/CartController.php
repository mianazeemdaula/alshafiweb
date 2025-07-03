<?php

namespace App\Http\Controllers;

use App\Facades\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    /**
     * Add item to cart
     */
    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1|max:10'
        ]);

        $product = Product::find($request->product_id);
        $quantity = $request->quantity ?? 1;

        // Check if product is in stock
        if ($product->stock < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available'
            ], 400);
        }

        Cart::add(
            $product->id,
            [$product->name],
            [str()->slug($product->name)],
            $product->price,
            $product->media->first()?->path ?? '',
            $quantity
        );

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully',
            'cart_count' => Cart::items(),
            'cart_total' => Cart::total()
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|string',
            'action' => 'required|in:plus,minus'
        ]);

        Cart::update($request->product_id, $request->action);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'cart_count' => Cart::items(),
            'cart_total' => Cart::total()
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|string'
        ]);

        Cart::remove($request->product_id);

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart',
            'cart_count' => Cart::items(),
            'cart_total' => Cart::total()
        ]);
    }

    /**
     * Get cart contents
     */
    public function contents(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'items' => Cart::content(),
            'count' => Cart::items(),
            'total' => Cart::total()
        ]);
    }

    /**
     * Clear cart
     */
    public function clear(): JsonResponse
    {
        Cart::clear();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully'
        ]);
    }
}
