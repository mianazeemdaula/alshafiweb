@extends('layouts.guest')
@section('content')
    <!-- Page Header -->
    <div class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-400">{{ __('Shop') }}</span>
                    <h1 class="mt-2 text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                        {{ __('Our Products') }}
                    </h1>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('showing_entries', [
                            'first' => $products->firstItem() ?? 0,
                            'last' => $products->lastItem() ?? 0,
                            'total' => $products->total(),
                        ]) }}
                    </p>
                </div>

                <!-- Sort Dropdown -->
                <div class="w-full sm:w-auto">
                    <form action="{{ route('web.products') }}" method="get" class="flex items-center gap-3">
                        @foreach (collect(request()->query())->except(['sort', 'order']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach

                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400 hidden sm:block">
                            {{ __('sort_by') }}
                        </label>
                        <select name="sort"
                            class="px-4 py-2.5 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm font-medium border border-gray-200 dark:border-gray-700 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 dark:focus:ring-emerald-900/50 transition-colors cursor-pointer w-full sm:w-52"
                            onchange="this.form.submit()">
                            <option value="default" {{ in_array(request('sort'), [null, '', 'default']) ? 'selected' : '' }}>{{ __('Default') }}</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('Newest') }}</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>{{ __('Price: Low to High') }}</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>{{ __('Price: High to Low') }}</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>{{ __('name') }}</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>{{ __('rating') }}</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="bg-white dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Mobile Filter Button -->
            <div class="lg:hidden mb-4">
                <button id="mobile-filter-toggle"
                    class="flex items-center justify-between w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-100 rounded-xl text-sm font-medium hover:border-emerald-400 transition-colors">
                    <span class="flex items-center gap-2">
                        <i class="fa fa-sliders-h text-emerald-600 dark:text-emerald-400"></i>
                        {{ __('Filters & Categories') }}
                    </span>
                    <i class="fa fa-chevron-down transition-transform duration-300 filter-toggle-icon text-gray-400"></i>
                </button>
            </div>

            <!-- Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- LEFT SIDEBAR -->
                <aside id="filter-sidebar" class="lg:col-span-4 xl:col-span-3 hidden lg:block">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 sticky top-4 overflow-hidden">

                        <!-- Filter Header -->
                        <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h2 class="text-sm font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                    <i class="fa fa-filter text-emerald-600 dark:text-emerald-400"></i>
                                    {{ __('Filters') }}
                                </h2>
                                @if (request('min') || request('max') || request('rating') || request('category'))
                                    <a href="{{ route('web.products') }}"
                                        class="text-xs text-emerald-600 dark:text-emerald-400 hover:underline font-medium flex items-center gap-1">
                                        <i class="fa fa-times-circle"></i> {{ __('Clear') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Scrollable Filter Content -->
                        <div class="max-h-[calc(100vh-180px)] overflow-y-auto p-5 space-y-6 custom-scrollbar">

                            {{-- Price Range Filter --}}
                            <div>
                                <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-3">
                                    {{ __('Price Range') }}
                                </h3>
                                <form action="{{ route('web.products') }}" method="get" class="space-y-3">
                                    @foreach (collect(request()->query())->except(['min', 'max']) as $key => $value)
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                    @endforeach

                                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                        <div class="flex-1">
                                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                                                {{ __('Min Price') }}
                                            </label>
                                            <input type="number" name="min"
                                                class="w-full rounded-lg px-3 py-2 text-sm bg-white dark:bg-gray-900 dark:text-white border border-gray-200 dark:border-gray-700 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 dark:focus:ring-emerald-900/50 transition-colors"
                                                min="0" placeholder="0" value="{{ request('min') }}">
                                        </div>
                                        <span
                                            class="hidden sm:block text-gray-400 dark:text-gray-500 self-end pb-2">—</span>
                                        <div class="flex-1">
                                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                                                {{ __('Max Price') }}
                                            </label>
                                            <input type="number" name="max"
                                                class="w-full rounded-lg px-3 py-2 text-sm bg-white dark:bg-gray-900 dark:text-white border border-gray-200 dark:border-gray-700 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 dark:focus:ring-emerald-900/50 transition-colors"
                                                min="0" placeholder="∞" value="{{ request('max') }}">
                                        </div>
                                    </div>

                                    <button type="submit"
                                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors">
                                        {{ __('Apply') }}
                                    </button>

                                    {{-- Clear price filter --}}
                                    @if (request('min') || request('max'))
                                        <a href="{{ request()->fullUrlWithQuery(['min' => null, 'max' => null]) }}"
                                            class="block text-center text-xs text-gray-500 hover:text-red-600 dark:hover:text-red-400 hover:underline">
                                            {{ __('Clear Price Filter') }}
                                        </a>
                                    @endif
                                </form>
                            </div>

                            <div class="border-t border-gray-100 dark:border-gray-700"></div>

                            {{-- Rating Filter --}}
                            <div>
                                <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-3">
                                    {{ __('Customer Rating') }}
                                </h3>
                                <div class="space-y-1.5">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <a href="{{ request()->fullUrlWithQuery(['rating' => $i]) }}"
                                            class="flex items-center justify-between px-3 py-2 rounded-lg border transition-colors text-sm {{ request('rating') == $i
                                                ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 border-emerald-300 dark:border-emerald-700 font-semibold'
                                                : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-100 dark:border-gray-700 hover:border-emerald-300 dark:hover:border-emerald-700' }}">
                                            <div class="flex items-center gap-0.5">
                                                @for ($j = 1; $j <= 5; $j++)
                                                    <i
                                                        class="fa-solid fa-star text-xs {{ $i >= $j ? 'text-amber-400' : 'text-gray-200 dark:text-gray-600' }}"></i>
                                                @endfor
                                            </div>
                                            <span class="text-xs font-medium">{{ $i }}+</span>
                                        </a>
                                    @endfor
                                </div>

                                @if (request('rating'))
                                    <a href="{{ request()->fullUrlWithQuery(['rating' => null]) }}"
                                        class="block text-center text-xs text-gray-500 hover:text-red-600 dark:hover:text-red-400 hover:underline mt-3">
                                        {{ __('Clear Rating') }}
                                    </a>
                                @endif
                            </div>

                            <div class="border-t border-gray-100 dark:border-gray-700"></div>

                            {{-- Categories Filter --}}
                            <div>
                                <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-3">
                                    {{ __('Categories') }}
                                </h3>
                                <div class="space-y-1.5">
                                    <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}"
                                        class="block px-3 py-2 rounded-lg border transition-colors text-sm {{ !request('category')
                                            ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 border-emerald-300 dark:border-emerald-700 font-semibold'
                                            : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-100 dark:border-gray-700 hover:border-emerald-300 dark:hover:border-emerald-700' }}">
                                        {{ __('All Categories') }}
                                    </a>

                                    @if (isset($categories))
                                        @foreach ($categories as $item)
                                            <a href="{{ request()->fullUrlWithQuery(['category' => $item->slug]) }}"
                                                class="block px-3 py-2 rounded-lg border transition-colors text-sm {{ request('category') == $item->slug
                                                    ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 border-emerald-300 dark:border-emerald-700 font-semibold'
                                                    : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-100 dark:border-gray-700 hover:border-emerald-300 dark:hover:border-emerald-700' }}">
                                                {{ $item->name }}
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
                        <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-100 dark:border-gray-700">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('Active') }}:
                                </span>

                                @if (request('category'))
                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 rounded-lg text-xs font-medium">
                                        {{ $categories->where('slug', request('category'))->first()->name ?? request('category') }}
                                        <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}"
                                            class="hover:text-red-600">
                                            <i class="fa fa-times-circle"></i>
                                        </a>
                                    </span>
                                @endif

                                @if (request('min') || request('max'))
                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 rounded-lg text-xs font-medium">
                                        {{ request('min') ?? '0' }} - {{ request('max') ?? '∞' }}
                                        <a href="{{ request()->fullUrlWithQuery(['min' => null, 'max' => null]) }}"
                                            class="hover:text-red-600">
                                            <i class="fa fa-times-circle"></i>
                                        </a>
                                    </span>
                                @endif

                                @if (request('rating'))
                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800 rounded-lg text-xs font-medium">
                                        <i class="fa fa-star"></i>
                                        {{ request('rating') }}+
                                        <a href="{{ request()->fullUrlWithQuery(['rating' => null]) }}"
                                            class="hover:text-red-600">
                                            <i class="fa fa-times-circle"></i>
                                        </a>
                                    </span>
                                @endif

                                <a href="{{ route('web.products') }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-red-600 dark:text-red-400 hover:underline">
                                    {{ __('Clear All') }}
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
                        <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-100 dark:border-gray-700">
                            <div class="text-gray-700 dark:text-gray-300">
                                {{ $products->links() }}
                            </div>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-50 dark:bg-gray-900 rounded-2xl mb-6">
                                <i class="fa-solid fa-box-open text-3xl text-gray-300 dark:text-gray-600"></i>
                            </div>
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                {{ __('No Products Found') }}</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-6">
                                {{ __('No products match your current filters.') }}
                            </p>
                            <a href="{{ route('web.products') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition-colors">
                                {{ __('Clear Filters & Show All') }}
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
            background: #10b981;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #059669;
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

                                // Show quick checkout modal instead of redirecting
                                setTimeout(function() {
                                    if (typeof showQuickCheckout === 'function') {
                                        showQuickCheckout();
                                    } else {
                                        window.location.href = '/checkout';
                                    }
                                }, 300);
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
                    bgClass = 'bg-emerald-600';
                    iconClass = 'fa-check-circle';
                } else if (type === 'error') {
                    bgClass = 'bg-red-600';
                    iconClass = 'fa-exclamation-circle';
                } else {
                    bgClass = 'bg-gray-900';
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
