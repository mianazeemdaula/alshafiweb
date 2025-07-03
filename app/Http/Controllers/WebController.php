<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebController extends Controller
{
    public function index()
    {
        return view('web.index');
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
        $products = \App\Models\Product::query();
        if(request()->has('category')){
            $products->where('category_id', request()->category);
        }
        if(request()->has('min')){
            $products->where('price', '>=', request()->min);
        }
        if(request()->has('max')){
            $products->where('price', '<=', request()->max);
        }
        if(request()->filled('search')){
            $search = request('search');
            $products->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ;
            });
        }
        $products = $products->paginate(16);
        return view('web.products', compact('products'));
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
}
