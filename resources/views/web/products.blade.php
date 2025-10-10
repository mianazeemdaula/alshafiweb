@extends('layouts.guest')
@section('content')
    <!-- Modern Header Bar with Gradient -->
    <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <!-- Page Title & Stats -->
                <div class="text-white">
                    <h1 class="text-2xl sm:text-3xl font-bold mb-2 flex items-center gap-3">
                        <i class="fa fa-store"></i>
                        {{ __('Our Products') }}
                    </h1>
                    <p class="text-white/90 text-sm">
                        {{ __('showing_entries', [
                            'first' => $products->firstItem() ?? 0,
                            'last' => $products->lastItem() ?? 0,
                            'total' => $products->total(),
                        ]) }}
                    </p>
                </div>

                <!-- Sort Dropdown with Modern Style -->
                <div class="w-full sm:w-auto">
                    <form action="{{ route('web.products') }}" method="get" class="flex items-center gap-3">
                        {{-- Preserve existing filters --}}
                        @foreach (collect(request()->query())->except(['sort', 'order']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach

                        <label class="text-white text-sm font-medium hidden sm:block">
                            <i class="fa fa-sort mr-1"></i>{{ __('sort_by') }}
                        </label>
                        <select name="sort"
                            class="px-4 py-2.5 rounded-xl bg-white/20 backdrop-blur-sm text-white font-medium border-2 border-white/30 focus:border-white focus:ring-4 focus:ring-white/20 transition-all cursor-pointer w-full sm:w-48"
                            onchange="this.form.submit()">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}
                                class="text-gray-900">{{ __('Newest') }}</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}
                                class="text-gray-900">
                                {{ __('Price: Low to High') }}</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}
                                class="text-gray-900">
                                {{ __('Price: High to Low') }}</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }} class="text-gray-900">
                                {{ __('name') }}</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}
                                class="text-gray-900">{{ __('rating') }}
                            </option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container with 30/70 Layout -->
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="container mx-auto px-4 py-6">

            <!-- Mobile Filter Button -->
            <div class="lg:hidden mb-4">
                <button id="mobile-filter-toggle"
                    class="flex items-center justify-between w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-medium shadow-lg hover:shadow-xl transition-all transform hover:scale-[1.02]">
                    <span class="flex items-center gap-2">
                        <i class="fa fa-sliders-h"></i>
                        {{ __('Filters & Categories') }}
                    </span>
                    <i class="fa fa-chevron-down transition-transform duration-300 filter-toggle-icon"></i>
                </button>
            </div>

            <!-- 30/70 Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- LEFT SIDEBAR - 30% on Desktop (4 columns out of 12) -->
                <aside id="filter-sidebar" class="lg:col-span-4 xl:col-span-3 hidden lg:block">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg sticky top-4 overflow-hidden">

                        <!-- Filter Header -->
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-4 py-4">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                    <i class="fa fa-filter"></i>
                                    {{ __('Filters') }}
                                </h2>
                                @if (request('min') || request('max') || request('rating') || request('category'))
                                    <a href="{{ route('web.products') }}"
                                        class="text-xs text-white/90 hover:text-white font-medium flex items-center gap-1 hover:gap-2 transition-all">
                                        <i class="fa fa-times-circle"></i> {{ __('Clear') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Scrollable Filter Content -->
                        <div class="max-h-[calc(100vh-180px)] overflow-y-auto p-4 space-y-4 custom-scrollbar">

                            {{-- Price Range Filter --}}
                            <div
                                class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-700 dark:to-gray-800 rounded-xl p-4 shadow-sm border border-blue-100 dark:border-gray-600">
                                <h3
                                    class="font-semibold text-sm text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                                        <i class="fa fa-dollar-sign text-white text-xs"></i>
                                    </div>
                                    {{ __('Price Range') }}
                                </h3>
                                <form action="{{ route('web.products') }}" method="get" class="space-y-3">
                                    {{-- Preserve other filters --}}
                                    @foreach (collect(request()->query())->except(['min', 'max']) as $key => $value)
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                    @endforeach

                                    <!-- Price Input Fields - Responsive Stack on Mobile -->
                                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                        <div class="flex-1">
                                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                                {{ __('Min Price') }}
                                            </label>
                                            <input type="number" name="min"
                                                class="w-full rounded-lg px-3 py-2.5 text-sm bg-white dark:bg-gray-700 dark:text-white border-2 border-gray-200 dark:border-gray-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-all"
                                                min="0" placeholder="0" value="{{ request('min') }}">
                                        </div>
                                        <span
                                            class="hidden sm:block text-gray-500 dark:text-gray-400 font-bold self-end pb-2.5">—</span>
                                        <div class="flex-1">
                                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                                {{ __('Max Price') }}
                                            </label>
                                            <input type="number" name="max"
                                                class="w-full rounded-lg px-3 py-2.5 text-sm bg-white dark:bg-gray-700 dark:text-white border-2 border-gray-200 dark:border-gray-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-all"
                                                min="0" placeholder="∞" value="{{ request('max') }}">
                                        </div>
                                    </div>

                                    <button type="submit"
                                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-4 py-2.5 rounded-lg font-medium transition-all transform hover:scale-[1.02] shadow-md hover:shadow-lg">
                                        <i class="fa fa-check mr-2"></i>{{ __('Apply') }}
                                    </button>

                                    {{-- Clear price filter --}}
                                    @if (request('min') || request('max'))
                                        <a href="{{ request()->fullUrlWithQuery(['min' => null, 'max' => null]) }}"
                                            class="block text-center text-xs text-red-600 dark:text-red-400 hover:underline font-medium">
                                            <i class="fa fa-times-circle mr-1"></i>{{ __('Clear Price Filter') }}
                                        </a>
                                    @endif
                                </form>
                            </div>

                            {{-- Rating Filter --}}
                            <div
                                class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-gray-700 dark:to-gray-800 rounded-xl p-4 shadow-sm border border-yellow-100 dark:border-gray-600">
                                <h3
                                    class="font-semibold text-sm text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center">
                                        <i class="fa fa-star text-white text-xs"></i>
                                    </div>
                                    {{ __('Customer Rating') }}
                                </h3>
                                <div class="space-y-2">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <a href="{{ request()->fullUrlWithQuery(['rating' => $i]) }}"
                                            class="flex items-center justify-between px-3 py-2.5 rounded-lg border-2 transition-all transform hover:scale-[1.02] {{ request('rating') == $i
                                                ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white border-blue-600 shadow-lg'
                                                : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-600 hover:border-blue-400 dark:hover:border-blue-500' }}">
                                            <div class="flex items-center gap-1">
                                                @for ($j = 1; $j <= 5; $j++)
                                                    <i
                                                        class="fa-solid fa-star text-xs {{ $i >= $j ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-500' }}"></i>
                                                @endfor
                                            </div>
                                            <span class="text-xs font-bold">{{ $i }}+</span>
                                        </a>
                                    @endfor
                                </div>

                                {{-- Clear rating filter --}}
                                @if (request('rating'))
                                    <a href="{{ request()->fullUrlWithQuery(['rating' => null]) }}"
                                        class="block text-center text-xs text-red-600 dark:text-red-400 hover:underline font-medium mt-3">
                                        <i class="fa fa-times-circle mr-1"></i>{{ __('Clear Rating') }}
                                    </a>
                                @endif
                            </div>

                            {{-- Categories Filter --}}
                            <div
                                class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-gray-700 dark:to-gray-800 rounded-xl p-4 shadow-sm border border-purple-100 dark:border-gray-600">
                                <h3
                                    class="font-semibold text-sm text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg flex items-center justify-center">
                                        <i class="fa fa-th-large text-white text-xs"></i>
                                    </div>
                                    {{ __('Categories') }}
                                </h3>
                                <div class="space-y-2">
                                    {{-- All categories option --}}
                                    <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}"
                                        class="block px-3 py-2.5 rounded-lg border-2 transition-all font-medium text-sm transform hover:scale-[1.02] {{ !request('category')
                                            ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white border-blue-600 shadow-lg'
                                            : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-600 hover:border-purple-400 dark:hover:border-purple-500' }}">
                                        <i class="fa fa-list mr-2"></i>{{ __('All Categories') }}
                                    </a>

                                    @if (isset($categories))
                                        @foreach ($categories as $item)
                                            <a href="{{ request()->fullUrlWithQuery(['category' => $item->slug]) }}"
                                                class="block px-3 py-2.5 rounded-lg border-2 transition-all text-sm transform hover:scale-[1.02] {{ request('category') == $item->slug
                                                    ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white border-blue-600 shadow-lg font-bold'
                                                    : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-600 hover:border-purple-400 dark:hover:border-purple-500' }}">
                                                <i class="fa fa-tag mr-2 text-xs"></i>{{ $item->name }}
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- RIGHT CONTENT - 70% on Desktop (8 columns out of 12) -->
                <main class="lg:col-span-8 xl:col-span-9">

                    <!-- Active Filters Display -->
                    @if (request('category') || request('min') || request('max') || request('rating'))
                        <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl p-4 shadow-md">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <i class="fa fa-filter mr-1"></i>Active Filters:
                                </span>

                                @if (request('category'))
                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-purple-100 to-pink-100 dark:from-purple-900 dark:to-pink-900 text-purple-700 dark:text-purple-300 rounded-lg text-xs font-medium">
                                        <i class="fa fa-tag"></i>
                                        {{ $categories->where('slug', request('category'))->first()->name ?? request('category') }}
                                        <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}"
                                            class="hover:text-red-600">
                                            <i class="fa fa-times-circle"></i>
                                        </a>
                                    </span>
                                @endif

                                @if (request('min') || request('max'))
                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900 dark:to-purple-900 text-blue-700 dark:text-blue-300 rounded-lg text-xs font-medium">
                                        <i class="fa fa-dollar-sign"></i>
                                        {{ request('min') ?? '0' }} - {{ request('max') ?? '∞' }}
                                        <a href="{{ request()->fullUrlWithQuery(['min' => null, 'max' => null]) }}"
                                            class="hover:text-red-600">
                                            <i class="fa fa-times-circle"></i>
                                        </a>
                                    </span>
                                @endif

                                @if (request('rating'))
                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-yellow-100 to-orange-100 dark:from-yellow-900 dark:to-orange-900 text-yellow-700 dark:text-yellow-300 rounded-lg text-xs font-medium">
                                        <i class="fa fa-star"></i>
                                        {{ request('rating') }}+ Stars
                                        <a href="{{ request()->fullUrlWithQuery(['rating' => null]) }}"
                                            class="hover:text-red-600">
                                            <i class="fa fa-times-circle"></i>
                                        </a>
                                    </span>
                                @endif

                                <a href="{{ route('web.products') }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-lg text-xs font-bold hover:bg-red-200 dark:hover:bg-red-800 transition-all">
                                    <i class="fa fa-times-circle"></i> Clear All
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Products Grid - Responsive -->
                    @if ($products->count() > 0)
                        <div
                            class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 md:gap-5 lg:gap-6">
                            @foreach ($products as $product)
                                <div class="product-card-wrapper">
                                    <x-product-card1 :product="$product" />
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl p-4 shadow-md">
                            <div class="text-gray-700 dark:text-gray-300">
                                {{ $products->links() }}
                            </div>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl shadow-lg">
                            <div class="mb-6">
                                <div
                                    class="w-24 h-24 mx-auto bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900 dark:to-purple-900 rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-box-open text-5xl text-gray-400 dark:text-gray-500"></i>
                                </div>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">
                                {{ __('No Products Found') }}</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-6">
                                {{ __('No products match your current filters.') }}
                            </p>
                            <a href="{{ route('web.products') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-xl font-medium transition-all transform hover:scale-105 shadow-lg">
                                <i class="fa fa-redo"></i> Clear Filters & Show All
                            </a>
                        </div>
                    @endif
                </main>
            </div>
        </div>
    </div>
