@extends('layouts.guest')
@section('title', 'Categories')
@section('content')
    <div class="bg-transparent">
        <!-- Page Header -->
        <div class="border-b border-emerald-900/10 dark:border-emerald-800/20 bg-[#fdfcf9]/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
                <x-breadcrumb :links="[['name' => 'Home', 'link' => '/'], ['name' => 'Categories']]" />
                <div class="mt-6 max-w-2xl">
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-450">{{ __('Browse') }}</span>
                    <h1 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-tight text-emerald-950 dark:text-emerald-100 font-playfair font-serif">
                        {{ __('categories') }}
                    </h1>
                    <p class="mt-3 text-sm text-emerald-850/70 dark:text-emerald-400">
                        {{ __('Explore our full range of product categories.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Grid -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            @if ($categories->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 sm:gap-6">
                    @foreach ($categories as $cat)
                        <a href="{{ route('web.products', ['category' => $cat->slug ?? $cat->id]) }}"
                            class="group p-6 bg-white/90 dark:bg-emerald-950/20 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/30 hover:border-emerald-450 dark:hover:border-emerald-700 hover:shadow-md hover:-translate-y-0.5 transition-all flex flex-col items-center text-center shadow-sm">
                            <div class="w-14 h-14 mb-4 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center border border-emerald-900/10 dark:border-emerald-800/20 group-hover:bg-emerald-100 dark:group-hover:bg-emerald-900/60 transition-colors">
                                <i class="{{ $cat->icon ?? 'fa-solid fa-layer-group' }} text-xl text-emerald-700 dark:text-emerald-400"></i>
                            </div>
                            <div class="font-bold text-sm sm:text-base text-emerald-950 dark:text-white mb-1.5 line-clamp-1">{{ $cat->name }}</div>
                            @if ($cat->description)
                                <div class="text-xs text-emerald-850/60 dark:text-emerald-400 line-clamp-2 leading-relaxed">{{ $cat->description }}</div>
                            @endif
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-white/60 dark:bg-emerald-950/10 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/20 backdrop-blur-sm">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-50 dark:bg-emerald-900/30 rounded-2xl text-emerald-600 dark:text-emerald-400 text-3xl mb-6">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <h3 class="text-xl font-bold text-emerald-950 dark:text-white mb-2 font-serif">{{ __('No categories yet') }}</h3>
                    <p class="text-emerald-850/60 dark:text-emerald-450 text-sm">{{ __('Check back soon.') }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection
