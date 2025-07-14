@extends('layouts.guest')
@section('title', 'Services')
@section('content')
    <div
        class="max-w-5xl mx-auto mt-10 p-8 bg-white dark:bg-gray-900 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-bold mb-8 text-purple-700 dark:text-purple-400 flex items-center">
            <i class="fa-solid fa-concierge-bell mr-2"></i>{{ __('services') }}
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach ([['title' => '24/7 Customer Support', 'icon' => 'fa-solid fa-headset', 'desc' => 'We are here to help you anytime, anywhere.'], ['title' => 'Fast Delivery', 'icon' => 'fa-solid fa-shipping-fast', 'desc' => 'Get your orders delivered quickly and safely.'], ['title' => 'Easy Returns', 'icon' => 'fa-solid fa-undo', 'desc' => 'Hassle-free returns within 7 days.'], ['title' => 'Secure Payments', 'icon' => 'fa-solid fa-lock', 'desc' => 'Your transactions are safe with us.']] as $service)
                <div
                    class="p-6 bg-purple-50 dark:bg-purple-900 rounded-xl shadow hover:shadow-xl transition flex items-start gap-4 border border-purple-100 dark:border-purple-800">
                    <i class="{{ $service['icon'] }} text-2xl text-purple-600 dark:text-purple-400 mt-1"></i>
                    <div>
                        <div class="font-semibold text-lg text-purple-800 dark:text-purple-200 mb-1">{{ $service['title'] }}
                        </div>
                        <div class="text-gray-600 dark:text-gray-300 text-sm">{{ $service['desc'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
