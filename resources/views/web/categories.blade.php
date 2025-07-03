@extends('layouts.guest')
@section('title', 'Categories')
@section('content')
    <div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-green-700 flex items-center"><i class="fa-solid fa-layer-group mr-2"></i>Shop
            by Category</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ([['name' => 'Electronics', 'icon' => 'fa-solid fa-tv', 'desc' => 'Latest gadgets & devices'], ['name' => 'Fashion', 'icon' => 'fa-solid fa-tshirt', 'desc' => 'Trendy clothes & accessories'], ['name' => 'Home', 'icon' => 'fa-solid fa-couch', 'desc' => 'Furniture & decor'], ['name' => 'Beauty', 'icon' => 'fa-solid fa-magic', 'desc' => 'Cosmetics & skincare'], ['name' => 'Sports', 'icon' => 'fa-solid fa-basketball-ball', 'desc' => 'Gear & equipment'], ['name' => 'Books', 'icon' => 'fa-solid fa-book', 'desc' => 'Bestsellers & classics'], ['name' => 'Toys', 'icon' => 'fa-solid fa-puzzle-piece', 'desc' => 'Fun for all ages'], ['name' => 'Groceries', 'icon' => 'fa-solid fa-apple-alt', 'desc' => 'Daily essentials']] as $cat)
                <div class="p-4 bg-green-50 rounded-lg shadow hover:shadow-lg transition flex flex-col items-center">
                    <i class="{{ $cat['icon'] }} text-3xl text-green-600 mb-2"></i>
                    <div class="font-semibold text-base text-green-800 mb-1">{{ $cat['name'] }}</div>
                    <div class="text-gray-500 text-xs text-center">{{ $cat['desc'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
