@extends('layouts.guest')
@section('content')
    <div class="container mx-auto px-4 py-12 bg-transparent min-h-screen">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-3xl sm:text-4xl font-extrabold mb-8 text-emerald-950 dark:text-emerald-100 font-playfair">{{ __('Checkout') }}</h1>

            <div id="checkout-container">
                <!-- Loading State -->
                <div id="loading" class="text-center py-16 bg-white/40 dark:bg-emerald-950/10 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/20 backdrop-blur-sm">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600 dark:border-emerald-400"></div>
                    <p class="mt-4 text-emerald-900 dark:text-emerald-100 font-serif font-bold text-lg">Alshaafi</p>
                    <p class="mt-1 text-emerald-850/60 dark:text-emerald-350 text-sm">{{ __('Loading checkout...') }}</p>
                </div>

                <!-- Empty Cart -->
                <div id="empty-cart" class="text-center py-16 bg-white/60 dark:bg-emerald-950/10 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/20 backdrop-blur-sm hidden">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-50 dark:bg-emerald-900/30 rounded-2xl text-emerald-600 dark:text-emerald-400 text-3xl mb-6">
                        <i class="fa-solid fa-shopping-basket"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-emerald-950 dark:text-emerald-100 mb-2 font-serif">{{ __('Your cart is empty') }}</h2>
                    <p class="text-emerald-850/60 dark:text-emerald-400 mb-8 max-w-sm mx-auto text-sm">{{ __('Add some products before checkout!') }}</p>
                    <a href="{{ route('web.products') }}"
                        class="inline-flex items-center justify-center bg-emerald-700 hover:bg-emerald-800 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-sm hover:shadow-md shadow-emerald-700/10">
                        {{ __('Continue Shopping') }}
                    </a>
                </div>

                <!-- Checkout Form -->
                <div id="checkout-form" class="hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Left Column - Forms -->
                        <div class="lg:col-span-2 space-y-6">

                            <!-- Shipping Information -->
                            <div class="bg-white/90 dark:bg-emerald-950/20 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/30 p-6 shadow-sm">
                                <h3 class="text-xl font-bold text-emerald-950 dark:text-emerald-100 font-serif mb-6">{{ __('Shipping Information') }}</h3>
                                <form id="shipping-form" class="space-y-5">
                                    @auth
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-semibold uppercase tracking-wider text-emerald-950/60 dark:text-emerald-350 mb-2">{{ __('First Name') }}</label>
                                                <input type="text" name="first_name" value="{{ auth()->user()->name ?? '' }}"
                                                    class="flex h-11 w-full rounded-xl border border-emerald-900/10 dark:border-emerald-800/40 bg-[#f6f3eb]/40 dark:bg-emerald-950/20 px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-100 dark:focus:ring-emerald-950/30 focus:border-emerald-600 dark:text-white transition-all"
                                                    required>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold uppercase tracking-wider text-emerald-950/60 dark:text-emerald-350 mb-2">Last Name</label>
                                                <input type="text" name="last_name"
                                                    class="flex h-11 w-full rounded-xl border border-emerald-900/10 dark:border-emerald-800/40 bg-[#f6f3eb]/40 dark:bg-emerald-950/20 px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-100 dark:focus:ring-emerald-950/30 focus:border-emerald-600 dark:text-white transition-all"
                                                    required>
                                            </div>
                                        </div>
                                    @else
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" id="guest-name-fields">
                                            <div>
                                                <label class="block text-xs font-semibold uppercase tracking-wider text-emerald-950/60 dark:text-emerald-350 mb-2">First Name</label>
                                                <input type="text" name="first_name"
                                                    class="flex h-11 w-full rounded-xl border border-emerald-900/10 dark:border-emerald-800/40 bg-[#f6f3eb]/40 dark:bg-emerald-950/20 px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-100 dark:focus:ring-emerald-950/30 focus:border-emerald-600 dark:text-white transition-all"
                                                    required>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold uppercase tracking-wider text-emerald-950/60 dark:text-emerald-350 mb-2">Last Name</label>
                                                <input type="text" name="last_name"
                                                    class="flex h-11 w-full rounded-xl border border-emerald-900/10 dark:border-emerald-800/40 bg-[#f6f3eb]/40 dark:bg-emerald-950/20 px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-100 dark:focus:ring-emerald-950/30 focus:border-emerald-600 dark:text-white transition-all"
                                                    required>
                                            </div>
                                        </div>
                                    @endauth

                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-emerald-950/60 dark:text-emerald-350 mb-2">{{ __('Phone') }}</label>
                                        <input type="tel" name="phone" pattern="03[0-9]{9}" maxlength="11"
                                            placeholder="03123456789"
                                            class="flex h-11 w-full rounded-xl border border-emerald-900/10 dark:border-emerald-800/40 bg-[#f6f3eb]/40 dark:bg-emerald-950/20 px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-100 dark:focus:ring-emerald-950/30 focus:border-emerald-600 dark:text-white transition-all"
                                            required>
                                        <p class="text-[11px] text-emerald-800/60 dark:text-emerald-400 mt-1.5">Format: 03xxxxxxxxx (e.g. 03123456789)</p>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-emerald-950/60 dark:text-emerald-350 mb-2">{{ __('Address') }}</label>
                                        <textarea name="address" rows="3"
                                            class="w-full rounded-xl border border-emerald-900/10 dark:border-emerald-800/40 bg-[#f6f3eb]/40 dark:bg-emerald-950/20 px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-100 dark:focus:ring-emerald-950/30 focus:border-emerald-600 dark:text-white transition-all resize-none"
                                            required></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-emerald-950/60 dark:text-emerald-350 mb-2">{{ __('City') }}</label>
                                        <input type="text" name="city"
                                            class="flex h-11 w-full rounded-xl border border-emerald-900/10 dark:border-emerald-800/40 bg-[#f6f3eb]/40 dark:bg-emerald-950/20 px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-100 dark:focus:ring-emerald-950/30 focus:border-emerald-600 dark:text-white transition-all"
                                            required>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-emerald-950/60 dark:text-emerald-350 mb-2">{{ __('Order Notes') }} ({{ __('Optional') }})</label>
                                        <textarea name="notes" rows="3"
                                            class="w-full rounded-xl border border-emerald-900/10 dark:border-emerald-800/40 bg-[#f6f3eb]/40 dark:bg-emerald-950/20 px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-100 dark:focus:ring-emerald-950/30 focus:border-emerald-600 dark:text-white transition-all resize-none"
                                            placeholder="{{ __('Any special instructions?') }}"></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Right Column - Order Summary -->
                        <div class="lg:col-span-1">
                            <div class="bg-white/90 dark:bg-emerald-950/20 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/30 p-6 sticky top-4 shadow-sm space-y-6">
                                <h3 class="text-xl font-bold text-emerald-950 dark:text-emerald-100 font-serif border-b border-emerald-900/10 dark:border-emerald-800/30 pb-4 mb-4">{{ __('Order Summary') }}</h3>

                                <!-- Cart Items -->
                                <div id="checkout-items" class="space-y-4 max-h-60 overflow-y-auto pr-2 divide-y divide-emerald-900/5 dark:divide-emerald-800/10">
                                    <!-- Items will be populated by JavaScript -->
                                </div>

                                <!-- Order Totals -->
                                <div class="border-t border-emerald-900/10 dark:border-emerald-800/30 pt-4 space-y-3">
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-emerald-850/60 dark:text-emerald-400 font-semibold">Subtotal:</span>
                                        <span id="subtotal" class="font-bold text-emerald-950 dark:text-emerald-100">RS. 0.00</span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-emerald-850/60 dark:text-emerald-400 font-semibold">Shipping:</span>
                                        <span class="text-emerald-700 dark:text-emerald-350 font-bold uppercase tracking-wider text-xs">FREE</span>
                                    </div>
                                    <div class="flex justify-between items-center text-lg font-bold border-t border-emerald-900/10 dark:border-emerald-800/30 pt-3">
                                        <span class="text-emerald-950 dark:text-emerald-100 font-serif">Total:</span>
                                        <span id="total" class="text-xl text-emerald-900 dark:text-emerald-50 font-extrabold">RS. 0.00</span>
                                    </div>
                                </div>

                                <!-- Payment Method -->
                                <div class="space-y-3">
                                    <h4 class="text-sm font-semibold uppercase tracking-wider text-emerald-950/60 dark:text-emerald-350">Payment Method</h4>
                                    <label class="flex items-center space-x-3 p-4 border border-emerald-900/15 dark:border-emerald-800/40 rounded-xl cursor-pointer bg-emerald-50/20 dark:bg-emerald-950/10 hover:bg-emerald-50/40 dark:hover:bg-emerald-950/20 transition-all select-none">
                                        <input type="radio" name="payment_method" value="cod" checked
                                            class="text-emerald-700 focus:ring-emerald-500 border-emerald-900/20 dark:border-emerald-800/40 bg-[#f6f3eb] w-4.5 h-4.5">
                                        <div>
                                            <div class="font-bold text-sm text-emerald-950 dark:text-emerald-100">Cash on Delivery</div>
                                            <div class="text-[11px] text-emerald-850/60 dark:text-emerald-400 mt-0.5">Pay in cash when your order is delivered</div>
                                        </div>
                                    </label>
                                </div>

                                <!-- Place Order Button -->
                                <button type="button" id="place-order-btn"
                                    class="w-full h-11 inline-flex items-center justify-center bg-emerald-700 hover:bg-emerald-800 text-white px-5 rounded-xl font-bold text-sm transition-all shadow-sm hover:shadow-md shadow-emerald-700/10 cursor-pointer">
                                    Place Order
                                </button>
                            </div>
                        </div>
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
            let isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};

            // Load checkout data
            loadCheckout();

            // Place order functionality (prevent double submission)
            let isPlacingOrder = false;
            document.getElementById('place-order-btn').addEventListener('click', function() {
                if (isPlacingOrder) return;

                const shippingForm = document.getElementById('shipping-form');
                const formData = new FormData(shippingForm);

                // Validate required fields
                const requiredFields = ['first_name', 'last_name', 'phone', 'address', 'city'];
                for (let field of requiredFields) {
                    if (!formData.get(field)) {
                        showNotification(`Please fill in the ${field.replace('_', ' ')} field`, 'error');
                        return;
                    }
                }

                // Get payment method
                const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
                if (!paymentMethod) {
                    showNotification('Please select a payment method', 'error');
                    return;
                }

                // Disable button and show loading
                this.disabled = true;
                this.innerHTML =
                    '<div class="inline-block animate-spin rounded-full h-5 w-5 border-b-2 border-white mr-2"></div> Placing Order...';
                isPlacingOrder = true;

                // Prepare order data
                const orderData = {
                    shipping: {
                        first_name: formData.get('first_name'),
                        last_name: formData.get('last_name'),
                        phone: formData.get('phone'),
                        address: formData.get('address'),
                        city: formData.get('city'),
                        notes: formData.get('notes')
                    },
                    payment_method: paymentMethod.value
                };

                // Submit order
                fetch('/checkout/place-order', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(orderData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('Order placed successfully!', 'success');
                            setTimeout(() => {
                                window.location.href = '/order-confirmation/' + data.order_id;
                            }, 1550);
                        } else {
                            showNotification(data.message || 'Order placement failed', 'error');
                            this.disabled = false;
                            this.textContent = 'Place Order';
                            isPlacingOrder = false;
                        }
                    })
                    .catch(error => {
                        console.error('Order placement error:', error);
                        showNotification('Failed to place order. Please try again.', 'error');
                        this.disabled = false;
                        this.textContent = 'Place Order';
                        isPlacingOrder = false;
                    });
            });

            // Load checkout function
            function loadCheckout() {
                fetch('/cart/contents', {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        displayCheckout(data);
                    })
                    .catch(error => {
                        console.error('Error loading checkout:', error);
                        document.getElementById('loading').innerHTML =
                            '<p class="text-red-500">Error loading checkout</p>';
                    });
            }

            // Display checkout function
            function displayCheckout(data) {
                const loading = document.getElementById('loading');
                const emptyCart = document.getElementById('empty-cart');
                const checkoutForm = document.getElementById('checkout-form');

                loading.classList.add('hidden');

                if (data.count === 0) {
                    emptyCart.classList.remove('hidden');
                    checkoutForm.classList.add('hidden');
                } else {
                    emptyCart.classList.add('hidden');
                    checkoutForm.classList.remove('hidden');

                    // Display items
                    const checkoutItems = document.getElementById('checkout-items');
                    checkoutItems.innerHTML = '';

                    Object.keys(data.items).forEach(id => {
                        const item = data.items[id];
                        const itemElement = createCheckoutItemElement(item);
                        checkoutItems.appendChild(itemElement);
                    });

                    // Update totals
                    document.getElementById('subtotal').textContent = 'Rs. ' + data.total;
                    document.getElementById('total').textContent = 'Rs. ' + data.total;
                }
            }

            // Create checkout item element
            function createCheckoutItemElement(item) {
                const div = document.createElement('div');
                div.className = 'flex items-center space-x-3 py-3 first:pt-0';
                div.innerHTML = `
                    <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-900/10 rounded-xl flex-shrink-0 flex items-center justify-center overflow-hidden">
                        ${item.image ? `<img src="${item.image}" alt="${item.name[0]}" class="w-full h-full object-cover">` : '📦'}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-xs sm:text-sm font-bold text-emerald-950 dark:text-emerald-100 truncate">${item.name[0]}</h4>
                        <p class="text-[11px] text-emerald-850/60 dark:text-emerald-400 mt-0.5">Qty: ${item.quantity}</p>
                    </div>
                    <div class="text-xs sm:text-sm font-bold text-emerald-950 dark:text-emerald-50">
                        Rs. ${(item.price * item.quantity).toFixed(2)}
                    </div>
                `;
                return div;
            }

            // Notification function
            function showNotification(message, type = 'info') {
                const existingNotifications = document.querySelectorAll('.checkout-notification');
                existingNotifications.forEach(n => n.remove());

                const notification = document.createElement('div');
                notification.className = `checkout-notification fixed bottom-5 right-5 z-50 px-5 py-3.5 rounded-xl shadow-lg border text-sm font-semibold transition-all duration-350 flex items-center gap-2 transform translate-y-2 opacity-0 ${
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
                }, 3500);
            }
        });
    </script>
@endsection
