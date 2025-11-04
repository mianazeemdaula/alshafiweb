@extends('layouts.web')

@section('content')
    <div class="container mx-auto px-2 py-2 order-form-container">
        <div class="bg-white rounded-lg shadow-md p-2">
            <!-- Header -->
            <div class="flex justify-between items-center mb-2">
                <h1 class="text-lg font-bold text-gray-800">Create New Order</h1>
                <a href="{{ route('admin.orders.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded-lg text-sm transition duration-200">
                    <i class="fas fa-arrow-left mr-1"></i>Back
                </a>
            </div>

            <!-- Error Display -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded mb-2">
                    <strong class="font-bold">Error!</strong>
                    <ul class="mt-1 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.orders.store') }}" method="POST" id="orderForm">
                @csrf

                <!-- Customer & Payment Information -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-3">
                    <!-- Customer Information -->
                    <div class="form-section">
                        <h3><i class="fas fa-user mr-2"></i>Customer Information</h3>

                        <!-- Customer Type Selection -->
                        <div class="mb-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Customer Type *</label>
                            <div class="flex gap-3">
                                <label class="flex items-center">
                                    <input type="radio" name="customer_type" value="existing" id="customer_existing"
                                        class="mr-2"
                                        {{ old('customer_type', 'existing') == 'existing' ? 'checked' : '' }}>
                                    <span class="text-sm">Existing Customer</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="customer_type" value="manual" id="customer_manual"
                                        class="mr-2" {{ old('customer_type') == 'manual' ? 'checked' : '' }}>
                                    <span class="text-sm">Manual Entry</span>
                                </label>
                            </div>
                        </div>

                        <!-- Existing Customer Selection -->
                        <div id="existing_customer_section" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Select Customer</label>
                                <select name="user_id" id="user_id"
                                    class="compact-input w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Customer</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method *</label>
                                <select name="payment_method_id" required
                                    class="compact-input w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Payment Method</option>
                                    @foreach ($paymentMethods as $method)
                                        <option value="{{ $method->id }}"
                                            {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>
                                            {{ $method->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Manual Customer Entry -->
                        <div id="manual_customer_section" class="hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Customer Name</label>
                                    <input type="text" name="customer_name" id="customer_name"
                                        value="{{ old('customer_name') }}"
                                        class="compact-input w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Enter customer name">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Customer Email</label>
                                    <input type="email" name="customer_email" id="customer_email"
                                        value="{{ old('customer_email') }}"
                                        class="compact-input w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Enter customer email">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Customer Phone</label>
                                    <input type="text" name="customer_phone" id="customer_phone"
                                        value="{{ old('customer_phone') }}"
                                        class="compact-input w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Enter customer phone">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method *</label>
                                    <select name="payment_method_id_manual" id="payment_method_id_manual"
                                        class="compact-input w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Payment Method</option>
                                        @foreach ($paymentMethods as $method)
                                            <option value="{{ $method->id }}"
                                                {{ old('payment_method_id', 6) == $method->id ? 'selected' : '' }}>
                                                {{ $method->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                @if (auth()->user()->hasRole('team_leader') && $teamMembers->isNotEmpty())
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Assign Order To</label>
                                        <select name="order_taker_id"
                                            class="compact-input w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Myself</option>
                                            @foreach ($teamMembers as $member)
                                                <option value="{{ $member->id }}"
                                                    {{ old('order_taker_id') == $member->id ? 'selected' : '' }}>
                                                    {{ $member->name }} {{ $member->ref_code }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="form-section">
                        <h3><i class="fas fa-shipping-fast mr-2"></i>Shipping Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Country *</label>
                                <select name="country_id" required
                                    class="compact-input w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country_id', 1) == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                                <select name="city_id" required
                                    class="compact-input w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select City</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}"
                                            {{ old('city_id', 1) == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}{{ $city->state ? ', ' . $city->state->name : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Street Address *</label>
                                <input type="text" name="street_address" value="{{ old('street_address') }}" required
                                    placeholder="Enter full street address"
                                    class="compact-input w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ZIP Code</label>
                                <input type="text" name="zip_code" value="{{ old('zip_code', '56180') }}"
                                    placeholder="Postal/ZIP code"
                                    class="compact-input w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Shipping Cost</label>
                                <input type="number" name="shipping_cost" value="{{ old('shipping_cost', '0') }}"
                                    step="0.01" min="0" placeholder="0.00"
                                    class="compact-input w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Section -->
                <div class="form-section">
                    <div class="flex justify-between items-center mb-3">
                        <h3><i class="fas fa-box mr-2"></i>Order Products</h3>
                        <button type="button" id="addProduct"
                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg text-sm transition duration-200">
                            <i class="fas fa-plus mr-1"></i>Add Product
                        </button>
                    </div>

                    <div id="productsContainer">
                        <!-- Products will be added here dynamically -->
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Order Notes</label>
                        <textarea name="extra_note" rows="3" placeholder="Special instructions or notes for this order"
                            class="compact-input w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('extra_note') }}</textarea>
                    </div>

                    <div class="order-summary">
                        <h3 class="text-lg font-semibold mb-3 text-gray-700">Order Summary</h3>
                        <div class="space-y-2 text-sm">
                            <div class="summary-row">
                                <span>Subtotal:</span>
                                <span id="subtotal" class="font-medium">RS 0.00</span>
                            </div>
                            <div class="summary-row">
                                <span>Shipping:</span>
                                <span id="shipping" class="font-medium">RS 0.00</span>
                            </div>
                            <div class="summary-row">
                                <span>Discount:</span>
                                <div>
                                    <input type="number" name="discount" value="{{ old('discount', '0') }}"
                                        step="0.01" min="0" placeholder="0.00" id="discountInput"
                                        class="compact-input w-16 border border-gray-300 rounded px-2 py-1 text-right">
                                </div>
                            </div>
                            <div class="summary-row summary-total">
                                <span>Total:</span>
                                <span id="total">RS 0.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Order Type</label>
                    <select name="type"
                        class="compact-input w-48 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Type</option>
                        @foreach ($types as $k => $v)
                            <option value="{{ $k }}" {{ old('type') == $k ? 'selected' : '' }}>
                                {{ $v }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                        <i class="fas fa-save mr-2"></i>Create Order
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let productIndex = 0;

                // Add product row
                document.getElementById('addProduct').addEventListener('click', function() {
                    const productOptions = `@foreach ($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">
                            {{ $product->name }} - RS {{ number_format($product->price, 2) }} (Stock: {{ $product->stock }})
                        </option>
                    @endforeach`;

                    const newRow = `
                        <div class="bg-gray-50 p-3 rounded-lg mb-3">
                            <div class="product-row grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Product *</label>
                                    <select name="products[${productIndex}][id]" required class="product-select compact-input w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Product</option>
                                        ${productOptions}
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Qty *</label>
                                    <input type="number" name="products[${productIndex}][quantity]" min="1" value="1" required class="quantity-input compact-input w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Price *</label>
                                    <input type="number" name="products[${productIndex}][price]" step="0.01" min="0" required class="price-input compact-input w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div class="text-center">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Total</label>
                                    <div class="line-total">RS 0.00</div>
                                </div>
                                <div class="text-center">
                                    <button type="button" class="remove-product bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm transition duration-200">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;

                    document.getElementById('productsContainer').insertAdjacentHTML('beforeend', newRow);
                    attachProductEvents();
                    productIndex++;
                    updateOrderSummary();
                });

                // Simple event attachment
                function attachProductEvents() {
                    // Remove previous listeners and add new ones
                    document.querySelectorAll('.remove-product').forEach(btn => {
                        btn.onclick = function() {
                            this.closest('.bg-gray-50').remove();
                            updateOrderSummary();
                        };
                    });

                    document.querySelectorAll('.product-select').forEach(select => {
                        select.onchange = function() {
                            const option = this.options[this.selectedIndex];
                            const price = option.dataset.price || 0;
                            const priceInput = this.closest('.product-row').querySelector('.price-input');
                            priceInput.value = parseFloat(price).toFixed(2);
                            updateLineTotal(this.closest('.product-row'));
                            updateOrderSummary();
                        };
                    });

                    document.querySelectorAll('.quantity-input, .price-input').forEach(input => {
                        input.oninput = function() {
                            updateLineTotal(this.closest('.product-row'));
                            updateOrderSummary();
                        };
                    });
                }

                function updateLineTotal(row) {
                    const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
                    const price = parseFloat(row.querySelector('.price-input').value) || 0;
                    const total = quantity * price;
                    row.querySelector('.line-total').textContent = 'RS ' + total.toFixed(2);
                }

                function updateOrderSummary() {
                    let subtotal = 0;
                    document.querySelectorAll('.product-row').forEach(row => {
                        const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
                        const price = parseFloat(row.querySelector('.price-input').value) || 0;
                        subtotal += quantity * price;
                    });

                    const shipping = parseFloat(document.querySelector('input[name="shipping_cost"]').value) || 0;
                    const discount = parseFloat(document.querySelector('input[name="discount"]').value) || 0;
                    const total = subtotal + shipping - discount;

                    document.getElementById('subtotal').textContent = 'RS ' + subtotal.toFixed(2);
                    document.getElementById('shipping').textContent = 'RS ' + shipping.toFixed(2);
                    document.getElementById('total').textContent = 'RS ' + total.toFixed(2);
                }

                // Event listeners for shipping and discount
                document.querySelector('input[name="shipping_cost"]').oninput = updateOrderSummary;
                document.getElementById('discountInput').oninput = updateOrderSummary;

                // Add first product row
                document.getElementById('addProduct').click();

                // Customer type toggle functionality
                function toggleCustomerType() {
                    const existingSection = document.getElementById('existing_customer_section');
                    const manualSection = document.getElementById('manual_customer_section');
                    const userIdSelect = document.getElementById('user_id');
                    const customerFields = ['customer_name', 'customer_email', 'customer_phone'];
                    const paymentMethodSelect = document.querySelector('select[name="payment_method_id"]');
                    const paymentMethodManualSelect = document.getElementById('payment_method_id_manual');

                    if (document.getElementById('customer_existing').checked) {
                        existingSection.classList.remove('hidden');
                        manualSection.classList.add('hidden');
                        userIdSelect.required = true;

                        // Clear manual fields and remove required
                        customerFields.forEach(fieldName => {
                            const field = document.getElementById(fieldName);
                            if (field) {
                                field.value = '';
                                field.required = false;
                            }
                        });

                        paymentMethodSelect.required = true;
                        paymentMethodSelect.disabled = false;
                        paymentMethodManualSelect.required = false;
                        paymentMethodManualSelect.disabled = true;
                    } else {
                        existingSection.classList.add('hidden');
                        manualSection.classList.remove('hidden');
                        manualSection.querySelector('.grid').classList.add('grid', 'grid-cols-1', 'md:grid-cols-2',
                            'gap-3');

                        userIdSelect.required = false;
                        userIdSelect.value = '';

                        // Make manual fields required
                        document.getElementById('customer_name').required = true;

                        paymentMethodSelect.required = false;
                        paymentMethodSelect.disabled = true;
                        paymentMethodManualSelect.required = true;
                        paymentMethodManualSelect.disabled = false;
                    }
                }

                // Initialize customer type on page load
                toggleCustomerType();

                // Add event listeners for customer type radio buttons
                document.getElementById('customer_existing').addEventListener('change', toggleCustomerType);
                document.getElementById('customer_manual').addEventListener('change', toggleCustomerType);

                // Form validation
                document.getElementById('orderForm').onsubmit = function(e) {
                    const products = document.querySelectorAll('.product-row');
                    if (products.length === 0) {
                        e.preventDefault();
                        alert('Please add at least one product to the order.');
                        return false;
                    }

                    // Additional validation for manual customer entry
                    if (document.getElementById('customer_manual').checked) {
                        const customerName = document.getElementById('customer_name').value.trim();
                        if (!customerName) {
                            e.preventDefault();
                            alert('Please enter customer name for manual entry.');
                            return false;
                        }
                    }
                };
            });
        </script>
    @endpush
@endsection
