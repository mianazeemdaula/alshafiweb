<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductReview;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = ProductReview::with(['user', 'product'])
            ->where('approved', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        return view('web.reviews', compact('reviews'));
    }
}
