@extends('layouts.guest')
@section('title', 'Services')
@section('content')
    <div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-purple-700 flex items-center"><i
                class="fa-solid fa-concierge-bell mr-2"></i>Our Services</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ([['title' => '24/7 Customer Support', 'icon' => 'fa-solid fa-headset', 'desc' => 'We are here to help you anytime, anywhere.'], ['title' => 'Fast Delivery', 'icon' => 'fa-solid fa-shipping-fast', 'desc' => 'Get your orders delivered quickly and safely.'], ['title' => 'Easy Returns', 'icon' => 'fa-solid fa-undo', 'desc' => 'Hassle-free returns within 7 days.'], ['title' => 'Secure Payments', 'icon' => 'fa-solid fa-lock', 'desc' => 'Your transactions are safe with us.']] as $service)
                <div class="p-4 bg-purple-50 rounded-lg shadow hover:shadow-lg transition flex items-start gap-3">
                    <i class="{{ $service['icon'] }} text-2xl text-purple-600 mt-1"></i>
                    <div>
                        <div class="font-semibold text-lg text-purple-800 mb-1">{{ $service['title'] }}</div>
                        <div class="text-gray-600 text-sm">{{ $service['desc'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
