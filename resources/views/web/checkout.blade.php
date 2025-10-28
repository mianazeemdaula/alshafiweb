@extends('layouts.guest')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-3xl font-bold mb-8">{{ __('Checkout') }}</h1>

            <div id="checkout-container">
                <!-- Loading State -->
                <div id="loading" class="text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    <p class="mt-2">{{ __('Loading checkout...') }}</p>
                </div>

                <!-- Empty Cart -->
                <div id="empty-cart" class="text-center py-12 hidden">
                    <div class="text-gray-500 text-6xl mb-4">🛒</div>
                    <h2 class="text-2xl font-bold text-gray-700 mb-2">{{ __('Your cart is empty') }}</h2>
                    <p class="text-gray-500 mb-6">{{ __('Add some products before checkout!') }}</p>
                    <a href="{{ route('web.products') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                        {{ __('Continue Shopping') }}
                    </a>
                </div>

                <!-- Checkout Form -->
                <div id="checkout-form" class="hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Left Column - Forms -->
                        <div class="lg:col-span-2 space-y-6">

                            <!-- Authentication Section removed per request: existing / new customer UI commented out -->
                            {{--
                                Authentication section (Existing Customer / New Customer) intentionally removed.
                                If you need it back, re-enable the block here.
                            --}}

                            <!-- Shipping Information -->
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <h3 class="text-lg font-semibold mb-4">{{ __('Shipping Information') }}</h3>
                                <form id="shipping-form" class="space-y-4">
                                    @auth
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700 mb-1">{{ __('First Name') }}</label>
                                                <input type="text" name="first_name" value="{{ auth()->user()->name ?? '' }}"
                                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                    required>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                                <input type="text" name="last_name"
                                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                    required>
                                            </div>
                                        </div>
                                    @else
                                        <div class="grid grid-cols-2 gap-4" id="guest-name-fields">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                                <input type="text" name="first_name"
                                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                    required>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                                <input type="text" name="last_name"
                                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                    required>
                                            </div>
                                        </div>
                                    @endauth

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1">{{ __('Phone') }}</label>
                                        <input type="tel" name="phone" pattern="03[0-9]{9}" maxlength="11"
                                            placeholder="03123456789"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            required>
                                        <p class="text-xs text-gray-500 mt-1">Format: 03xxxxxxxxx (e.g. 03123456789)</p>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1">{{ __('Address') }}</label>
                                        <textarea name="address" rows="3"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            required></textarea>
                                    </div>

                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 mb-1">{{ __('City') }}</label>
                                            <input type="text" name="city"
                                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                required>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Order Notes') }}
                                            ({{ __('Optional') }})</label>
                                        <textarea name="notes" rows="3"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="{{ __('Any special instructions?') }}"></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Right Column - Order Summary -->
                        <div class="lg:col-span-1">
                            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                                <h3 class="text-lg font-semibold mb-4">{{ __('Order Summary') }}</h3>

                                <!-- Cart Items -->
                                <div id="checkout-items" class="space-y-3 mb-4 max-h-60 overflow-y-auto">
                                    <!-- Items will be populated by JavaScript -->
                                </div>

                                <!-- Order Totals -->
                                <div class="border-t pt-4 space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span>Subtotal:</span>
                                        <span id="subtotal">RS. 0.00</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span>Shipping:</span>
                                        <span class="text-green-600 font-medium">FREE</span>
                                    </div>
                                    <div class="flex justify-between text-lg font-bold border-t pt-2">
                                        <span>Total:</span>
                                        <span id="total">RS. 0.00</span>
                                    </div>
                                </div>

                                <!-- Payment Method -->
                                <div class="mt-6">
                                    <h4 class="text-md font-semibold mb-3">Payment Method</h4>
                                    <div class="space-y-2">
                                        <label
                                            class="flex items-center space-x-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                            <input type="radio" name="payment_method" value="cod" checked
                                                class="text-blue-600">
                                            <div>
                                                <div class="font-medium">Cash on Delivery</div>
                                                <div class="text-sm text-gray-500">Pay when you receive your order</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Place Order Button -->
                                <button type="button" id="place-order-btn"
                                    class="w-full mt-6 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium text-lg">
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

            // Authentication toggle buttons
            const existingCustomerBtn = document.getElementById('existing-customer-btn');
            const newCustomerBtn = document.getElementById('new-customer-btn');
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');

            if (existingCustomerBtn) {
                existingCustomerBtn.addEventListener('click', function() {
                    this.classList.add('bg-blue-600', 'text-white');
                    this.classList.remove('bg-gray-200', 'text-gray-700');
                    newCustomerBtn.classList.add('bg-gray-200', 'text-gray-700');
                    newCustomerBtn.classList.remove('bg-blue-600', 'text-white');
                    loginForm.classList.remove('hidden');
                    registerForm.classList.add('hidden');
                });

                newCustomerBtn.addEventListener('click', function() {
                    this.classList.add('bg-blue-600', 'text-white');
                    this.classList.remove('bg-gray-200', 'text-gray-700');
                    existingCustomerBtn.classList.add('bg-gray-200', 'text-gray-700');
                    existingCustomerBtn.classList.remove('bg-blue-600', 'text-white');
                    registerForm.classList.remove('hidden');
                    loginForm.classList.add('hidden');
                });
            }

            // Login functionality
            const loginBtn = document.getElementById('login-btn');
            if (loginBtn) {
                loginBtn.addEventListener('click', function() {
                    const email = document.getElementById('login-email').value;
                    const password = document.getElementById('login-password').value;

                    if (!email || !password) {
                        showNotification('Please fill in all fields', 'error');
                        return;
                    }

                    this.disabled = true;
                    this.textContent = 'Logging in...';

                    fetch('/login', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                email: email,
                                password: password
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showNotification('Login successful!', 'success');
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                showNotification(data.message || 'Login failed', 'error');
                            }
                        })
                        .catch(error => {
                            showNotification('Login error occurred', 'error');
                        })
                        .finally(() => {
                            this.disabled = false;
                            this.textContent = 'Login';
                        });
                });
            }

            // Register functionality
            const registerBtn = document.getElementById('register-btn');
            if (registerBtn) {
                registerBtn.addEventListener('click', function() {
                    const firstName = document.getElementById('register-first-name').value;
                    const lastName = document.getElementById('register-last-name').value;
                    const email = document.getElementById('register-email').value;
                    const mobile = document.getElementById('register-mobile').value;
                    const password = document.getElementById('register-password').value;
                    const passwordConfirm = document.getElementById('register-password-confirm').value;

                    if (!firstName || !lastName || !email || !mobile || !password || !passwordConfirm) {
                        showNotification('Please fill in all fields', 'error');
                        return;
                    }

                    if (password !== passwordConfirm) {
                        showNotification('Passwords do not match', 'error');
                        return;
                    }

                    this.disabled = true;
                    this.textContent = 'Creating Account...';

                    fetch('/register', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                name: firstName + ' ' + lastName,
                                email: email,
                                mobile: mobile,
                                password: password,
                                password_confirmation: passwordConfirm
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showNotification('Account created successfully!', 'success');
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                showNotification(data.message || 'Registration failed', 'error');
                            }
                        })
                        .catch(error => {
                            showNotification('Registration error occurred', 'error');
                        })
                        .finally(() => {
                            this.disabled = false;
                            this.textContent = 'Create Account';
                        });
                });
            }

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

                this.disabled = true;
                this.textContent = 'Placing Order...';
                isPlacingOrder = true;

                const orderData = {
                    shipping: Object.fromEntries(formData),
                    payment_method: 'cod'
                };

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
                            }, 1500);
                        } else {
                            showNotification(data.message || 'Order placement failed', 'error');
                            this.disabled = false;
                            this.textContent = 'Place Order';
                            isPlacingOrder = false;
                        }
                    })
                    .catch(error => {
                        showNotification('Order placement error occurred', 'error');
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
                div.className = 'flex items-center space-x-3 py-2';
                div.innerHTML = `
            <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                ${item.image ? `<img src="${item.image}" alt="${item.name[0]}" class="w-full h-full object-cover rounded">` : '📦'}
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-medium">${item.name[0]}</h4>
                <p class="text-xs text-gray-600">Qty: ${item.quantity}</p>
            </div>
            <div class="text-sm font-medium">
                Rs. ${(item.price * item.quantity).toFixed(2)}
            </div>
        `;
                return div;
            }

            // Place order functionality
            const placeOrderBtn = document.getElementById('place-order-btn');
            if (placeOrderBtn) {
                placeOrderBtn.addEventListener('click', function() {
                    const shippingForm = document.getElementById('shipping-form');
                    const formData = new FormData(shippingForm);

                    // Validate required fields
                    const requiredFields = ['first_name', 'last_name', 'phone', 'address', 'city'];
                    for (let field of requiredFields) {
                        if (!formData.get(field)) {
                            showNotification(`Please fill in ${field.replace('_', ' ')}`, 'error');
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
                                    window.location.href =
                                        `/order-confirmation/${data.order_id}`;
                                }, 1500);
                            } else {
                                showNotification(data.message || 'Failed to place order', 'error');
                                this.disabled = false;
                                this.textContent = 'Place Order';
                            }
                        })
                        .catch(error => {
                            console.error('Order placement error:', error);
                            showNotification('Failed to place order. Please try again.', 'error');
                            this.disabled = false;
                            this.textContent = 'Place Order';
                        });
                });
            }

            // Notification function
            function showNotification(message, type = 'info') {
                const existingNotifications = document.querySelectorAll('.checkout-notification');
                existingNotifications.forEach(n => n.remove());

                const notification = document.createElement('div');
                notification.className = `checkout-notification fixed top-4 right-4 z-50 px-6 py-3 rounded shadow-lg text-white font-medium transition-all duration-300 ${
            type === 'success' ? 'bg-green-500' : 
            type === 'error' ? 'bg-red-500' : 'bg-blue-500'
        }`;
                notification.textContent = message;

                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.style.opacity = '0';
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => notification.remove(), 300);
                }, 4000);
            }
        });
    </script>
@endsection
