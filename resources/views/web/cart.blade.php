@extends('layouts.guest')
@section('content')
    <div class="container mx-auto px-4 py-12 bg-transparent min-h-screen">
        <h1 class="text-3xl sm:text-4xl font-extrabold mb-8 text-emerald-950 dark:text-emerald-100 font-playfair">{{ __('cart.title') }}</h1>

        <div id="cart-container">
            <div id="loading" class="text-center py-16 bg-white/40 dark:bg-emerald-950/10 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/20 backdrop-blur-sm">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600 dark:border-emerald-400">
                </div>
                <p class="mt-4 text-emerald-900 dark:text-emerald-100 font-serif font-bold text-lg">Alshaafi</p>
                <p class="mt-1 text-emerald-850/60 dark:text-emerald-350 text-sm">{{ __('cart.loading') }}</p>
            </div>

            <div id="empty-cart" class="text-center py-16 bg-white/60 dark:bg-emerald-950/10 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/20 backdrop-blur-sm hidden">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-50 dark:bg-emerald-900/30 rounded-2xl text-emerald-600 dark:text-emerald-400 text-3xl mb-6">
                    <i class="fa-solid fa-shopping-basket"></i>
                </div>
                <h2 class="text-2xl font-bold text-emerald-950 dark:text-emerald-100 mb-2 font-serif">{{ __('cart.empty_title') }}</h2>
                <p class="text-emerald-850/60 dark:text-emerald-400 mb-8 max-w-sm mx-auto text-sm">{{ __('cart.empty_subtitle') }}</p>
                <a href="{{ route('web.products') }}"
                    class="inline-flex items-center justify-center bg-emerald-700 hover:bg-emerald-800 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-sm hover:shadow-md shadow-emerald-700/10">
                    {{ __('cart.continue_shopping') }}
                </a>
            </div>

            <div id="cart-items" class="hidden space-y-6">
                <div class="bg-white/90 dark:bg-emerald-950/20 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/30 overflow-hidden shadow-sm">
                    <div class="px-6 py-4 bg-emerald-50/40 dark:bg-emerald-900/10 border-b border-emerald-900/10 dark:border-emerald-800/30 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-emerald-950 dark:text-emerald-100">{{ __('cart.items') }}</h3>
                        <button id="clear-cart"
                            class="text-rose-600 dark:text-rose-400 hover:text-rose-800 dark:hover:text-rose-300 text-sm font-semibold transition-colors flex items-center gap-1.5">
                            <i class="fa-solid fa-trash-can text-xs"></i>
                            {{ __('cart.clear') }}
                        </button>
                    </div>
                    <div id="items-list" class="divide-y divide-emerald-900/10 dark:divide-emerald-800/30"></div>
                </div>

                <div class="bg-white/90 dark:bg-emerald-950/20 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/30 p-6 shadow-sm">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-emerald-900/10 dark:border-emerald-800/30 pb-6 mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-emerald-950 dark:text-emerald-100 font-serif">{{ __('cart.summary') }}</h3>
                            <p class="text-xs text-emerald-850/60 dark:text-emerald-400 mt-1">Shipping is free for all orders across Pakistan.</p>
                        </div>
                        <div class="flex items-baseline justify-between md:justify-end gap-4">
                            <span class="text-sm font-semibold text-emerald-850/60 dark:text-emerald-400">{{ __('cart.total') }}:</span>
                            <span id="cart-total" class="text-2xl sm:text-3xl font-extrabold text-emerald-950 dark:text-emerald-50">RS. 0.00</span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('web.products') }}"
                            class="flex-1 h-11 inline-flex items-center justify-center border border-emerald-200 dark:border-emerald-800/50 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-800 dark:text-emerald-200 px-5 rounded-xl font-bold text-sm text-center transition-all hover:bg-emerald-100 dark:hover:bg-emerald-900/40">
                            <i class="fa-solid fa-arrow-left mr-2 text-xs"></i>
                            {{ __('cart.continue_shopping') }}
                        </a>
                        <a href="/checkout"
                            class="flex-1 h-11 inline-flex items-center justify-center bg-emerald-700 hover:bg-emerald-800 text-white px-5 rounded-xl font-bold text-sm text-center transition-all shadow-sm hover:shadow-md shadow-emerald-700/10">
                            <span>{{ __('cart.checkout') }}</span>
                            <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                        </a>
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

            // Cart localization object
            const cartLang = {
                each: "{{ __('cart.each') }}",
                remove_confirm: "{{ __('cart.remove_confirm') }}",
                clear_confirm: "{{ __('cart.clear_confirm') }}",
                cart_updated: "{{ __('cart.updated') }}",
                item_removed: "{{ __('cart.item_removed') }}",
                cart_cleared: "{{ __('cart.cleared') }}",
                error_updating: "{{ __('cart.error_updating') }}",
                error_removing: "{{ __('cart.error_removing') }}",
                error_clearing: "{{ __('cart.error_clearing') }}",
                error_loading: "{{ __('cart.error_loading') }}"
            };

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
                            `<p class="text-red-500">${cartLang.error_loading}</p>`;
                    });
            }

            // Display cart function
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
                    cartTotal.textContent = 'RS. ' + data.total;
                }
            }

            // Create cart item element
            function createCartItemElement(id, item) {
                const div = document.createElement('div');
                div.className = 'px-6 py-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 last:border-b-0';
                div.innerHTML = `
                    <div class="flex items-center gap-4 flex-1">
                        <div class="w-16 h-16 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-900/10 rounded-xl flex-shrink-0 flex items-center justify-center overflow-hidden">
                            ${item.image ? `<img src="${item.image}" alt="${item.name[0]}" class="w-full h-full object-cover">` : '📦'}
                        </div>
                        <div>
                            <h4 class="font-bold text-emerald-950 dark:text-emerald-100 text-sm sm:text-base">${item.name[0]}</h4>
                            <p class="text-xs text-emerald-850/60 dark:text-emerald-400 mt-1">RS. ${item.price.toFixed(2)} ${cartLang.each}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between sm:justify-end gap-6">
                        <div class="flex items-center bg-[#f6f3eb]/60 dark:bg-emerald-950/40 border border-emerald-900/10 rounded-xl p-1">
                            <button class="quantity-update text-emerald-800 dark:text-emerald-300 hover:bg-emerald-900/5 w-8 h-8 rounded-lg flex items-center justify-center text-sm transition-colors" 
                                    data-id="${id}" data-action="minus">
                                <i class="fa-solid fa-minus text-xs pointer-events-none"></i>
                            </button>
                            <span class="w-10 text-center font-bold text-emerald-950 dark:text-emerald-100 text-sm">${item.quantity}</span>
                            <button class="quantity-update text-emerald-800 dark:text-emerald-300 hover:bg-emerald-900/5 w-8 h-8 rounded-lg flex items-center justify-center text-sm transition-colors" 
                                    data-id="${id}" data-action="plus">
                                <i class="fa-solid fa-plus text-xs pointer-events-none"></i>
                            </button>
                        </div>
                        
                        <div class="text-right min-w-[80px]">
                            <p class="font-bold text-emerald-950 dark:text-emerald-50">RS. ${(item.price * item.quantity).toFixed(2)}</p>
                        </div>
                        
                        <button class="remove-item text-rose-500 hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300 p-2 hover:bg-rose-50 dark:hover:bg-rose-950/20 rounded-lg transition-all" data-id="${id}">
                            <i class="fa-solid fa-xmark text-sm pointer-events-none"></i>
                        </button>
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
                                showNotification(cartLang.cart_updated, 'success');
                            }
                        })
                        .catch(error => {
                            showNotification(cartLang.error_updating, 'error');
                        });
                }
            });

            // Handle item removal
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-item')) {
                    const productId = e.target.getAttribute('data-id');

                    if (confirm(cartLang.remove_confirm)) {
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
                                    showNotification(cartLang.item_removed, 'success');
                                }
                            })
                            .catch(error => {
                                showNotification(cartLang.error_removing, 'error');
                            });
                    }
                }
            });

            // Handle clear cart
            document.getElementById('clear-cart').addEventListener('click', function() {
                if (confirm(cartLang.clear_confirm)) {
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
                                showNotification(cartLang.cart_cleared, 'success');
                            }
                        })
                        .catch(error => {
                            showNotification(cartLang.error_clearing, 'error');
                        });
                }
            });

            // Notification function
            function showNotification(message, type = 'info') {
                const existingNotifications = document.querySelectorAll('.cart-notification');
                existingNotifications.forEach(n => n.remove());

                const notification = document.createElement('div');
                notification.className = `cart-notification fixed bottom-5 right-5 z-50 px-5 py-3.5 rounded-xl shadow-lg border text-sm font-semibold transition-all duration-350 flex items-center gap-2 transform translate-y-2 opacity-0 ${
                    type === 'success' ? 'bg-emerald-50 border-emerald-250 text-emerald-800 dark:bg-emerald-900/40 dark:border-emerald-800 dark:text-emerald-200' : 
                    type === 'error' ? 'bg-rose-50 border-rose-200 text-rose-800 dark:bg-rose-950/40 dark:border-rose-800 dark:text-rose-200' : 
                    'bg-amber-50 border-amber-200 text-amber-800 dark:bg-amber-950/40 dark:border-amber-800 dark:text-amber-200'
                }`;
                
                const icon = type === 'success' ? '<i class="fa-solid fa-circle-check"></i>' : 
                             type === 'error' ? '<i class="fa-solid fa-circle-exclamation"></i>' : 
                             '<i class="fa-solid fa-circle-info"></i>';
                             
                notification.innerHTML = `${icon}<span>${message}</span>`;

                document.body.appendChild(notification);
                
                // Trigger animation
                requestAnimationFrame(() => {
                    notification.classList.remove('translate-y-2', 'opacity-0');
                });

                setTimeout(() => {
                    notification.classList.add('opacity-0', 'translate-y-2');
                    setTimeout(() => notification.remove(), 350);
                }, 3000);
            }
        });
    </script>
@endsection
