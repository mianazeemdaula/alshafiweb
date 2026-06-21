@extends('layouts.guest')
@section('title', 'Services')
@section('content')
    <div class="bg-transparent">
        <!-- Page Header -->
        <div class="border-b border-emerald-900/10 dark:border-emerald-800/20 bg-[#fdfcf9]/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
                <x-breadcrumb :links="[['name' => 'Home', 'link' => '/'], ['name' => 'Services']]" />
                <div class="mt-6 max-w-2xl">
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-455">{{ __('What We Offer') }}</span>
                    <h1 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-tight text-emerald-950 dark:text-white font-playfair font-serif">
                        {{ __('services') }}
                    </h1>
                    <p class="mt-3 text-sm text-emerald-850/70 dark:text-emerald-400">
                        {{ __('Everything you need for a smooth shopping experience.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Grid -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-6">
                @foreach ([
                    ['title' => '24/7 Customer Support', 'icon' => 'fa-solid fa-headset', 'desc' => 'We are here to help you anytime, anywhere.'],
                    ['title' => 'Fast Delivery', 'icon' => 'fa-solid fa-shipping-fast', 'desc' => 'Get your orders delivered quickly and safely.'],
                    ['title' => 'Easy Returns', 'icon' => 'fa-solid fa-undo', 'desc' => 'Hassle-free returns within 7 days.'],
                    ['title' => 'Secure Payments', 'icon' => 'fa-solid fa-lock', 'desc' => 'Your transactions are safe with us.'],
                ] as $service)
                    <div class="p-7 bg-white/90 dark:bg-emerald-950/20 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/30 hover:border-emerald-450 dark:hover:border-emerald-700 hover:shadow-md transition-all shadow-sm">
                        <div class="w-12 h-12 mb-5 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center border border-emerald-900/10 dark:border-emerald-800/20">
                            <i class="{{ $service['icon'] }} text-lg text-emerald-700 dark:text-emerald-400"></i>
                        </div>
                        <div class="font-bold text-base text-emerald-950 dark:text-white mb-2 font-serif">{{ $service['title'] }}</div>
                        <div class="text-sm text-emerald-850/70 dark:text-emerald-400 leading-relaxed">{{ $service['desc'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
