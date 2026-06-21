<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $country = $request->country ?? session('country', 'pakistan');
        $products = Product::whereHas('country', function($query) use ($country) {
            $query->where('name', 'like', '%' . $country . '%');
        })->get();
        return response()->json($products, 200);
    }

    public function featured(Request $request)
    {
        $country = $request->country ?? session('country', 'pakistan');
        $products = Product::where('featured', true)
            ->whereHas('country', function($query) use ($country) {
                $query->where('name', 'like', '%' . $country . '%');
            })->get();
        return response()->json($products, 200);
    }
}
