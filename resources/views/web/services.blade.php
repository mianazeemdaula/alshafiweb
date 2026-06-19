@extends('layouts.guest')
@section('title', 'Services')
@section('content')
    <div class="bg-white dark:bg-gray-900">
        <!-- Page Header -->
        <div class="border-b border-gray-100 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
                <div class="max-w-2xl">
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-400">{{ __('What We Offer') }}</span>
                    <h1 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                        {{ __('services') }}
                    </h1>
                    <p class="mt-3 text-base text-gray-500 dark:text-gray-400">
                        {{ __('Everything you need for a smooth shopping experience.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Grid -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
                @foreach ([
                    ['title' => '24/7 Customer Support', 'icon' => 'fa-solid fa-headset', 'desc' => 'We are here to help you anytime, anywhere.'],
                    ['title' => 'Fast Delivery', 'icon' => 'fa-solid fa-shipping-fast', 'desc' => 'Get your orders delivered quickly and safely.'],
                    ['title' => 'Easy Returns', 'icon' => 'fa-solid fa-undo', 'desc' => 'Hassle-free returns within 7 days.'],
                    ['title' => 'Secure Payments', 'icon' => 'fa-solid fa-lock', 'desc' => 'Your transactions are safe with us.'],
                ] as $service)
                    <div class="p-7 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors">
                        <div class="w-12 h-12 mb-5 rounded-xl bg-emerald-50 dark:bg-emerald-900/40 flex items-center justify-center">
                            <i class="{{ $service['icon'] }} text-lg text-emerald-600 dark:text-emerald-400"></i>
                        </div>
                        <div class="font-semibold text-base text-gray-900 dark:text-white mb-2">{{ $service['title'] }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">{{ $service['desc'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

