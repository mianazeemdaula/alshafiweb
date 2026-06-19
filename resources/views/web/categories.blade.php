@extends('layouts.guest')
@section('title', 'Categories')
@section('content')
    <div class="bg-white dark:bg-gray-900">
        <!-- Page Header -->
        <div class="border-b border-gray-100 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
                <div class="max-w-2xl">
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-400">{{ __('Browse') }}</span>
                    <h1 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                        {{ __('categories') }}
                    </h1>
                    <p class="mt-3 text-base text-gray-500 dark:text-gray-400">
                        {{ __('Explore our full range of product categories.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Grid -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            @if ($categories->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-5">
                    @foreach ($categories as $cat)
                        <a href="{{ route('web.products', ['category' => $cat->slug ?? $cat->id]) }}"
                            class="group p-6 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors flex flex-col items-center text-center">
                            <div class="w-12 h-12 mb-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/40 flex items-center justify-center group-hover:bg-emerald-100 dark:group-hover:bg-emerald-900/60 transition-colors">
                                <i class="{{ $cat->icon ?? 'fa-solid fa-layer-group' }} text-lg text-emerald-600 dark:text-emerald-400"></i>
                            </div>
                            <div class="font-semibold text-sm text-gray-900 dark:text-white mb-1 line-clamp-1">{{ $cat->name }}</div>
                            @if ($cat->description)
                                <div class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2">{{ $cat->description }}</div>
                            @endif
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-50 dark:bg-gray-800 rounded-2xl mb-6">
                        <i class="fa-solid fa-layer-group text-3xl text-gray-300 dark:text-gray-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ __('No categories yet') }}</h3>
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Check back soon.') }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection

