@extends('layouts.guest')
@section('content')
    <div class="container mx-auto px-4 py-8 bg-white dark:bg-gray-900 min-h-screen">
        <h1 class="text-3xl font-bold mb-8 text-gray-900 dark:text-gray-100">Shopping Cart</h1>

        <div id="cart-container">
            <div id="loading" class="text-center py-8">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 dark:border-blue-400">
                </div>
                <p class="mt-2 text-gray-700 dark:text-gray-300">Loading cart...</p>
            </div>

            <div id="empty-cart" class="text-center py-12 hidden">
                <div class="text-gray-500 dark:text-gray-400 text-6xl mb-4">🛒</div>
                <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-300 mb-2">Your cart is empty</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Add some products to get started!</p>
                <a href="{{ route('web.products') }}"
                    class="bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    Continue Shopping
                </a>
            </div>

            <div id="cart-items" class="hidden">
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Cart Items</h3>
                    </div>
                    <div id="items-list"></div>
                </div>

                <div
                    class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Cart Summary</h3>
                        <button id="clear-cart"
                            class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 text-sm transition-colors">
                            Clear Cart
                        </button>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
                        <div class="flex justify-between items-center text-xl font-bold text-gray-900 dark:text-gray-100">
                            <span>Total:</span>
                            <span id="cart-total">$0.00</span>
                        </div>
                    </div>

                    <div class="mt-6 flex space-x-4">
                        <a href="{{ route('web.products') }}"
                            class="flex-1 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 px-6 py-3 rounded-lg font-medium text-center transition-colors">
                            Continue Shopping
                        </a>
                        <button
                            class="flex-1 bg-green-600 dark:bg-green-500 hover:bg-green-700 dark:hover:bg-green-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            <a href="/checkout" class="block">Proceed to Checkout</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('jsscript')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Load cart contents on page load
            loadCart();

            // Load cart function
            function loadCart() {
                fetch('/cart/contents', {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        displayCart(data);
                    })
                    .catch(error => {
                        console.error('Error loading cart:', error);
                        document.getElementById('loading').innerHTML =
                            '<p class="text-red-500">Error loading cart</p>';
                    });
            } // Display cart function
            function displayCart(data) {
                const loading = document.getElementById('loading');
                const emptyCart = document.getElementById('empty-cart');
                const cartItems = document.getElementById('cart-items');
                const itemsList = document.getElementById('items-list');
                const cartTotal = document.getElementById('cart-total');

                loading.classList.add('hidden');

                if (data.count === 0) {
                    emptyCart.classList.remove('hidden');
                    cartItems.classList.add('hidden');
                } else {
                    emptyCart.classList.add('hidden');
                    cartItems.classList.remove('hidden');

                    // Display items
                    itemsList.innerHTML = '';

                    // Convert items object to array and iterate
                    Object.keys(data.items).forEach(id => {
                        const item = data.items[id];
                        const itemElement = createCartItemElement(id, item);
                        itemsList.appendChild(itemElement);
                    });

                    // Update total
                    cartTotal.textContent = '$' + data.total;
                }
            }

            // Create cart item element
            function createCartItemElement(id, item) {
                const div = document.createElement('div');
                div.className = 'px-6 py-4 border-b last:border-b-0';
                div.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                        ${item.image ? `<img src="${item.image}" alt="${item.name[0]}" class="w-full h-full object-cover rounded">` : '📦'}
                    </div>
                    <div>
                        <h4 class="font-medium">${item.name[0]}</h4>
                        <p class="text-gray-600">$${item.price.toFixed(2)} each</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <button class="quantity-update bg-gray-200 hover:bg-gray-300 text-gray-700 w-8 h-8 rounded-full flex items-center justify-center text-sm" 
                                data-id="${id}" data-action="minus">
                            -
                        </button>
                        <span class="w-12 text-center">${item.quantity}</span>
                        <button class="quantity-update bg-gray-200 hover:bg-gray-300 text-gray-700 w-8 h-8 rounded-full flex items-center justify-center text-sm" 
                                data-id="${id}" data-action="plus">
                            +
                        </button>
                    </div>
                    
                    <div class="text-right">
                        <p class="font-medium">$${(item.price * item.quantity).toFixed(2)}</p>
                    </div>
                    
                    <button class="remove-item text-red-600 hover:text-red-800 ml-4" data-id="${id}">
                        ✕
                    </button>
                </div>
            </div>
        `;
                return div;
            }

            // Handle quantity updates
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('quantity-update')) {
                    const productId = e.target.getAttribute('data-id');
                    const action = e.target.getAttribute('data-action');

                    fetch('/cart/update', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                action: action
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                loadCart(); // Reload cart
                                showNotification('Cart updated', 'success');
                            }
                        })
                        .catch(error => {
                            showNotification('Error updating cart', 'error');
                        });
                }
            });

            // Handle item removal
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-item')) {
                    const productId = e.target.getAttribute('data-id');

                    if (confirm('Remove this item from cart?')) {
                        fetch('/cart/remove', {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    product_id: productId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    loadCart(); // Reload cart
                                    showNotification('Item removed from cart', 'success');
                                }
                            })
                            .catch(error => {
                                showNotification('Error removing item', 'error');
                            });
                    }
                }
            });

            // Handle clear cart
            document.getElementById('clear-cart').addEventListener('click', function() {
                if (confirm('Clear all items from cart?')) {
                    fetch('/cart/clear', {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                loadCart(); // Reload cart
                                showNotification('Cart cleared', 'success');
                            }
                        })
                        .catch(error => {
                            showNotification('Error clearing cart', 'error');
                        });
                }
            });

            // Notification function
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
        });
    </script>
@endsection
