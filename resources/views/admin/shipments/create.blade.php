@extends('layouts.web')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Header -->
            <div class="flex items-center mb-6">
                <a href="{{ route('admin.shipments.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Shipments
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Create New Shipment</h1>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.shipments.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Order Selection -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Order Information</h3>

                    @if ($order)
                        <!-- Pre-selected order -->
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <div class="bg-white rounded-lg p-4 border">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-900">Order #{{ $order->id }}</h4>
                                    <p class="text-sm text-gray-600">Customer: {{ $order->user->name ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-600">Total: ${{ number_format($order->total_amount, 2) }}
                                    </p>
                                    <p class="text-sm text-gray-600">Status: {{ ucfirst($order->status) }}</p>
                                </div>
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                    class="text-blue-600 hover:text-blue-800 text-sm">
                                    View Order
                                </a>
                            </div>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600">Items:</p>
                                <ul class="text-sm text-gray-500 ml-4">
                                    @foreach ($order->orderDetails as $detail)
                                        <li>{{ $detail->product->name ?? 'Product' }} (Qty: {{ $detail->quantity }})</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @else
                        <!-- Order selection dropdown -->
                        <div>
                            <label for="order_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Select Order <span class="text-red-500">*</span>
                            </label>
                            <select name="order_id" id="order_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                onchange="loadOrderDetails()" required>
                                <option value="">Choose an order to ship</option>
                                @foreach ($orders as $orderOption)
                                    <option value="{{ $orderOption->id }}"
                                        {{ old('order_id') == $orderOption->id ? 'selected' : '' }}>
                                        Order #{{ $orderOption->id }} - {{ $orderOption->user->name ?? 'N/A' }} -
                                        ${{ number_format($orderOption->total_amount, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="orderDetails" class="mt-4 hidden"></div>
                    @endif
                </div>

                <!-- Courier Selection -->
                <div>
                    <label for="courier_service_config_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Courier Service <span class="text-red-500">*</span>
                    </label>
                    <select name="courier_service_config_id" id="courier_service_config_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="">Select Courier Service</option>
                        @foreach ($courierServices as $service)
                            <option value="{{ $service->id }}"
                                {{ old('courier_service_config_id') == $service->id ? 'selected' : '' }}>
                                {{ ucfirst($service->courier) }}
                                @if ($service->isSandbox())
                                    (Sandbox)
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Package Details -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Package Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">
                                Weight (kg) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="weight" id="weight" step="0.001" min="0.1" max="999"
                                value="{{ old('weight', '1.000') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="1.000" required>
                        </div>

                        <div>
                            <label for="declared_value" class="block text-sm font-medium text-gray-700 mb-2">
                                Declared Value ($)
                            </label>
                            <input type="number" name="declared_value" id="declared_value" step="0.01" min="0"
                                value="{{ old('declared_value') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Auto-filled from order">
                        </div>

                        <div>
                            <label for="cod_amount" class="block text-sm font-medium text-gray-700 mb-2">
                                COD Amount ($)
                            </label>
                            <input type="number" name="cod_amount" id="cod_amount" step="0.01" min="0"
                                value="{{ old('cod_amount') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Auto-filled from order">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="special_instructions" class="block text-sm font-medium text-gray-700 mb-2">
                            Special Instructions
                        </label>
                        <textarea name="special_instructions" id="special_instructions" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Any special handling instructions...">{{ old('special_instructions') }}</textarea>
                    </div>
                </div>

                <!-- Pickup Address -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Pickup Address</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="pickup_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Contact Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="pickup_name" id="pickup_name"
                                value="{{ old('pickup_name', 'Alshaafi Store') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Contact person name" required>
                        </div>

                        <div>
                            <label for="pickup_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="pickup_phone" id="pickup_phone"
                                value="{{ old('pickup_phone') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Phone number" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="pickup_address" class="block text-sm font-medium text-gray-700 mb-2">
                                Address <span class="text-red-500">*</span>
                            </label>
                            <textarea name="pickup_address" id="pickup_address" rows="3"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Complete pickup address" required>{{ old('pickup_address') }}</textarea>
                        </div>

                        <div>
                            <label for="pickup_city" class="block text-sm font-medium text-gray-700 mb-2">
                                City <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="pickup_city" id="pickup_city" value="{{ old('pickup_city') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="City name" required>
                        </div>
                    </div>
                </div>

                <!-- Delivery Address -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Delivery Address</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="delivery_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Customer Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="delivery_name" id="delivery_name"
                                value="{{ old('delivery_name', $order->user->name ?? '') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Customer name" required>
                        </div>

                        <div>
                            <label for="delivery_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="delivery_phone" id="delivery_phone"
                                value="{{ old('delivery_phone', $order->user->phone ?? '') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Customer phone" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-2">
                                Address <span class="text-red-500">*</span>
                            </label>
                            <textarea name="delivery_address" id="delivery_address" rows="3"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Complete delivery address" required>{{ old('delivery_address', $order->street_address ?? '') }}</textarea>
                        </div>

                        <div>
                            <label for="delivery_city" class="block text-sm font-medium text-gray-700 mb-2">
                                City <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="delivery_city" id="delivery_city"
                                value="{{ old('delivery_city', $order->city->name ?? '') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="City name" required>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3 pt-6 border-t">
                    <a href="{{ route('admin.shipments.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-shipping-fast mr-2"></i>Create & Book Shipment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function loadOrderDetails() {
            const orderId = document.getElementById('order_id').value;
            const detailsDiv = document.getElementById('orderDetails');

            if (!orderId) {
                detailsDiv.classList.add('hidden');
                return;
            }

            // You can implement an AJAX call here to load order details
            detailsDiv.classList.remove('hidden');
            detailsDiv.innerHTML =
                '<div class="text-center py-4"><i class="fas fa-spinner fa-spin"></i> Loading order details...</div>';

            // For now, just show a placeholder
            setTimeout(() => {
                detailsDiv.innerHTML =
                    '<div class="bg-white rounded-lg p-4 border"><p class="text-sm text-gray-600">Order details will be loaded here</p></div>';
            }, 500);
        }

        // Auto-fill delivery address when order is selected (if implemented)
        document.getElementById('order_id')?.addEventListener('change', function() {
            // You can implement logic to auto-fill delivery address from selected order
        });
    </script>
@endsection
