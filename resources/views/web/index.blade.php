@extends('layouts.guest')
@section('content')
    <!-- Hero Section -->
    <div class="p-2 sm:p-4 bg-white dark:bg-gray-900">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-2 sm:gap-4">
            <!-- Main Hero Banner -->
            <div class="lg:col-span-2 lg:row-span-2">
                <div
                    class="bg-gradient-to-r from-blue-500 to-purple-600 dark:from-blue-600 dark:to-purple-700 h-48 sm:h-64 lg:h-96 rounded-lg flex items-center justify-center text-white">
                    <div class="text-center p-4 sm:p-6">
                        <h1 class="text-xl sm:text-2xl lg:text-4xl font-bold mb-2 sm:mb-4">{{ __('Welcome to Al Shaafi') }}
                        </h1>
                        <p class="text-sm sm:text-base lg:text-lg opacity-90 mb-4 sm:mb-6">
                            {{ __('Your trusted health and wellness partner') }}</p>
                        <a href="{{ route('web.products') }}"
                            class="bg-white text-blue-600 px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors text-sm sm:text-base">
                            {{ __('Shop Now') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Side Banners -->
            <div class="grid grid-cols-2 lg:grid-cols-1 gap-2 sm:gap-4">
                <div
                    class="bg-gradient-to-br from-red-400 to-pink-500 dark:from-red-500 dark:to-pink-600 h-24 sm:h-32 lg:h-44 rounded-lg flex items-center justify-center text-white">
                    <div class="text-center p-2 sm:p-4">
                        <h3 class="text-sm sm:text-base lg:text-lg font-semibold mb-1 sm:mb-2">{{ __('Special Offers') }}
                        </h3>
                        <p class="text-xs sm:text-sm opacity-90">{{ __('Up to 50% off') }}</p>
                    </div>
                </div>
                <div
                    class="bg-gradient-to-br from-green-400 to-blue-500 dark:from-green-500 dark:to-blue-600 h-24 sm:h-32 lg:h-44 rounded-lg flex items-center justify-center text-white">
                    <div class="text-center p-2 sm:p-4">
                        <h3 class="text-sm sm:text-base lg:text-lg font-semibold mb-1 sm:mb-2">{{ __('Fast Delivery') }}
                        </h3>
                        <p class="text-xs sm:text-sm opacity-90">{{ __('Same day delivery') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div class="p-2 sm:p-4 bg-slate-100 dark:bg-gray-800">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg sm:text-xl font-light text-gray-900 dark:text-gray-100">{{ __('Our Products') }}</h2>
            <a href="{{ route('web.products') }}"
                class="text-sm sm:text-base font-light text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">{{ __('View All') }}</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2 sm:gap-4">
            @if (isset($products) && $products->count() > 0)
                @foreach ($products as $item)
                    <x-product-card1 :product="$item" />
                @endforeach
            @else
                <div class="col-span-2 sm:col-span-3 md:col-span-4 lg:col-span-5 text-center py-8">
                    <p class="text-gray-500 dark:text-gray-400 mb-2">{{ __('No products available for your country') }}</p>
                    <a href="{{ route('web.products') }}"
                        class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Browse all products') }}</a>
                </div>
            @endif
        </div>
    </div>

    <!-- Blog Section -->
    <div class="p-2 sm:p-4 bg-white dark:bg-gray-900">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg sm:text-xl font-light text-gray-900 dark:text-gray-100">{{ __('Latest Articles') }}</h2>
            <a href="{{ route('blog.index') }}"
                class="text-sm sm:text-base font-light text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">{{ __('View All') }}</a>
        </div>

        @if (isset($blogPosts) && $blogPosts->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
                @foreach ($blogPosts as $post)
                    <article
                        class="bg-gray-50 dark:bg-gray-800 rounded-lg overflow-hidden hover:shadow-md dark:hover:shadow-lg dark:hover:shadow-gray-900/50 transition-shadow border border-gray-200 dark:border-gray-700">
                        <!-- Post Image -->
                        <div
                            class="h-24 sm:h-32 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                            @if ($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="text-white text-center">
                                    <i class="fa-solid fa-newspaper text-lg sm:text-2xl mb-1"></i>
                                    <p class="text-xs">{{ $post->category->name }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Post Content -->
                        <div class="p-3 sm:p-4">
                            <!-- Category and Date -->
                            <div class="flex items-center justify-between mb-2">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                    {{ $post->category->name }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $post->created_at->format('M d') }}
                                </span>
                            </div>

                            <!-- Title -->
                            <h3 class="text-sm font-medium text-gray-800 dark:text-gray-200 mb-2 line-clamp-2">
                                <a href="{{ route('blog.post', $post->slug) }}"
                                    class="hover:text-blue-600 dark:hover:text-blue-400 transition">
                                    {{ $post->title }}
                                </a>
                            </h3>

                            <!-- Excerpt -->
                            <p class="text-gray-600 dark:text-gray-400 text-xs mb-3 line-clamp-2">
                                {{ Str::limit(strip_tags($post->content), 60) }}
                            </p>

                            <!-- Read More -->
                            <a href="{{ route('blog.post', $post->slug) }}"
                                class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 text-xs font-medium transition">
                                {{ __('Read More') }}
                                <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 sm:py-12">
                <div class="text-gray-400 text-4xl sm:text-6xl mb-4">📰</div>
                <h3 class="text-lg sm:text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('No Articles Yet') }}</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">{{ __('No articles available for your region') }}</p>
                <a href="{{ route('blog.index') }}"
                    class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-medium transition-colors text-sm sm:text-base">
                    {{ __('View All Articles') }}
                </a>
            </div>
        @endif
    </div>

    <!-- Advertisement Section -->
    <div class="mt-3 p-2 sm:p-4 bg-white dark:bg-gray-900">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-gradient-to-br from-orange-200 to-orange-300 dark:from-orange-500 dark:to-orange-600 rounded-lg">
                <div class="flex items-center justify-center h-32 sm:h-48 text-gray-800 dark:text-gray-200">
                    <div class="text-center">
                        <i class="fa-solid fa-bullhorn text-2xl sm:text-3xl mb-2"></i>
                        <p class="text-sm sm:text-base font-medium">{{ __('Special Offers') }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-blue-200 to-blue-300 dark:from-blue-500 dark:to-blue-600 rounded-lg">
                <div class="flex items-center justify-center h-32 sm:h-48 text-gray-800 dark:text-gray-200">
                    <div class="text-center">
                        <i class="fa-solid fa-shipping-fast text-2xl sm:text-3xl mb-2"></i>
                        <p class="text-sm sm:text-base font-medium">{{ __('Fast Delivery') }}</p>
                    </div>
                </div>
            </div>
            <div
                class="bg-gradient-to-br from-green-200 to-green-300 dark:from-green-500 dark:to-green-600 rounded-lg sm:col-span-2 lg:col-span-1">
                <div class="flex items-center justify-center h-32 sm:h-48 text-gray-800 dark:text-gray-200">
                    <div class="text-center">
                        <i class="fa-solid fa-heart text-2xl sm:text-3xl mb-2"></i>
                        <p class="text-sm sm:text-base font-medium">{{ __('Trusted Quality') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- reviews section --}}
    <div class="p-2 sm:p-4 bg-slate-100 dark:bg-gray-800">
        <div class="mb-4 text-center">
            <h2 class="text-lg sm:text-xl font-light text-gray-900 dark:text-gray-100">{{ __('Customer Reviews') }}</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('What our customers say about us') }}</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4">
            @foreach (range(1, 5) as $item)
                <div
                    class="bg-white dark:bg-gray-700 p-3 sm:p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                    <div class="flex flex-col h-full">
                        <div class="flex items-center mb-3">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                U{{ $item }}
                            </div>
                            <div class="ml-2 sm:ml-3 flex-1 min-w-0 mx-2">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">User Name
                                    {{ $item }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ now()->subDays(rand(1, 30))->format('M d, Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex-1 mb-3">
                            <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 line-clamp-4">
                                @php
                                    $reviews = [
                                        'Excellent quality products and fast delivery! Highly recommend.',
                                        'Great customer service and affordable prices. Will shop again.',
                                        'Amazing experience! The products exceeded my expectations.',
                                        'Fast shipping and authentic products. Very satisfied!',
                                        'Outstanding service and quality. Best online shopping experience.',
                                    ];
                                @endphp
                                {{ $reviews[$item - 1] }}
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-yellow-400 text-sm">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= 6 - $item)
                                        <i class="fa-solid fa-star"></i>
                                    @else
                                        <i class="fa-regular fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                                {{ 6 - $item }}.0
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- View All Reviews Button -->
        <div class="text-center mt-6">
            <button
                class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-medium transition-colors text-sm sm:text-base">
                {{ __('View All Reviews') }}
            </button>
        </div>
    </div>
@endsection

@section('jsscript')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup CSRF token for AJAX requests
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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
                notification.className = `cart-notification fixed top-4 right-4 z-50 px-6 py-3 rounded shadow-lg text-white font-medium transition-all duration-300 ${
            type === 'success' ? 'bg-green-500' : 
            type === 'error' ? 'bg-red-500' : 'bg-blue-500'
        }`;
                notification.textContent = message;
                document.body.appendChild(notification);
                setTimeout(() => {
                    notification.style.opacity = '0';
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }

            function updateCartCount(count) {
                const cartCountElements = document.querySelectorAll('.cart-count');
                cartCountElements.forEach(element => {
                    element.textContent = count;
                    element.style.display = count > 0 ? 'flex' : 'none';
                });
            }
        });
    </script>
@endsection
