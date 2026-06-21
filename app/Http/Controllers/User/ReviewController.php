<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Auth::user()->productReviews()
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.reviews.index', compact('reviews'));
    }

    public function create($productId)
    {
        $product = Product::findOrFail($productId);
        
        // Check if user has already reviewed this product
        $existingReview = Auth::user()->productReviews()
            ->where('product_id', $productId)
            ->first();

        if ($existingReview) {
            return redirect()->route('user.reviews.edit', $existingReview->id)
                ->with('info', 'You have already reviewed this product. You can edit your review.');
        }

        return view('user.reviews.create', compact('product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Check if user has already reviewed this product
        $existingReview = Auth::user()->productReviews()
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingReview) {
            return redirect()->route('user.reviews.edit', $existingReview->id)
                ->with('error', 'You have already reviewed this product.');
        }

        ProductReview::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('user.reviews.index')
            ->with('success', 'Review submitted successfully!');
    }

    public function edit($id)
    {
        $review = Auth::user()->productReviews()
            ->with('product')
            ->findOrFail($id);

        return view('user.reviews.edit', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review = Auth::user()->productReviews()->findOrFail($id);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('user.reviews.index')
            ->with('success', 'Review updated successfully!');
    }

    public function destroy($id)
    {
        $review = Auth::user()->productReviews()->findOrFail($id);
        $review->delete();

        return redirect()->route('user.reviews.index')
            ->with('success', 'Review deleted successfully!');
    }
}
