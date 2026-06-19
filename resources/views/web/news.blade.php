@extends('layouts.guest')
@section('title', 'News')
@section('content')
    <div class="bg-white dark:bg-gray-900">
        <!-- Page Header -->
        <div class="border-b border-gray-100 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
                <div class="max-w-2xl">
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-400">{{ __('Updates') }}</span>
                    <h1 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                        {{ __('Latest News') }}
                    </h1>
                    <p class="mt-3 text-base text-gray-500 dark:text-gray-400">
                        {{ __('Announcements, offers and updates from alshaafionline.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- News Grid -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
                @foreach ([
                    'Grand Opening Sale!' => 'Enjoy up to 50% off on all products during our grand opening week. Shop now and save big!',
                    'New Arrivals: Summer Collection' => 'Check out our latest summer arrivals—fresh styles, vibrant colors, and exclusive deals.',
                    'Customer Success Story' => 'Read how our customer Jane transformed her home with our products.',
                    'Service Expansion' => 'We now deliver to 10+ new cities! See if your area is included.',
                ] as $title => $desc)
                    <article class="p-6 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors">
                        <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mb-3">
                            <i class="fa-solid fa-calendar-days text-emerald-600 dark:text-emerald-400"></i>
                            {{ date('M d, Y') }}
                        </div>
                        <h3 class="font-semibold text-base text-gray-900 dark:text-white mb-2">{{ $title }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">{{ $desc }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
@endsection

