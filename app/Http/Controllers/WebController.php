<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class WebController extends Controller
{
    public function index()
    {
        // Get products for current country
        $products = \App\Models\Product::with(['country', 'category', 'activeOffers']);
        
        // Filter by current country from session
        $currentCountry = session('country');
        if ($currentCountry) {
            $country = \App\Models\Country::where('iso2', $currentCountry)->first();
            if ($country) {
                $products->where('country_id', $country->id);
            }
        }
        
        $products = $products->take(10)->inRandomOrder()->get();
        
        // Get recent blog posts for current country
        $blogPosts = \App\Models\BlogPost::with(['country', 'category']);
        
        if ($currentCountry) {
            $country = \App\Models\Country::where('iso2', $currentCountry)->first();
            if ($country) {
                $blogPosts->where('country_id', $country->id);
            }
        }
        
        $blogPosts = $blogPosts->where('status', 'published')
                             ->orderBy('created_at', 'desc')
                             ->take(4)
                             ->get();
        
        return view('web.index', compact('products', 'blogPosts'));
    }

    public function login()
    {
        return view('web.login');
    }

    public function dologin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }
        return redirect()->back()->with('error', 'Invalid credentials');
    }

    public function register()
    {
        return view('web.register');
    }

    public function products()
    {
        $products = \App\Models\Product::with(['country', 'category', 'reviews', 'activeOffers']);
        
        // Filter by current country from session
        $currentCountry = session('country');
        if ($currentCountry) {
            $country = \App\Models\Country::where('iso2', $currentCountry)->first();
            if ($country) {
                $products->where('country_id', $country->id);
            }
        }
        
        // Category filter - using category slug
        if(request()->has('category')){
            $category = \App\Models\Category::where('slug', request()->category)->first();
            if($category) {
                $products->where('category_id', $category->id);
            }
        }
        
        // Price range filters
        if(request()->has('min') && request()->min != ''){
            $products->where('price', '>=', request()->min);
        }
        if(request()->has('max') && request()->max != ''){
            $products->where('price', '<=', request()->max);
        }

        // Search filter
        if(request()->filled('search')){
            $search = request('search');
            $products->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }

        // Get all products
        $allProducts = $products->get();

        // Apply rating filter
        if(request()->has('rating') && request()->rating != ''){
            $ratingFilter = request()->rating;
            $allProducts = $allProducts->filter(function($product) use ($ratingFilter) {
                return $product->average_rating >= $ratingFilter;
            });
        }

        // Apply sorting
        $sortBy = request()->get('sort', 'created_at');
        
        switch($sortBy) {
            case 'price_low':
                $allProducts = $allProducts->sortBy('price');
                break;
            case 'price_high':
                $allProducts = $allProducts->sortByDesc('price');
                break;
            case 'name':
                $allProducts = $allProducts->sortBy('name');
                break;
            case 'rating':
                $allProducts = $allProducts->sortByDesc('average_rating');
                break;
            case 'newest':
                $allProducts = $allProducts->sortByDesc('created_at');
                break;
            default:
                $allProducts = $allProducts->sortByDesc('created_at');
        }

        // Manual pagination
        $page = request()->get('page', 1);
        $perPage = 16;
        $total = $allProducts->count();
        $products = $allProducts->slice(($page - 1) * $perPage, $perPage)->values();
        
        // Create paginator
        $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $products,
            $total,
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'pageName' => 'page',
            ]
        );
        
        // Append query parameters
        $products->appends(request()->query());
        
        // Get categories for filter
        $categories = \App\Models\Category::all();
        
        return view('web.products', compact('products', 'categories'));
    }

    public function product($slug)
    {
        $product = \App\Models\Product::with(['country', 'category', 'reviews', 'activeOffers'])
            ->where('sku', $slug)
            ->firstOrFail();
        
        // Check if product belongs to current country
        // $currentCountry = session('country');
        // if ($currentCountry) {
        //     $country = \App\Models\Country::where('iso2', $currentCountry)->first();
        //     if ($country && $product->country_id !== $country->id) {
        //         abort(404);
        //     }
        // }
        
        return view('web.product', compact('product'));
    }

    public function contactus()
    {
        return view('web.contactus');
    }

    public function cart()
    {
        return view('web.cart');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    
    public function trackOrder(Request $request)
    {
        $order = null;
        if ($request->filled('order_number')) {
            $order = \App\Models\Order::where('number', $request->order_number)->first();
        }
        return view('web.track-order', compact('order'));
    }

    public function news()
    {
        return view('web.news');
    }
    public function categories()
    {
        return view('web.categories');
    }
    public function services()
    {
        return view('web.services');
    }
    
    public function blog()
    {
        $posts = \App\Models\BlogPost::with(['country', 'category', 'user']);
        
        // Filter by current country from session
        $currentCountry = session('country');
        if ($currentCountry) {
            $country = \App\Models\Country::where('iso2', $currentCountry)->first();
            if ($country) {
                $posts->where('country_id', $country->id);
            }
        }
        
        // Only published posts
        $posts->where('status', 'published');
        
        // Category filter
        if(request()->has('category')){
            $category = \App\Models\BlogCategory::where('slug', request()->category)->first();
            if($category) {
                $posts->where('blog_category_id', $category->id);
            }
        }
        
        // Search filter
        if(request()->filled('search')){
            $search = request('search');
            $posts->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('content', 'like', "%$search%");
            });
        }
        
        // Sorting
        $sortBy = request()->get('sort', 'created_at');
        switch($sortBy) {
            case 'title':
                $posts->orderBy('title', 'asc');
                break;
            case 'oldest':
                $posts->orderBy('created_at', 'asc');
                break;
            default:
                $posts->orderBy('created_at', 'desc');
        }
        
        $posts = $posts->paginate(12);
        
        // Get categories for filter
        $categories = \App\Models\BlogCategory::all();
        
        return view('web.blog.index', compact('posts', 'categories'));
    }
    
    public function blogPost($slug)
    {
        $post = \App\Models\BlogPost::with(['country', 'category', 'user'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();
            
        // Check if post belongs to current country
        // $currentCountry = session('country');
        // if ($currentCountry) {
        //     $country = \App\Models\Country::where('iso2', $currentCountry)->first();
        //     if ($country && $post->country_id !== $country->id) {
        //         abort(404);
        //     }
        // }
        
        // Get related posts from same category and country
        $relatedPosts = \App\Models\BlogPost::with(['country', 'category'])
            ->where('blog_category_id', $post->blog_category_id)
            ->where('country_id', $post->country_id)
            ->where('id', '!=', $post->id)
            ->where('status', 'published')
            ->take(3)
            ->get();
        
        return view('web.blog.post', compact('post', 'relatedPosts'));
    }

    public function termsAndConditions()
    {
        return view('web.legal.terms-and-conditions');
    }

    public function privacyPolicy()
    {
        return view('web.legal.privacy-policy');
    }
}
