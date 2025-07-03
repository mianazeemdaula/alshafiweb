@extends('layouts.guest')
@section('content')
    <div
        class="bg-gray-100 dark:bg-gray-800 flex flex-col sm:flex-row items-start sm:items-center justify-between px-2 sm:px-4 py-2 border-b border-gray-200 dark:border-gray-700 gap-2 sm:gap-0">
        <div class="text-gray-700 dark:text-gray-300 text-sm">
            {{ __('showing_entries', [
                'first' => $products->firstItem(),
                'last' => $products->lastItem(),
                'total' => $products->total(),
            ]) }}
        </div>
        <div>
            <form action="{{ route('web.products') }}" method="get" class="flex space-x-2 items-center">
                {{-- Preserve existing filters --}}
                @foreach (collect(request()->query())->except(['sort', 'order']) as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach

                <div class="text-xs text-gray-700 dark:text-gray-300 hidden sm:block">{{ __('sort_by') }}</div>
                <select name="sort"
                    class="p-1 rounded w-32 sm:w-40 bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white border border-gray-300 text-sm"
                    onchange="this.form.submit()">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('Newest') }}</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                        {{ __('Price: Low to High') }}</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                        {{ __('Price: High to Low') }}</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>{{ __('name') }}</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>{{ __('rating') }}
                    </option>
                </select>
            </form>
        </div>
    </div>
    <div class="flex flex-col lg:flex-row min-h-screen">
        <!-- Mobile Filter Button -->
        <div class="lg:hidden bg-slate-200 dark:bg-gray-800 border-b border-gray-300 dark:border-gray-700 p-4">
            <button id="mobile-filter-toggle"
                class="flex items-center justify-between w-full text-gray-900 dark:text-gray-100">
                <span class="font-medium text-sm">{{ __('Filters') }}</span>
                <i class="fa fa-filter text-sm"></i>
            </button>
        </div>

        <!-- Sidebar Filters -->
        <div id="filter-sidebar"
            class="w-full lg:w-3/12 bg-slate-200 dark:bg-gray-800 border-r border-gray-300 dark:border-gray-700 hidden lg:block">
            <div class="px-4 py-4 ">
                <div class="flex flex-col gap-2">
                    {{-- Price Range Filter --}}
                    <div class="flex flex-col gap-2 items-start">
                        <h3 class="font-medium text-sm text-gray-900 dark:text-gray-100">{{ __('Price Range') }}</h3>
                        <form action="{{ route('web.products') }}" method="get" class="flex gap-1 items-center mb-0">
                            {{-- Preserve other filters --}}
                            @foreach (collect(request()->query())->except(['min', 'max']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <input type="number" name="min"
                                class="rounded p-1 w-28 text-xs bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white border border-gray-300"
                                min="0" placeholder="{{ __('min') }}" value="{{ request('min') }}">
                            <span class="text-xs text-gray-600 dark:text-gray-400">-</span>
                            <input type="number" name="max"
                                class="rounded p-1 w-28 text-xs bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white border border-gray-300"
                                min="0" placeholder="{{ __('max') }}" value="{{ request('max') }}">
                            <button type="submit"
                                class="bg-blue-500 dark:bg-blue-600 hover:bg-blue-600 dark:hover:bg-blue-700 text-white px-2 py-1 rounded text-xs transition-colors">{{ __('go') }}</button>
                        </form>

                        {{-- Clear price filter --}}
                        @if (request('min') || request('max'))
                            <a href="{{ request()->fullUrlWithQuery(['min' => null, 'max' => null]) }}"
                                class="text-xs text-red-600 dark:text-red-400 hover:underline">{{ __('Clear Price Filter') }}</a>
                        @endif
                    </div>

                    {{-- Rating Filter --}}
                    <div class="flex flex-col gap-2 items-start mt-4">
                        <h3 class="font-medium text-sm text-gray-900 dark:text-gray-100">{{ __('Minimum Rating') }}</h3>
                        <div class="flex flex-wrap gap-1 w-full">
                            @for ($i = 1; $i <= 5; $i++)
                                <a href="{{ request()->fullUrlWithQuery(['rating' => $i]) }}"
                                    class="inline-flex items-center px-2 py-0.5 rounded-full border transition text-xs font-medium mb-1 {{ request('rating') == $i ? 'bg-green-500 dark:bg-green-600 text-white border-green-500 dark:border-green-600' : 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 border-blue-400 dark:border-blue-500 hover:bg-blue-50 dark:hover:bg-gray-600' }}">
                                    @for ($j = 1; $j <= 5; $j++)
                                        <i
                                            class="fa-solid fa-star {{ $i >= $j ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-500' }} text-[9px] mr-0.5"></i>
                                    @endfor
                                    <span class="ml-0.5">{{ $i }}+</span>
                                </a>
                            @endfor
                        </div>

                        {{-- Clear rating filter --}}
                        @if (request('rating'))
                            <a href="{{ request()->fullUrlWithQuery(['rating' => null]) }}"
                                class="text-xs text-red-600 dark:text-red-400 hover:underline">{{ __('Clear Rating Filter') }}</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="px-4 py-1 mt-2">
                <h3 class="font-medium text-sm mb-2 text-gray-900 dark:text-gray-100">{{ __('Categories') }}</h3>
                <div class="flex flex-wrap gap-1 w-full">
                    {{-- All categories option --}}
                    <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}"
                        class="inline-flex items-center px-2 py-0.5 rounded-full border transition text-xs font-medium mb-1 {{ !request('category') ? 'bg-green-500 dark:bg-green-600 text-white border-green-500 dark:border-green-600' : 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 border-blue-400 dark:border-blue-500 hover:bg-blue-50 dark:hover:bg-gray-600' }}">
                        {{ __('All Categories') }}
                    </a>

                    @if (isset($categories))
                        @foreach ($categories as $item)
                            <a href="{{ request()->fullUrlWithQuery(['category' => $item->slug]) }}"
                                class="inline-flex items-center px-2 py-0.5 rounded-full border transition text-xs font-medium mb-1 {{ request('category') == $item->slug ? 'bg-green-500 dark:bg-green-600 text-white border-green-500 dark:border-green-600' : 'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 border-blue-400 dark:border-blue-500 hover:bg-blue-50 dark:hover:bg-gray-600' }}">
                                {{ $item->name }}
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <!-- Main Content -->
        <div class="px-2 sm:px-4 bg-slate-100 dark:bg-gray-900 flex-1 min-h-screen">
            <div class="py-4">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-5 gap-2 sm:gap-4">
                    @foreach ($products as $product)
                        <x-product-card1 :product="$product" />
                    @endforeach
                </div>
                @if ($products->count() > 0)
                    <div class="p-4">
                        <div class="text-gray-700 dark:text-gray-300">
                            {{ $products->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fa-solid fa-box-open text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">{{ __('No Products Found') }}
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400">{{ __('No products match your current filters.') }}</p>
                    </div>
                @endif
            </div>
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
                // Check if clicked element is the button or a child of the button
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
                // Check if clicked element is the button or a child of the button
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
                                // Show success message
                                showNotification('✓ ' + productName + ' added to cart!', 'success');

                                // Update cart count in header if exists
                                updateCartCount(data.cart_count);

                                // Reset quantity to 1
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
                            // Re-enable button and restore icon
                            button.disabled = false;
                            button.innerHTML = '<i class="fa-solid fa-cart-plus text-sm"></i>';
                        });
                }
            });

            // Function to show notifications
            function showNotification(message, type = 'info') {
                // Remove existing notifications
                const existingNotifications = document.querySelectorAll('.cart-notification');
                existingNotifications.forEach(n => n.remove());

                const notification = document.createElement('div');
                notification.className = `cart-notification fixed top-4 right-4 z-50 px-6 py-3 rounded shadow-lg text-white font-medium transition-all duration-300 ${
            type === 'success' ? 'bg-green-500' : 
            type === 'error' ? 'bg-red-500' : 'bg-blue-500'
        }`;
                notification.textContent = message;

                document.body.appendChild(notification);

                // Auto remove after 3 seconds
                setTimeout(() => {
                    notification.style.opacity = '0';
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }

            // Function to update cart count in header
            function updateCartCount(count) {
                const cartCountElements = document.querySelectorAll('.cart-count');
                cartCountElements.forEach(element => {
                    element.textContent = count;
                    element.style.display = count > 0 ? 'flex' : 'none';
                });
            }

            // Mobile filter toggle functionality
            const mobileFilterToggle = document.getElementById('mobile-filter-toggle');
            const filterSidebar = document.getElementById('filter-sidebar');

            if (mobileFilterToggle && filterSidebar) {
                mobileFilterToggle.addEventListener('click', function() {
                    filterSidebar.classList.toggle('hidden');
                    const icon = this.querySelector('i');
                    if (filterSidebar.classList.contains('hidden')) {
                        icon.className = 'fa fa-filter text-sm';
                    } else {
                        icon.className = 'fa fa-times text-sm';
                    }
                });
            }
        });
    </script>
@endsection
