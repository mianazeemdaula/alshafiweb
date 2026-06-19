@extends('layouts.guest')

@section('content')
    <!-- Hero -->
    <div class="relative overflow-hidden bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <!-- Left Content -->
                <div class="text-center lg:text-left fade-in-up">
                    <span
                        class="inline-flex items-center gap-2 mb-5 text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-400">
                        <span class="h-px w-6 bg-emerald-500"></span>
                        {{ __('Trusted by 10,000+ Customers') }}
                    </span>
                    <h1
                        class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-gray-900 dark:text-white mb-5 leading-[1.1]">
                        {{ __('Welcome to') }}
                        <span class="text-emerald-600 dark:text-emerald-400">{{ __('Al Shaafi') }}</span>
                    </h1>
                    <p class="text-base sm:text-lg text-gray-500 dark:text-gray-400 mb-8 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                        {{ __('Your trusted health and wellness partner. Discover premium quality products with fast delivery and exceptional service.') }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                        <a href="{{ route('web.products') }}"
                            class="group inline-flex items-center justify-center gap-2 px-7 py-3.5 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition-colors">
                            {{ __('Shop Now') }}
                            <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="#products"
                            class="inline-flex items-center justify-center px-7 py-3.5 text-sm font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-emerald-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                            {{ __('Learn More') }}
                        </a>
                    </div>

                    <!-- Stats -->
                    <div
                        class="grid grid-cols-3 gap-6 mt-12 pt-8 border-t border-gray-100 dark:border-gray-800 max-w-md mx-auto lg:mx-0">
                        <div class="text-center lg:text-left counter-item" data-target="10000">
                            <div class="text-3xl font-extrabold text-gray-900 dark:text-white counter">0</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('Customers') }}</div>
                        </div>
                        <div class="text-center lg:text-left counter-item" data-target="500">
                            <div class="text-3xl font-extrabold text-gray-900 dark:text-white counter">0</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('Products') }}</div>
                        </div>
                        <div class="text-center lg:text-left counter-item" data-target="99">
                            <div class="text-3xl font-extrabold text-gray-900 dark:text-white counter">0</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('Satisfaction') }}%</div>
                        </div>
                    </div>
                </div>

                <!-- Right Content -->
                <div class="relative fade-in-up animation-delay-200">
                    <div class="grid grid-cols-2 gap-4 sm:gap-5">
                        <div
                            class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 p-6 rounded-2xl hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors">
                            <div
                                class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/40 rounded-xl flex items-center justify-center mb-4">
                                <i class="fa-solid fa-shield-heart text-emerald-600 dark:text-emerald-400 text-xl"></i>
                            </div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">{{ __('Quality') }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Certified Products') }}</p>
                        </div>
                        <div
                            class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 p-6 rounded-2xl hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors sm:translate-y-6">
                            <div
                                class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/40 rounded-xl flex items-center justify-center mb-4">
                                <i class="fa-solid fa-rocket text-emerald-600 dark:text-emerald-400 text-xl"></i>
                            </div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">{{ __('Fast') }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Same Day Delivery') }}</p>
                        </div>
                        <div
                            class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 p-6 rounded-2xl hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors">
                            <div
                                class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/40 rounded-xl flex items-center justify-center mb-4">
                                <i class="fa-solid fa-percent text-emerald-600 dark:text-emerald-400 text-xl"></i>
                            </div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">{{ __('Offers') }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Up to 50% Off') }}</p>
                        </div>
                        <div
                            class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 p-6 rounded-2xl hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors sm:translate-y-6">
                            <div
                                class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/40 rounded-xl flex items-center justify-center mb-4">
                                <i class="fa-solid fa-headset text-emerald-600 dark:text-emerald-400 text-xl"></i>
                            </div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">{{ __('Support') }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('24/7 Available') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div id="products" class="py-16 sm:py-24 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10 sm:mb-14 fade-in-up">
                <span
                    class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-400">{{ __('Shop') }}</span>
                <h2 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                    {{ __('Our') }} {{ __('Products') }}
                </h2>
                <p class="mt-3 text-base text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
                    {{ __('Discover our premium collection of health and wellness products') }}
                </p>
            </div>

            @if (isset($products) && $products->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-6">
                    @foreach ($products as $index => $item)
                        <div class="product-card fade-in-up" style="animation-delay: {{ $index * 100 }}ms;">
                            <x-product-card1 :product="$item" />
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-12">
                    <a href="{{ route('web.products') }}"
                        class="group inline-flex items-center gap-2 px-7 py-3.5 text-sm font-semibold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 hover:bg-emerald-100 dark:hover:bg-emerald-900/50 rounded-xl transition-colors">
                        {{ __('View All Products') }}
                        <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-16 fade-in-up">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 bg-gray-50 dark:bg-gray-800 rounded-2xl mb-6">
                        <i class="fa-solid fa-box-open text-3xl text-gray-300 dark:text-gray-600"></i>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        {{ __('No products available for your country') }}
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-8">
                        {{ __('Check back soon for exciting new products!') }}
                    </p>
                    <a href="{{ route('web.products') }}"
                        class="inline-flex items-center gap-2 px-7 py-3.5 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition-colors">
                        {{ __('Browse all products') }}
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Blog Section -->
    <div class="py-16 sm:py-24 bg-gray-50 dark:bg-gray-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10 sm:mb-14 fade-in-up">
                <span
                    class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-400">{{ __('Blog') }}</span>
                <h2 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                    {{ __('Latest') }} {{ __('Articles') }}
                </h2>
                <p class="mt-3 text-base text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
                    {{ __('Stay updated with the latest health tips and wellness insights') }}
                </p>
            </div>

            @if (isset($blogPosts) && $blogPosts->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">
                    @foreach ($blogPosts as $index => $post)
                        <article
                            class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 fade-in-up"
                            style="animation-delay: {{ $index * 100 }}ms;">
                            <!-- Post Image -->
                            <div class="relative h-48 sm:h-56 overflow-hidden">
                                @if ($post->image)
                                    <img src="{{ asset($post->image) }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div
                                        class="w-full h-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                        <div class="text-gray-400 dark:text-gray-500 text-center">
                                            <i class="fa-solid fa-newspaper text-4xl sm:text-5xl mb-3"></i>
                                            <p class="text-sm font-medium">{{ $post->category->name }}</p>
                                        </div>
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white dark:bg-gray-800 text-gray-800 dark:text-white shadow-lg backdrop-blur-sm">
                                        {{ $post->category->name }}
                                    </span>
                                </div>
                            </div>

                            <!-- Post Content -->
                            <div class="p-5 sm:p-6">
                                <!-- Date -->
                                <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mb-3">
                                    <i class="fa-solid fa-calendar-days mr-2"></i>
                                    {{ $post->created_at->format('M d, Y') }}
                                </div>

                                <!-- Title -->
                                <h3
                                    class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-3 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">
                                    <a href="{{ route('blog.post', $post->slug) }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>

                                <!-- Excerpt -->
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-3">
                                    {{ Str::limit(strip_tags($post->content), 100) }}
                                </p>

                                <!-- Read More -->
                                <a href="{{ route('blog.post', $post->slug) }}"
                                    class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 text-sm font-bold transition-all duration-300 group-hover:gap-3">
                                    {{ __('Read More') }}
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="text-center mt-12">
                    <a href="{{ route('blog.index') }}"
                        class="group inline-flex items-center gap-2 px-7 py-3.5 text-sm font-semibold text-emerald-700 dark:text-emerald-400 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:border-emerald-400 rounded-xl transition-colors">
                        {{ __('View All Articles') }}
                        <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-16 fade-in-up">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl mb-6">
                        <i class="fa-solid fa-newspaper text-3xl text-gray-300 dark:text-gray-600"></i>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        {{ __('No Articles Yet') }}
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-8">
                        {{ __('No articles available for your region') }}
                    </p>
                    <a href="{{ route('blog.index') }}"
                        class="inline-flex items-center gap-2 px-7 py-3.5 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition-colors">
                        {{ __('View All Articles') }}
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 sm:py-24 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-14 fade-in-up">
                <span
                    class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-400">{{ __('Why Us') }}</span>
                <h2 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                    {{ __('Why Choose') }} {{ __('Al Shaafi?') }}
                </h2>
                <p class="mt-3 text-base text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
                    {{ __('We provide the best shopping experience with premium quality and service') }}
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
                <!-- Feature 1 -->
                <div
                    class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-7 hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors fade-in-up">
                    <div
                        class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/40 rounded-xl flex items-center justify-center mb-5">
                        <i class="fa-solid fa-bullhorn text-emerald-600 dark:text-emerald-400 text-lg"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('Special Offers') }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                        {{ __('Exclusive deals and discounts up to 50% off on selected products') }}</p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-7 hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors fade-in-up animation-delay-100">
                    <div
                        class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/40 rounded-xl flex items-center justify-center mb-5">
                        <i class="fa-solid fa-shipping-fast text-emerald-600 dark:text-emerald-400 text-lg"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('Fast Delivery') }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                        {{ __('Same-day delivery available for urgent orders in major cities') }}</p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-7 hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors fade-in-up animation-delay-200">
                    <div
                        class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/40 rounded-xl flex items-center justify-center mb-5">
                        <i class="fa-solid fa-heart text-emerald-600 dark:text-emerald-400 text-lg"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('Trusted Quality') }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                        {{ __('100% authentic products certified by health authorities') }}</p>
                </div>

                <!-- Feature 4 -->
                <div
                    class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-7 hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors fade-in-up animation-delay-300">
                    <div
                        class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/40 rounded-xl flex items-center justify-center mb-5">
                        <i class="fa-solid fa-headset text-emerald-600 dark:text-emerald-400 text-lg"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('24/7 Support') }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                        {{ __('Our dedicated team is always ready to assist you anytime') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Reviews Section -->
    <div class="py-16 sm:py-24 bg-gray-50 dark:bg-gray-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-14 fade-in-up">
                <span
                    class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-400">{{ __('Reviews') }}</span>
                <h2 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                    {{ __('Customer') }} {{ __('Reviews') }}
                </h2>
                <p class="mt-3 text-base text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
                    {{ __('See what our customers say about their experience with us') }}
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
                @foreach (range(1, 5) as $index => $item)
                    <div class="group bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-6 hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors fade-in-up"
                        style="animation-delay: {{ $index * 100 }}ms;">
                        <!-- User Avatar and Info -->
                        <div class="flex items-center mb-6">
                            <div class="relative">
                                <div
                                    class="w-14 h-14 bg-emerald-100 dark:bg-emerald-900/40 rounded-full flex items-center justify-center text-emerald-700 dark:text-emerald-300 font-bold text-lg">
                                    {{ substr('User Name ' . $item, 0, 2) }}
                                </div>
                                <div
                                    class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full">
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="font-bold text-gray-900 dark:text-white">User Name {{ $item }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                    <i class="fa-solid fa-circle-check text-blue-500"></i>
                                    Verified Customer
                                </div>
                            </div>
                        </div>

                        <!-- Rating Stars -->
                        <div class="flex items-center gap-1 mb-4">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= 6 - $item)
                                    <i class="fa-solid fa-star text-yellow-400 text-lg"></i>
                                @else
                                    <i class="fa-regular fa-star text-gray-300 dark:text-gray-600 text-lg"></i>
                                @endif
                            @endfor
                            <span
                                class="ml-2 text-sm font-bold text-gray-900 dark:text-white">{{ 6 - $item }}.0</span>
                        </div>

                        <!-- Review Text -->
                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed line-clamp-4">
                                @php
                                    $reviews = [
                                        'Excellent quality products and fast delivery! Highly recommend to everyone looking for authentic health products.',
                                        'Great customer service and affordable prices. The team is very responsive and helpful. Will shop again!',
                                        'Amazing experience! The products exceeded my expectations and arrived in perfect condition.',
                                        'Fast shipping and authentic products. Very satisfied with my purchase and the overall service!',
                                        'Outstanding service and quality. Best online shopping experience I\'ve had in a long time.',
                                    ];
                                @endphp
                                "{{ $reviews[$item - 1] }}"
                            </p>
                        </div>

                        <!-- Date -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                            <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                <i class="fa-solid fa-calendar-days"></i>
                                {{ now()->subDays(rand(1, 30))->format('M d, Y') }}
                            </span>
                            <button class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-700 font-medium">
                                {{ __('Helpful') }} <i class="fa-solid fa-thumbs-up ml-1"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- View All Reviews Button -->
            <div class="text-center mt-12">
                <button
                    class="group inline-flex items-center gap-2 px-7 py-3.5 text-sm font-semibold text-emerald-700 dark:text-emerald-400 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:border-emerald-400 rounded-xl transition-colors">
                    {{ __('View All Reviews') }}
                    <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Newsletter Section -->
    <div class="py-16 sm:py-20 bg-gray-900 dark:bg-black">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center fade-in-up">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-emerald-500/15 rounded-xl mb-6">
                    <i class="fa-solid fa-envelope text-xl text-emerald-400"></i>
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white mb-3">
                    {{ __('Stay Updated!') }}
                </h2>
                <p class="text-base text-gray-400 mb-8 max-w-xl mx-auto">
                    {{ __('Subscribe to our newsletter and get exclusive offers, health tips, and product updates') }}
                </p>

                <form class="max-w-md mx-auto">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input type="email" placeholder="{{ __('Enter your email') }}"
                            class="flex-1 px-5 py-3.5 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <button type="submit"
                            class="px-7 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-colors whitespace-nowrap">
                            {{ __('Subscribe') }}
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-4">
                        {{ __('🔒 We respect your privacy. Unsubscribe anytime.') }}
                    </p>
                </form>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <div class="fixed bottom-6 right-6 z-40">
        <a href="#"
            class="w-12 h-12 bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-lg flex items-center justify-center text-white transition-colors">
            <i class="fa-solid fa-arrow-up"></i>
        </a>
    </div>
@endsection


@section('jsscript')
    <style>
        /* Custom Animations */
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        .animation-delay-100 {
            animation-delay: 100ms;
        }

        .animation-delay-200 {
            animation-delay: 200ms;
        }

        .animation-delay-300 {
            animation-delay: 300ms;
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 3s ease infinite;
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #059669;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #047857;
        }

        /* Dark mode scrollbar */
        .dark ::-webkit-scrollbar-track {
            background: #1f2937;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup CSRF token for AJAX requests
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Intersection Observer for scroll animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all fade-in-up elements
            document.querySelectorAll('.fade-in-up').forEach(el => {
                observer.observe(el);
            });

            // Counter Animation
            const animateCounter = (element) => {
                const target = parseInt(element.closest('.counter-item').getAttribute('data-target'));
                const duration = 2000;
                const step = target / (duration / 16);
                let current = 0;

                const updateCounter = () => {
                    current += step;
                    if (current < target) {
                        element.textContent = Math.floor(current).toLocaleString();
                        requestAnimationFrame(updateCounter);
                    } else {
                        element.textContent = target.toLocaleString();
                    }
                };

                updateCounter();
            };

            // Trigger counter animation when in view
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counter = entry.target.querySelector('.counter');
                        animateCounter(counter);
                        counterObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.5
            });

            document.querySelectorAll('.counter-item').forEach(item => {
                counterObserver.observe(item);
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Scroll to top functionality
            const scrollToTopBtn = document.querySelector('.fixed.bottom-6 a[href="#"]');
            if (scrollToTopBtn) {
                scrollToTopBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });

                // Show/hide scroll to top button
                window.addEventListener('scroll', () => {
                    if (window.pageYOffset > 300) {
                        scrollToTopBtn.parentElement.style.opacity = '1';
                        scrollToTopBtn.parentElement.style.transform = 'translateY(0)';
                    } else {
                        scrollToTopBtn.parentElement.style.opacity = '0';
                        scrollToTopBtn.parentElement.style.transform = 'translateY(20px)';
                    }
                });
            }

            // Product card hover effect
            document.querySelectorAll('.product-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Restrict negative price input for min/max fields
            document.querySelectorAll('input[type="number"]').forEach(function(input) {
                input.addEventListener('input', function() {
                    if (parseInt(this.value) < 0) this.value = 0;
                });
            });

            // Handle quantity buttons
            document.addEventListener('click', function(e) {
                let button = null;
                if (e.target.classList.contains('quantity-btn')) {
                    button = e.target;
                } else if (e.target.closest('.quantity-btn')) {
                    button = e.target.closest('.quantity-btn');
                }

                if (button) {
                    const action = button.getAttribute('data-action');
                    const productCard = button.getAttribute('data-product-card');
                    const quantityInput = document.querySelector(
                        `input.quantity-input[data-product-card="${productCard}"]`);
                    let currentValue = parseInt(quantityInput.value);
                    if (action === 'plus' && currentValue < 10) {
                        quantityInput.value = currentValue + 1;
                    } else if (action === 'minus' && currentValue > 1) {
                        quantityInput.value = currentValue - 1;
                    }
                }
            });

            // Handle add to cart buttons
            document.addEventListener('click', function(e) {
                let button = null;
                if (e.target.classList.contains('add-to-cart-btn')) {
                    button = e.target;
                } else if (e.target.closest('.add-to-cart-btn')) {
                    button = e.target.closest('.add-to-cart-btn');
                }

                if (button && !button.disabled) {
                    const productId = button.getAttribute('data-product-id');
                    const productName = button.getAttribute('data-product-name');
                    const productCard = button.getAttribute('data-product-id');
                    const quantityInput = document.querySelector(
                        `input.quantity-input[data-product-card="${productCard}"]`);
                    const quantity = parseInt(quantityInput.value);

                    button.disabled = true;
                    button.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-sm"></i>';

                    fetch('/cart/add', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                quantity: quantity
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showNotification('✓ ' + productName + ' added to cart!', 'success');
                                updateCartCount(data.cart_count);
                                quantityInput.value = 1;

                                // Show quick checkout modal instead of redirecting
                                setTimeout(function() {
                                    if (typeof showQuickCheckout === 'function') {
                                        showQuickCheckout();
                                    } else {
                                        window.location.href = '/checkout';
                                    }
                                }, 300);
                            } else {
                                showNotification('Error: ' + data.message, 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('Error adding product to cart', 'error');
                        })
                        .finally(() => {
                            button.disabled = false;
                            button.innerHTML = '<i class="fa-solid fa-cart-plus text-sm"></i>';
                        });
                }
            });

            function showNotification(message, type = 'info') {
                const existingNotifications = document.querySelectorAll('.cart-notification');
                existingNotifications.forEach(n => n.remove());

                const notification = document.createElement('div');
                notification.className = `cart-notification fixed top-4 right-4 z-50 px-6 py-4 rounded-2xl shadow-2xl text-white font-medium transition-all duration-300 transform ${
                    type === 'success' ? 'bg-gradient-to-r from-green-500 to-emerald-500' : 
                    type === 'error' ? 'bg-gradient-to-r from-red-500 to-pink-500' : 
                    'bg-gradient-to-r from-blue-500 to-purple-500'
                } backdrop-blur-sm`;
                notification.style.transform = 'translateX(400px)';
                notification.textContent = message;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.style.transform = 'translateX(0)';
                }, 10);

                setTimeout(() => {
                    notification.style.opacity = '0';
                    notification.style.transform = 'translateX(400px)';
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }

            function updateCartCount(count) {
                const cartCountElements = document.querySelectorAll('.cart-count');
                cartCountElements.forEach(element => {
                    element.textContent = count;
                    element.style.display = count > 0 ? 'flex' : 'none';
                    if (count > 0) {
                        element.classList.add('animate-bounce');
                        setTimeout(() => element.classList.remove('animate-bounce'), 500);
                    }
                });
            }

            // Newsletter form submission
            const newsletterForm = document.querySelector('form');
            if (newsletterForm && newsletterForm.querySelector('input[type="email"]')) {
                newsletterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const email = this.querySelector('input[type="email"]').value;
                    if (email) {
                        showNotification('🎉 Thank you for subscribing!', 'success');
                        this.reset();
                    }
                });
            }

            // Add parallax effect to hero section
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const parallaxElements = document.querySelectorAll('.animate-blob');
                parallaxElements.forEach((el, index) => {
                    const speed = 0.5 + (index * 0.1);
                    el.style.transform = `translateY(${scrolled * speed}px)`;
                });
            });
        });
    </script>
@endsection
