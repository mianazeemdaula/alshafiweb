@extends('layouts.guest')

@section('content')
    <!-- Hero Section with Modern Animation -->
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 dark:from-gray-900 dark:via-purple-900 dark:to-blue-900">
        <!-- Animated Background Shapes -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-300 dark:bg-purple-600 rounded-full mix-blend-multiply dark:mix-blend-soft-light filter blur-xl opacity-70 animate-blob"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-300 dark:bg-blue-600 rounded-full mix-blend-multiply dark:mix-blend-soft-light filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
            <div class="absolute top-40 left-40 w-80 h-80 bg-pink-300 dark:bg-pink-600 rounded-full mix-blend-multiply dark:mix-blend-soft-light filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                <!-- Left Content -->
                <div class="text-center lg:text-left fade-in-up">
                    <div class="inline-block mb-4 sm:mb-6">
                        <span class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-2 rounded-full text-xs sm:text-sm font-semibold shadow-lg animate-pulse">
                            ✨ {{ __('Trusted by 10,000+ Customers') }}
                        </span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 dark:text-white mb-4 sm:mb-6 leading-tight">
                        {{ __('Welcome to') }}
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 animate-gradient">
                            {{ __('Al Shaafi') }}
                        </span>
                    </h1>
                    <p class="text-base sm:text-lg md:text-xl text-gray-600 dark:text-gray-300 mb-6 sm:mb-8 max-w-2xl mx-auto lg:mx-0">
                        {{ __('Your trusted health and wellness partner. Discover premium quality products with fast delivery and exceptional service.') }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('web.products') }}"
                            class="group relative inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 text-base sm:text-lg font-bold text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-full overflow-hidden shadow-2xl transform hover:scale-105 transition-all duration-300">
                            <span class="absolute w-0 h-0 transition-all duration-500 ease-out bg-white rounded-full group-hover:w-56 group-hover:h-56 opacity-10"></span>
                            <span class="relative flex items-center gap-2">
                                {{ __('Shop Now') }}
                                <i class="fa-solid fa-arrow-right group-hover:translate-x-2 transition-transform duration-300"></i>
                            </span>
                        </a>
                        <a href="#products"
                            class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 text-base sm:text-lg font-bold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 rounded-full hover:border-purple-600 dark:hover:border-purple-500 transition-all duration-300 shadow-lg hover:shadow-xl">
                            {{ __('Learn More') }}
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 mt-8 sm:mt-12">
                        <div class="text-center counter-item" data-target="10000">
                            <div class="text-2xl sm:text-3xl md:text-4xl font-bold text-blue-600 dark:text-blue-400 counter">0</div>
                            <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('Customers') }}</div>
                        </div>
                        <div class="text-center counter-item" data-target="500">
                            <div class="text-2xl sm:text-3xl md:text-4xl font-bold text-purple-600 dark:text-purple-400 counter">0</div>
                            <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('Products') }}</div>
                        </div>
                        <div class="text-center counter-item" data-target="99">
                            <div class="text-2xl sm:text-3xl md:text-4xl font-bold text-pink-600 dark:text-pink-400 counter">0</div>
                            <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('Satisfaction') }}%</div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Hero Image/Illustration -->
                <div class="relative fade-in-up animation-delay-200">
                    <div class="relative z-10">
                        <div class="bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 rounded-3xl shadow-2xl p-1 transform hover:rotate-1 transition-transform duration-500">
                            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-8">
                                <!-- Feature Cards Grid -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="group bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 p-4 sm:p-6 rounded-2xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-blue-500 rounded-2xl flex items-center justify-center mb-3 sm:mb-4 group-hover:scale-110 transition-transform">
                                            <i class="fa-solid fa-shield-heart text-white text-xl sm:text-2xl"></i>
                                        </div>
                                        <h3 class="font-bold text-sm sm:text-base text-gray-800 dark:text-white mb-1">{{ __('Quality') }}</h3>
                                        <p class="text-xs text-gray-600 dark:text-gray-300">{{ __('Certified Products') }}</p>
                                    </div>
                                    <div class="group bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 p-4 sm:p-6 rounded-2xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 animation-delay-100">
                                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-purple-500 rounded-2xl flex items-center justify-center mb-3 sm:mb-4 group-hover:scale-110 transition-transform">
                                            <i class="fa-solid fa-rocket text-white text-xl sm:text-2xl"></i>
                                        </div>
                                        <h3 class="font-bold text-sm sm:text-base text-gray-800 dark:text-white mb-1">{{ __('Fast') }}</h3>
                                        <p class="text-xs text-gray-600 dark:text-gray-300">{{ __('Same Day Delivery') }}</p>
                                    </div>
                                    <div class="group bg-gradient-to-br from-pink-50 to-pink-100 dark:from-pink-900 dark:to-pink-800 p-4 sm:p-6 rounded-2xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 animation-delay-200">
                                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-pink-500 rounded-2xl flex items-center justify-center mb-3 sm:mb-4 group-hover:scale-110 transition-transform">
                                            <i class="fa-solid fa-percent text-white text-xl sm:text-2xl"></i>
                                        </div>
                                        <h3 class="font-bold text-sm sm:text-base text-gray-800 dark:text-white mb-1">{{ __('Offers') }}</h3>
                                        <p class="text-xs text-gray-600 dark:text-gray-300">{{ __('Up to 50% Off') }}</p>
                                    </div>
                                    <div class="group bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 p-4 sm:p-6 rounded-2xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 animation-delay-300">
                                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-green-500 rounded-2xl flex items-center justify-center mb-3 sm:mb-4 group-hover:scale-110 transition-transform">
                                            <i class="fa-solid fa-headset text-white text-xl sm:text-2xl"></i>
                                        </div>
                                        <h3 class="font-bold text-sm sm:text-base text-gray-800 dark:text-white mb-1">{{ __('Support') }}</h3>
                                        <p class="text-xs text-gray-600 dark:text-gray-300">{{ __('24/7 Available') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Floating Elements -->
                    <div class="absolute -top-4 -right-4 w-20 h-20 bg-yellow-400 rounded-full animate-bounce opacity-80 hidden sm:block"></div>
                    <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-blue-400 rounded-full animate-pulse opacity-80 hidden sm:block"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Section with Modern Design -->
    <div id="products" class="py-12 sm:py-16 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 sm:mb-12 fade-in-up">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
                    {{ __('Our') }}
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600">
                        {{ __('Products') }}
                    </span>
                </h2>
                <p class="text-base sm:text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    {{ __('Discover our premium collection of health and wellness products') }}
                </p>
                <div class="mt-6 h-1 w-24 bg-gradient-to-r from-blue-600 to-purple-600 mx-auto rounded-full"></div>
            </div>

            @if (isset($products) && $products->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-6">
                    @foreach ($products as $index => $item)
                        <div class="product-card fade-in-up" style="animation-delay: {{ $index * 100 }}ms;">
                            <x-product-card1 :product="$item" />
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-10 sm:mt-12">
                    <a href="{{ route('web.products') }}"
                        class="group inline-flex items-center gap-3 px-8 py-4 text-lg font-bold text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-full shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                        {{ __('View All Products') }}
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-2 transition-transform duration-300"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-12 sm:py-16 fade-in-up">
                    <div class="inline-block p-6 bg-gradient-to-br from-blue-50 to-purple-50 dark:from-blue-900 dark:to-purple-900 rounded-3xl mb-6">
                        <i class="fa-solid fa-box-open text-6xl sm:text-7xl text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white mb-3">
                        {{ __('No products available for your country') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-8 text-lg">
                        {{ __('Check back soon for exciting new products!') }}
                    </p>
                    <a href="{{ route('web.products') }}"
                        class="inline-flex items-center gap-2 px-8 py-4 text-lg font-bold text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-full shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                        {{ __('Browse all products') }}
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Blog Section with Modern Design -->
    <div class="py-12 sm:py-16 bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-blue-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 sm:mb-12 fade-in-up">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
                    {{ __('Latest') }}
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600">
                        {{ __('Articles') }}
                    </span>
                </h2>
                <p class="text-base sm:text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    {{ __('Stay updated with the latest health tips and wellness insights') }}
                </p>
                <div class="mt-6 h-1 w-24 bg-gradient-to-r from-blue-600 to-purple-600 mx-auto rounded-full"></div>
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
                                <div class="w-full h-full bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 flex items-center justify-center">
                                    <div class="text-white text-center">
                                        <i class="fa-solid fa-newspaper text-4xl sm:text-5xl mb-3 opacity-80"></i>
                                        <p class="text-sm font-medium">{{ $post->category->name }}</p>
                                    </div>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white dark:bg-gray-800 text-gray-800 dark:text-white shadow-lg backdrop-blur-sm">
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
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-3 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">
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

            <div class="text-center mt-10 sm:mt-12">
                <a href="{{ route('blog.index') }}"
                    class="group inline-flex items-center gap-3 px-8 py-4 text-lg font-bold text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-full shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                    {{ __('View All Articles') }}
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-2 transition-transform duration-300"></i>
                </a>
            </div>
        @else
            <div class="text-center py-12 sm:py-16 fade-in-up">
                <div class="inline-block p-8 bg-white dark:bg-gray-800 rounded-3xl shadow-xl mb-6">
                    <i class="fa-solid fa-newspaper text-6xl sm:text-7xl text-gray-400"></i>
                </div>
                <h3 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white mb-3">
                    {{ __('No Articles Yet') }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-8 text-lg">
                    {{ __('No articles available for your region') }}
                </p>
                <a href="{{ route('blog.index') }}"
                    class="inline-flex items-center gap-2 px-8 py-4 text-lg font-bold text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-full shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                    {{ __('View All Articles') }}
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        @endif
        </div>
    </div>

    <!-- Features Section with Modern Design -->
    <div class="py-12 sm:py-16 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 fade-in-up">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
                    {{ __('Why Choose') }}
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600">
                        {{ __('Al Shaafi?') }}
                    </span>
                </h2>
                <p class="text-base sm:text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    {{ __('We provide the best shopping experience with premium quality and service') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                <!-- Feature 1 -->
                <div class="group relative bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900 dark:to-orange-800 rounded-2xl p-6 sm:p-8 transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-500 fade-in-up">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-orange-400 rounded-full opacity-20 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-xl">
                            <i class="fa-solid fa-bullhorn text-white text-2xl sm:text-3xl"></i>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-3">{{ __('Special Offers') }}</h3>
                        <p class="text-gray-600 dark:text-gray-300">{{ __('Exclusive deals and discounts up to 50% off on selected products') }}</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="group relative bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-2xl p-6 sm:p-8 transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-500 fade-in-up animation-delay-100">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-400 rounded-full opacity-20 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-xl">
                            <i class="fa-solid fa-shipping-fast text-white text-2xl sm:text-3xl"></i>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-3">{{ __('Fast Delivery') }}</h3>
                        <p class="text-gray-600 dark:text-gray-300">{{ __('Same-day delivery available for urgent orders in major cities') }}</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="group relative bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 rounded-2xl p-6 sm:p-8 transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-500 fade-in-up animation-delay-200">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-green-400 rounded-full opacity-20 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-xl">
                            <i class="fa-solid fa-heart text-white text-2xl sm:text-3xl"></i>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-3">{{ __('Trusted Quality') }}</h3>
                        <p class="text-gray-600 dark:text-gray-300">{{ __('100% authentic products certified by health authorities') }}</p>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="group relative bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-2xl p-6 sm:p-8 transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-500 fade-in-up animation-delay-300">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-purple-400 rounded-full opacity-20 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-xl">
                            <i class="fa-solid fa-headset text-white text-2xl sm:text-3xl"></i>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-3">{{ __('24/7 Support') }}</h3>
                        <p class="text-gray-600 dark:text-gray-300">{{ __('Our dedicated team is always ready to assist you anytime') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Reviews Section with Modern Carousel -->
    <div class="py-12 sm:py-16 bg-gradient-to-br from-gray-50 to-purple-50 dark:from-gray-900 dark:to-purple-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 fade-in-up">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
                    {{ __('Customer') }}
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600">
                        {{ __('Reviews') }}
                    </span>
                </h2>
                <p class="text-base sm:text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    {{ __('See what our customers say about their experience with us') }}
                </p>
                <div class="mt-6 h-1 w-24 bg-gradient-to-r from-blue-600 to-purple-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
                @foreach (range(1, 5) as $index => $item)
                    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-500 fade-in-up"
                        style="animation-delay: {{ $index * 100 }}ms;">
                        <!-- User Avatar and Info -->
                        <div class="flex items-center mb-6">
                            <div class="relative">
                                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    {{ substr('User Name ' . $item, 0, 2) }}
                                </div>
                                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full"></div>
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
                            <span class="ml-2 text-sm font-bold text-gray-900 dark:text-white">{{ 6 - $item }}.0</span>
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
                <button class="group inline-flex items-center gap-3 px-8 py-4 text-lg font-bold text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-full shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                    {{ __('View All Reviews') }}
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-2 transition-transform duration-300"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Newsletter Section -->
    <div class="py-12 sm:py-16 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 relative overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full opacity-10 -translate-x-1/2 -translate-y-1/2 animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full opacity-10 translate-x-1/2 translate-y-1/2 animate-pulse animation-delay-2000"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center fade-in-up">
                <div class="inline-block p-4 bg-white/20 backdrop-blur-sm rounded-2xl mb-6">
                    <i class="fa-solid fa-envelope text-5xl sm:text-6xl text-white"></i>
                </div>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white mb-4">
                    {{ __('Stay Updated!') }}
                </h2>
                <p class="text-lg sm:text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                    {{ __('Subscribe to our newsletter and get exclusive offers, health tips, and product updates') }}
                </p>
                
                <form class="max-w-md mx-auto">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input type="email"
                            placeholder="{{ __('Enter your email') }}"
                            class="flex-1 px-6 py-4 rounded-full text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-4 focus:ring-white/50 text-base sm:text-lg shadow-lg">
                        <button type="submit"
                            class="px-8 py-4 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            {{ __('Subscribe') }}
                        </button>
                    </div>
                    <p class="text-sm text-white/80 mt-4">
                        {{ __('🔒 We respect your privacy. Unsubscribe anytime.') }}
                    </p>
                </form>
            </div>
        </div>
    </div>

    <!-- Floating Action Button -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col gap-3">
        <a href="#"
            class="w-14 h-14 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full shadow-2xl flex items-center justify-center text-white hover:scale-110 transition-transform duration-300 animate-bounce">
            <i class="fa-solid fa-arrow-up text-xl"></i>
        </a>
        <a href="https://wa.me/1234567890"
            class="w-14 h-14 bg-green-500 rounded-full shadow-2xl flex items-center justify-center text-white hover:scale-110 transition-transform duration-300">
            <i class="fa-brands fa-whatsapp text-2xl"></i>
        </a>
    </div>
@endsection


@section('jsscript')
    <style>
        /* Custom Animations */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
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
            background: linear-gradient(to bottom, #3b82f6, #9333ea);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #2563eb, #7c3aed);
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
            }, { threshold: 0.5 });

            document.querySelectorAll('.counter-item').forEach(item => {
                counterObserver.observe(item);
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
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
