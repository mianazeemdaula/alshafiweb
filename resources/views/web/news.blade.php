@extends('layouts.guest')
@section('title', 'News')
@section('content')
    <div class="bg-transparent">
        <!-- Page Header -->
        <div class="border-b border-emerald-900/10 dark:border-emerald-800/20 bg-[#fdfcf9]/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
                <x-breadcrumb :links="[['name' => 'Home', 'link' => '/'], ['name' => 'News']]" />
                <div class="mt-6 max-w-2xl">
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-455">{{ __('Updates') }}</span>
                    <h1 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-tight text-emerald-950 dark:text-white font-playfair font-serif">
                        {{ __('Latest News') }}
                    </h1>
                    <p class="mt-3 text-sm text-emerald-850/70 dark:text-emerald-400">
                        {{ __('Announcements, offers and updates from alshaafionline.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- News Grid -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-6">
                @foreach ([
                    'Grand Opening Sale!' => 'Enjoy up to 50% off on all products during our grand opening week. Shop now and save big!',
                    'New Arrivals: Summer Collection' => 'Check out our latest summer arrivals—fresh styles, vibrant colors, and exclusive deals.',
                    'Customer Success Story' => 'Read how our customer Jane transformed her home with our products.',
                    'Service Expansion' => 'We now deliver to 10+ new cities! See if your area is included.',
                ] as $title => $desc)
                    <article class="p-6 bg-white/90 dark:bg-emerald-950/20 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/30 hover:border-emerald-450 dark:hover:border-emerald-700 hover:shadow-md transition-all shadow-sm">
                        <div class="flex items-center gap-2 text-xs font-semibold text-emerald-850/50 dark:text-emerald-400 mb-3">
                            <i class="fa-solid fa-calendar-days text-emerald-600"></i>
                            {{ date('M d, Y') }}
                        </div>
                        <h3 class="font-bold text-base sm:text-lg text-emerald-950 dark:text-white mb-2 font-serif">{{ $title }}</h3>
                        <p class="text-sm text-emerald-850/70 dark:text-emerald-400 leading-relaxed">{{ $desc }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
@endsection
