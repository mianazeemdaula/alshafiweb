@extends('layouts.web')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Create Specialist Order</h1>
                <a href="{{ route('admin.specialist-orders.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </a>
            </div>

            <!-- Error Display -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <strong class="font-bold">Error!</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.specialist-orders.store') }}" method="POST" id="specialistOrderForm">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Customer Information -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-user mr-2"></i>Customer Information
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Customer Name *</label>
                                <input type="text" name="customer_name" value="{{ old('customer_name') }}" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter customer name">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Customer Phone *</label>
                                <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter phone number">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Customer Email</label>
                                <input type="email" name="customer_email" value="{{ old('customer_email') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter email (optional)">
                            </div>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-shopping-cart mr-2"></i>Order Details
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Order Type *</label>
                                <select name="type" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Type</option>
                                    @foreach ($types as $key => $value)
                                        <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method *</label>
                                <select name="payment_method_id" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Payment Method</option>
                                    @foreach ($paymentMethods as $method)
                                        <option value="{{ $method->id }}"
                                            {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>
                                            {{ $method->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Extra Note</label>
                                <textarea name="extra_note" rows="2"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Any additional notes">{{ old('extra_note') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-gray-50 rounded-lg p-4 mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-map-marker-alt mr-2"></i>Shipping Address
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Country *</label>
                            <select name="country_id" id="country_id" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                            <select name="city_id" id="city_id" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select City</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}"
                                        {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }} ({{ $city->state->name ?? '' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Street Address *</label>
                            <input type="text" name="street_address" value="{{ old('street_address') }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter street address">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Zip Code</label>
                            <input type="text" name="zip_code" value="{{ old('zip_code') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter zip code">
                        </div>
                    </div>
                </div>

                <!-- Products Section -->
                <div class="bg-gray-50 rounded-lg p-4 mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-box mr-2"></i>Products
                    </h3>

                    <div id="products-container" class="space-y-3">
                        <div class="product-row grid grid-cols-12 gap-3 items-center bg-white p-3 rounded-lg">
                            <div class="col-span-7">
                                <select name="products[0][product_id]" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 product-select">
                                    <option value="">Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                            {{ $product->name }} - Rs {{ number_format($product->price) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-3">
                                <input type="number" name="products[0][quantity]" value="1" min="1" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 product-quantity"
                                    placeholder="Qty">
                            </div>
                            <div class="col-span-2 text-right">
                                <button type="button" class="text-red-500 hover:text-red-700 remove-product">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add-product"
                        class="mt-3 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-plus mr-2"></i>Add Another Product
                    </button>
                </div>

                <!-- Pricing -->
                <div class="bg-gray-50 rounded-lg p-4 mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-calculator mr-2"></i>Pricing
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Shipping Cost</label>
                            <input type="number" name="shipping_cost" value="{{ old('shipping_cost', 0) }}"
                                min="0" step="0.01"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="0">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Discount</label>
                            <input type="number" name="discount" value="{{ old('discount', 0) }}" min="0"
                                step="0.01"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="0">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('admin.specialist-orders.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg transition duration-200">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-save mr-2"></i>Create Order
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let productIndex = 1;

        document.getElementById('add-product').addEventListener('click', function() {
            const container = document.getElementById('products-container');
            const newRow = document.createElement('div');
            newRow.className = 'product-row grid grid-cols-12 gap-3 items-center bg-white p-3 rounded-lg';
            newRow.innerHTML = `
                <div class="col-span-7">
                    <select name="products[${productIndex}][product_id]" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 product-select">
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                {{ $product->name }} - Rs {{ number_format($product->price) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-3">
                    <input type="number" name="products[${productIndex}][quantity]" value="1" min="1" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 product-quantity"
                        placeholder="Qty">
                </div>
                <div class="col-span-2 text-right">
                    <button type="button" class="text-red-500 hover:text-red-700 remove-product">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            container.appendChild(newRow);
            productIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-product') || e.target.parentElement.classList.contains(
                    'remove-product')) {
                const row = e.target.closest('.product-row');
                if (document.querySelectorAll('.product-row').length > 1) {
                    row.remove();
                } else {
                    alert('At least one product is required');
                }
            }
        });
    </script>
@endsection