@endsection

@section('jsscript')
    <style>
        /* Custom Scrollbar for Filter Sidebar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #3b82f6, #8b5cf6);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #2563eb, #7c3aed);
        }

        /* Mobile Filter Sidebar Animation */
        #filter-sidebar {
            transition: all 0.3s ease-in-out;
        }

        @media (max-width: 1023px) {
            #filter-sidebar {
                max-height: 0;
                overflow: hidden;
            }

            #filter-sidebar:not(.hidden) {
                max-height: 2000px;
            }
        }

        /* Product Card Animation */
        .product-card-wrapper {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease;
        }

        .product-card-wrapper.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup CSRF token for AJAX requests
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // Restrict negative price input for min/max fields
            document.querySelectorAll('input[type="number"]').forEach(function(input) {
                input.addEventListener('input', function() {
                    if (parseInt(this.value) < 0) this.value = 0;
                });
            });

            // Handle quantity buttons
            document.addEventListener('click', function(e) {
                let button = e.target.closest('.quantity-btn');

                if (button) {
                    const action = button.getAttribute('data-action');
                    const productCard = button.getAttribute('data-product-card');
                    const quantityInput = document.querySelector(
                        `input.quantity-input[data-product-card="${productCard}"]`);

                    if (quantityInput) {
                        let currentValue = parseInt(quantityInput.value) || 1;

                        if (action === 'plus' && currentValue < 10) {
                            quantityInput.value = currentValue + 1;
                        } else if (action === 'minus' && currentValue > 1) {
                            quantityInput.value = currentValue - 1;
                        }
                    }
                }
            });

            // Handle add to cart buttons
            document.addEventListener('click', function(e) {
                let button = e.target.closest('.add-to-cart-btn');

                if (button && !button.disabled && csrfToken) {
                    const productId = button.getAttribute('data-product-id');
                    const productName = button.getAttribute('data-product-name');
                    const quantityInput = document.querySelector(
                        `input.quantity-input[data-product-card="${productId}"]`);
                    const quantity = parseInt(quantityInput?.value) || 1;

                    // Store original button content
                    const originalContent = button.innerHTML;

                    // Disable button during request and show loading state
                    button.disabled = true;
                    button.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-sm"></i>';

                    // Make AJAX request to add to cart
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
                                if (quantityInput) quantityInput.value = 1;
                            } else {
                                showNotification('Error: ' + (data.message || 'Unable to add to cart'),
                                    'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('Error adding product to cart', 'error');
                        })
                        .finally(() => {
                            button.disabled = false;
                            button.innerHTML = originalContent;
                        });
                }
            });

            // Enhanced notification function
            function showNotification(message, type = 'info') {
                const existingNotifications = document.querySelectorAll('.cart-notification');
                existingNotifications.forEach(n => n.remove());

                const notification = document.createElement('div');
                let bgClass = '';
                let iconClass = '';

                if (type === 'success') {
                    bgClass = 'bg-gradient-to-r from-green-500 to-emerald-500';
                    iconClass = 'fa-check-circle';
                } else if (type === 'error') {
                    bgClass = 'bg-gradient-to-r from-red-500 to-pink-500';
                    iconClass = 'fa-exclamation-circle';
                } else {
                    bgClass = 'bg-gradient-to-r from-blue-500 to-purple-500';
                    iconClass = 'fa-info-circle';
                }

                notification.className =
                    `cart-notification fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-2xl text-white font-medium transition-all duration-300 transform ${bgClass}`;
                notification.innerHTML = `
                    <div class="flex items-center gap-3">
                        <i class="fa ${iconClass} text-2xl"></i>
                        <span>${message}</span>
                    </div>
                `;

                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.style.transform = 'translateX(0)';
                }, 10);

                setTimeout(() => {
                    notification.style.opacity = '0';
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }

            // Update cart count in header
            function updateCartCount(count) {
                const cartCountElements = document.querySelectorAll('.cart-count');
                cartCountElements.forEach(element => {
                    element.textContent = count;
                    element.style.display = count > 0 ? 'flex' : 'none';
                });
            }

            // Mobile filter toggle
            const mobileFilterToggle = document.getElementById('mobile-filter-toggle');
            const filterSidebar = document.getElementById('filter-sidebar');
            const filterToggleIcon = document.querySelector('.filter-toggle-icon');

            if (mobileFilterToggle && filterSidebar) {
                mobileFilterToggle.addEventListener('click', function() {
                    filterSidebar.classList.toggle('hidden');

                    if (filterSidebar.classList.contains('hidden')) {
                        filterToggleIcon.style.transform = 'rotate(0deg)';
                    } else {
                        filterToggleIcon.style.transform = 'rotate(180deg)';
                    }
                });
            }

            // Intersection Observer for product card animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, observerOptions);

            // Observe all product cards with staggered animation
            document.querySelectorAll('.product-card-wrapper').forEach((card, index) => {
                card.style.transitionDelay = `${index * 0.05}s`;
                observer.observe(card);
            });
        });
    </script>
@endsection
