@extends('layouts.guest')
@section('content')
    <div class="p-4">
        <div class="grid lg:grid-cols-3 grid-rows-2 grid-cols-2 gap-4">
            <div class="bg-gray-500 h-[500px] col-span-2 lg:row-span-2 rounded-lg"></div>
            <div class="bg-red-300 rounded-lg">
            </div>
            <div class="bg-blue-300 rounded-lg">
            </div>
        </div>
    </div>

    <div class="p-4 bg-slate-100">
        <div class="mb-2 flex items-center justify-between">
            <h1 class="text-xl font-light">Our Products</h1>
            <a href="#" class="text-base font-light">View All</a>
        </div>
        <div class="grid grid-cols-5 gap-4 ">
            @foreach (App\Models\Product::take(10)->get() as $item)
                <x-product-card1 :product="$item" />
            @endforeach
        </div>
    </div>

    <div class="mt-3 p-4">
        <div class="grid lg:grid-cols-3 gap-4">
            <div class="bg-orange-200 rounded-lg">
                <div class="flex items-center justify-center h-48">
                    AD 2
                </div>
            </div>
            <div class="bg-blue-200 rounded-lg">
                <div class="flex items-center justify-center h-48">
                    AD 2
                </div>
            </div>
            <div class="bg-green-300 rounded-lg">
                <div class="flex items-center justify-center h-48">
                    AD 2
                </div>
            </div>
        </div>
    </div>

    {{-- reviews section --}}
    <div class="p-4 bg-slate-100">
        <div class="grid grid-cols-5 gap-4">
            @foreach (range(1, 5) as $item)
                <div class="bg-white p-4 rounded-lg">
                    <div class="">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gray-200 rounded-full"></div>
                            <div class="ml-2">
                                <div class="text-sm font-light">User Name</div>
                                <div class="text-xs font-light">{{ now()->format('d-m-Y') }}</div>
                            </div>
                        </div>
                        <div class="flex items-center text-gray-600 text-sm my-2">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis animi consequatur itaque
                            hic fugit obcaecati nisi, maxime eveniet ut corporis fugiat quidem sapiente sequi eligendi
                            quis numquam dicta placeat id!
                        </div>
                        <div class="text-xs">
                            @php
                                echo str_repeat('⭐', 5);
                            @endphp
                        </div>
                    </div>
                </div>
            @endforeach
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
