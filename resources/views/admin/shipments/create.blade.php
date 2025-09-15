@extends('layouts.web')

@section('content')
    <div class="container mx-auto px-2 py-2">
        <div class="bg-white rounded-lg shadow-md p-2">
            <!-- Header -->
            <div class="flex items-center mb-2">
                <a href="{{ route('admin.shipments.index') }}" class="text-blue-600 hover:text-blue-800 mr-2">
                    <i class="fas fa-arrow-left mr-1"></i>Back to Shipments
                </a>
                <h1 class="text-xl font-bold text-gray-800">Create New Shipment</h1>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-2 py-2 rounded mb-2">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.shipments.store') }}" method="POST" class="space-y-2">
                @csrf

                <!-- Order Selection -->
                <div class="bg-gray-50 rounded-lg p-2">
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Order Information</h3>

                    @if ($order)
                        <!-- Pre-selected order -->
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <div class="bg-white rounded-lg p-2 border">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-900">Order #{{ $order->id }}</h4>
                                    <p class="text-sm text-gray-600">
                                        Customer: {{ $order->user ? $order->user->name : $order->customer_name ?? 'N/A' }}
                                    </p>
                                    <p class="text-sm text-gray-600">Total: RS {{ number_format($order->total_amount, 2) }}
                                    </p>
                                    <p class="text-sm text-gray-600">Status: {{ ucfirst($order->status) }}</p>
                                    <p class="text-sm text-gray-600">
                                        Phone: {{ $order->user ? $order->user->phone : $order->customer_phone ?? 'N/A' }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        Email: {{ $order->user ? $order->user->email : $order->customer_email ?? 'N/A' }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        Address: {{ $order->delivery_address ?? 'N/A' }}
                                    </p>
                                </div>
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                    class="text-blue-600 hover:text-blue-800 text-sm">
                                    View Order
                                </a>
                            </div>
                            <div class="mt-1">
                                <p class="text-sm text-gray-600">Items:</p>
                                <ul class="text-sm text-gray-500 ml-2">
                                    @foreach ($order->orderDetails as $detail)
                                        <li>{{ $detail->product->name ?? 'Product' }} (Qty: {{ $detail->qty }})</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @else
                        <!-- Order selection dropdown -->
                        <div>
                            <label for="order_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Select Order <span class="text-red-500">*</span>
                            </label>
                            <select name="order_id" id="order_id"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-blue-500 focus:border-blue-500"
                                onchange="loadOrderDetails()" required>
                                <option value="">Choose an order to ship</option>
                                @foreach ($orders as $orderOption)
                                    <option value="{{ $orderOption->id }}"
                                        {{ old('order_id') == $orderOption->id ? 'selected' : '' }}>
                                        Order #{{ $orderOption->id }} -
                                        {{ $orderOption->user ? $orderOption->user->name : $orderOption->customer_name ?? 'N/A' }}
                                        -
                                        RS {{ number_format($orderOption->total_amount, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="orderDetails" class="mt-2 hidden"></div>
                    @endif
                </div>

                <!-- Courier Selection -->
                <div>
                    <label for="courier_service_config_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Courier Service <span class="text-red-500">*</span>
                    </label>
                    <select name="courier_service_config_id" id="courier_service_config_id"
                        class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-blue-500 focus:border-blue-500"
                        onchange="loadPickupAddresses()" required>
                        <option value="">Select Courier Service</option>
                        @foreach ($courierServices as $service)
                            <option value="{{ $service->id }}" data-courier="{{ $service->courier }}"
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
                <div class="bg-gray-50 rounded-lg p-2">
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Package Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                        <div>
                            <label for="weight" class="block text-sm font-medium text-gray-700 mb-1">
                                Weight (kg) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="weight" id="weight" step="0.001" min="0.1" max="999"
                                value="{{ old('weight', '0.5') }}"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="0.5" required>
                        </div>

                        <div>
                            <label for="declared_value" class="block text-sm font-medium text-gray-700 mb-1">
                                Declared Value (RS)
                            </label>
                            <input type="number" name="declared_value" id="declared_value" step="0.01" min="0"
                                value="{{ old('declared_value') }}"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Auto-filled from order">
                        </div>

                        <div>
                            <label for="cod_amount" class="block text-sm font-medium text-gray-700 mb-1">
                                COD Amount (RS)
                            </label>
                            <input type="number" name="cod_amount" id="cod_amount" step="0.01" min="0"
                                value="{{ old('cod_amount') }}"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Auto-filled from order">
                        </div>
                    </div>

                    <div class="mt-2">
                        <label for="special_instructions" class="block text-sm font-medium text-gray-700 mb-1">
                            Special Instructions
                        </label>
                        <textarea name="special_instructions" id="special_instructions" rows="2"
                            class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Any special handling instructions...">{{ old('special_instructions', 'MUST MAKE CALL TO THE CUSTOMER AND SHIPPER BEFORE RETURNING AND DON\'T FAKE REASON') }}</textarea>
                    </div>
                </div>

                <!-- Pickup Address -->
                <div class="bg-gray-50 rounded-lg p-2">
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Pickup Address</h3>

                    <!-- Pickup Address Type Selection -->
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pickup Address Type</label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="pickup_type" value="existing" onchange="togglePickupType()"
                                    class="mr-1" checked>
                                <span class="text-sm">Existing Address</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="pickup_type" value="manual" onchange="togglePickupType()"
                                    class="mr-1">
                                <span class="text-sm">Manual Address</span>
                            </label>
                        </div>
                    </div>

                    <!-- Existing Pickup Addresses -->
                    <div id="existingPickupSection">
                        <div class="mb-2">
                            <label for="pickup_address_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Select Pickup Address <span class="text-red-500">*</span>
                            </label>
                            <select name="pickup_address_id" id="pickup_address_id"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select courier first to load addresses</option>
                            </select>
                        </div>
                        <div id="selectedPickupDetails" class="text-sm text-gray-600 mt-1 hidden"></div>
                    </div>

                    <!-- Manual Pickup Address -->
                    <div id="manualPickupSection" class="hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <div>
                                <label for="pickup_name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Contact Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="pickup_name" id="pickup_name"
                                    value="{{ old('pickup_name', 'Alshaafi Store') }}"
                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Contact person name">
                            </div>

                            <div>
                                <label for="pickup_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="pickup_phone" id="pickup_phone"
                                    value="{{ old('pickup_phone', '03223236262') }}"
                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Phone number">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-2">
                            <div>
                                <label for="pickup_address" class="block text-sm font-medium text-gray-700 mb-1">
                                    Address <span class="text-red-500">*</span>
                                </label>
                                <textarea name="pickup_address" id="pickup_address" rows="2"
                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Complete pickup address">{{ old('pickup_address', 'Al-Shaafi Dawakhana DPA') }}</textarea>
                            </div>

                            <div>
                                <label for="pickup_city" class="block text-sm font-medium text-gray-700 mb-1">
                                    City <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="pickup_city" id="pickup_city"
                                    value="{{ old('pickup_city') }}"
                                    class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="City name">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivery Address -->
                <div class="bg-gray-50 rounded-lg p-2">
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Delivery Address</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div>
                            <label for="delivery_name" class="block text-sm font-medium text-gray-700 mb-1">
                                Customer Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="delivery_name" id="delivery_name"
                                value="{{ old('delivery_name') ?? $order->user ? $order->user->name : $order->customer_name ?? '' }}"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Customer name" required>
                        </div>

                        <div>
                            <label for="delivery_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="delivery_phone" id="delivery_phone"
                                value="{{ old('delivery_phone') ?? $order->user ? $order->user->phone : $order->customer_phone ?? '' }}"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Customer phone" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-2">
                        <div>
                            <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-1">
                                Address <span class="text-red-500">*</span>
                            </label>
                            <textarea name="delivery_address" id="delivery_address" rows="2"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Complete delivery address" required>{{ old('delivery_address') ?? ($order->street_address ?? '') }}</textarea>
                        </div>

                        <div>
                            <label for="delivery_city_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Delivery City <span class="text-red-500">*</span>
                            </label>
                            <select name="delivery_city_id" id="delivery_city_id"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-blue-500 focus:border-blue-500"
                                required disabled>
                                <option value="">First select a courier service</option>
                            </select>
                            <div id="delivery_city_loading" class="hidden mt-1 text-blue-600 text-sm">
                                <i class="fas fa-spinner fa-spin mr-1"></i>Loading cities...
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-2 pt-2 border-t">
                    <a href="{{ route('admin.shipments.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-1 rounded-lg transition duration-200">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded-lg transition duration-200">
                        <i class="fas fa-shipping-fast mr-1"></i>Create & Book Shipment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentPickupAddresses = [];

        console.log(`{{ route('admin.shipments.courier.cities') }}`);

        function loadOrderDetails() {
            const orderId = document.getElementById('order_id').value;
            const detailsDiv = document.getElementById('orderDetails');

            if (!orderId) {
                detailsDiv.classList.add('hidden');
                clearDeliveryFields();
                return;
            }

            detailsDiv.classList.remove('hidden');
            detailsDiv.innerHTML =
                '<div class="text-center py-2"><i class="fas fa-spinner fa-spin"></i> Loading order details...</div>';

            // Load order details and auto-fill delivery information directly
            fillOrderDetails(orderId);
        }

        function fillOrderDetails(orderId) {
            // Get order details via AJAX using Laravel route
            console.log('Loading order details for order ID:', orderId);
            fetch(`{{ route('admin.orders.api.show', '') }}/${orderId}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                })
                .then(response => {
                    console.log('Order details response status:', response.status);
                    console.log('Order details response:', response);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(order => {
                    console.log('Order details data:', order);

                    // Check if elements exist
                    const nameField = document.getElementById('delivery_name');
                    const phoneField = document.getElementById('delivery_phone');
                    const addressField = document.getElementById('delivery_address');

                    console.log('Form fields found:', {
                        nameField: !!nameField,
                        phoneField: !!phoneField,
                        addressField: !!addressField
                    });

                    // Fill delivery information
                    const customerName = order.user ? order.user.name : (order.customer_name || '');
                    const customerPhone = order.user ? order.user.phone : (order.customer_phone || '');
                    const customerEmail = order.user ? order.user.email : (order.customer_email || '');
                    const deliveryAddress = order.street_address || '';

                    if (nameField) nameField.value = customerName;
                    if (phoneField) phoneField.value = customerPhone;
                    if (addressField) addressField.value = deliveryAddress;

                    console.log('Filled fields:', {
                        customerName,
                        customerPhone,
                        deliveryAddress,
                        cityId: order.city_id
                    });

                    // Set delivery city if available
                    if (order.city_id) {
                        const citySelect = document.getElementById('delivery_city_id');
                        const courierServiceId = document.getElementById('courier_service_config_id').value;

                        // If courier is selected but cities aren't loaded yet, load them first
                        if (courierServiceId && citySelect.options.length <= 1) {
                            console.log('Loading cities first, then setting delivery city...');

                            // Load cities first, then set the delivery city
                            loadCourierCities().then(() => {
                                setTimeout(() => {
                                    const cityOption = citySelect.querySelector(
                                        `option[value="${order.city_id}"]`);
                                    if (cityOption) {
                                        citySelect.value = order.city_id;
                                        console.log('Set delivery city to:', order.city ? order.city
                                            .name : order.city_id);
                                    } else {
                                        console.log('City ID', order.city_id,
                                            'not found in dropdown options after loading');
                                    }
                                }, 500); // Small delay to ensure cities are loaded
                            });
                        } else {
                            // Cities are already loaded, just set the value
                            const cityOption = citySelect.querySelector(`option[value="${order.city_id}"]`);
                            if (cityOption) {
                                citySelect.value = order.city_id;
                                console.log('Set delivery city to:', order.city ? order.city.name : order.city_id);
                            } else {
                                console.log('City ID', order.city_id, 'not found in dropdown options');
                            }
                        }
                    }

                    // Fill package details
                    document.getElementById('declared_value').value = order.total_amount || '';
                    document.getElementById('cod_amount').value = order.total_amount || '';

                    // Show order details
                    const detailsDiv = document.getElementById('orderDetails');
                    const cityName = order.city ? order.city.name : 'N/A';
                    const countryName = order.country ? order.country.name : 'N/A';
                    const fullAddress = deliveryAddress + (cityName !== 'N/A' ? `, ${cityName}` : '') + (countryName !==
                        'N/A' ? `, ${countryName}` : '');

                    detailsDiv.innerHTML = `
                    <div class="bg-white rounded-lg p-2 border">
                        <h4 class="font-medium text-gray-900">Order #${order.id}</h4>
                        <p class="text-sm text-gray-600">Customer: ${customerName}</p>
                        <p class="text-sm text-gray-600">Phone: ${customerPhone}</p>
                        <p class="text-sm text-gray-600">Total: RS ${parseFloat(order.total_amount || 0).toFixed(2)}</p>
                        <p class="text-sm text-gray-600">Address: ${fullAddress}</p>
                        <p class="text-sm text-gray-600">City: ${cityName}</p>
                    </div>
                `;
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('orderDetails').innerHTML =
                        '<div class="text-red-600 text-sm">Order details not available</div>';
                });
        }

        function clearDeliveryFields() {
            document.getElementById('delivery_name').value = '';
            document.getElementById('delivery_phone').value = '';
            document.getElementById('delivery_address').value = '';
            document.getElementById('delivery_city_id').value = '';
            document.getElementById('declared_value').value = '';
            document.getElementById('cod_amount').value = '';
        }

        function togglePickupType() {
            const pickupType = document.querySelector('input[name="pickup_type"]:checked').value;
            const existingSection = document.getElementById('existingPickupSection');
            const manualSection = document.getElementById('manualPickupSection');

            if (pickupType === 'existing') {
                existingSection.classList.remove('hidden');
                manualSection.classList.add('hidden');
                // Remove required attributes from manual fields
                manualSection.querySelectorAll('input[required], textarea[required]').forEach(el => {
                    el.removeAttribute('required');
                });
                // Add required to pickup address selection
                document.getElementById('pickup_address_id').setAttribute('required', '');
            } else {
                existingSection.classList.add('hidden');
                manualSection.classList.remove('hidden');
                // Add required attributes to manual fields
                manualSection.querySelectorAll('input, textarea').forEach(el => {
                    if (el.name.startsWith('pickup_')) {
                        el.setAttribute('required', '');
                    }
                });
                // Remove required from pickup address selection
                document.getElementById('pickup_address_id').removeAttribute('required');
            }
        }

        function loadPickupAddresses() {
            console.log('Loading pickup addresses...');
            const courierSelect = document.getElementById('courier_service_config_id');
            const courier = courierSelect.options[courierSelect.selectedIndex]?.getAttribute('data-courier');
            const pickupSelect = document.getElementById('pickup_address_id');

            console.log('Selected courier:', courier);

            if (!courier) {
                pickupSelect.innerHTML = '<option value="">Select courier first</option>';
                loadCourierCities();
                return;
            }

            pickupSelect.innerHTML = '<option value="">Loading pickup addresses...</option>';

            // Simple fetch for pickup addresses
            fetch(`{{ route('admin.shipments.pickup-addresses') }}?courier=${courier}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                })
                .then(response => {
                    console.log('Pickup addresses response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Pickup addresses data:', data);
                    if (data.success && data.addresses && data.addresses.length > 0) {
                        currentPickupAddresses = data.addresses;
                        pickupSelect.innerHTML = '<option value="">Select pickup address</option>';

                        data.addresses.forEach(address => {
                            const option = document.createElement('option');
                            option.value = address.id;
                            option.textContent = `${address.person_of_contact} - ${address.address}`;
                            option.setAttribute('data-details', JSON.stringify(address));
                            pickupSelect.appendChild(option);
                        });
                    } else {
                        pickupSelect.innerHTML = '<option value="">No pickup addresses available</option>';
                        document.querySelector('input[name="pickup_type"][value="manual"]').checked = true;
                        togglePickupType();
                    }
                })
                .catch(error => {
                    console.error('Error loading pickup addresses:', error);
                    pickupSelect.innerHTML = '<option value="">Error loading addresses</option>';
                    document.querySelector('input[name="pickup_type"][value="manual"]').checked = true;
                    togglePickupType();
                });

            // Also load cities
            loadCourierCities();
        }

        function showPickupDetails() {
            const pickupSelect = document.getElementById('pickup_address_id');
            const selectedOption = pickupSelect.options[pickupSelect.selectedIndex];
            const detailsDiv = document.getElementById('selectedPickupDetails');

            if (selectedOption.value && selectedOption.getAttribute('data-details')) {
                const details = JSON.parse(selectedOption.getAttribute('data-details'));
                detailsDiv.innerHTML = `
                    <strong>Contact:</strong> ${details.person_of_contact}<br>
                    <strong>Phone:</strong> ${details.phone_number}<br>
                    <strong>Address:</strong> ${details.address}<br>
                    <strong>City:</strong> ${details.city ? details.city.name : 'N/A'}
                `;
                detailsDiv.classList.remove('hidden');
            } else {
                detailsDiv.classList.add('hidden');
            }
        }

        function loadCourierCities() {
            console.log('Loading courier cities...');
            const courierServiceId = document.getElementById('courier_service_config_id').value;
            const citySelect = document.getElementById('delivery_city_id');
            const loadingDiv = document.getElementById('delivery_city_loading');

            console.log('Selected courier service ID:', courierServiceId);

            if (!courierServiceId) {
                citySelect.disabled = true;
                citySelect.innerHTML = '<option value="">First select a courier service</option>';
                return Promise.resolve();
            }

            loadingDiv.classList.remove('hidden');
            citySelect.disabled = true;
            citySelect.innerHTML = '<option value="">Loading cities...</option>';

            // Simple fetch for cities - return the promise
            return fetch(`{{ route('admin.shipments.courier.cities') }}?courier_service_id=${courierServiceId}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                })
                .then(response => {
                    console.log('Cities response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Cities data:', data);
                    loadingDiv.classList.add('hidden');

                    if (data.success) {
                        citySelect.innerHTML = '<option value="">Select delivery city</option>';

                        let cities = [];
                        if (data.data && Array.isArray(data.data)) {
                            cities = data.data;
                        } else if (data.data && data.data.cities && Array.isArray(data.data.cities)) {
                            cities = data.data.cities;
                        } else if (data.data && data.data.data && Array.isArray(data.data.data)) {
                            cities = data.data.data;
                        }

                        console.log('Processing cities:', cities.length);

                        cities.forEach(city => {
                            const option = document.createElement('option');
                            if (typeof city === 'object') {
                                option.value = city.id || city.city_id || city.code || city.name;
                                option.textContent = city.name || city.city_name || city.title || city.id;
                            } else {
                                option.value = city;
                                option.textContent = city;
                            }
                            citySelect.appendChild(option);
                        });

                        citySelect.disabled = false;
                        console.log('Cities loaded successfully');
                    } else {
                        citySelect.innerHTML = '<option value="">Failed to load cities</option>';
                        console.error('Failed to load cities:', data.message);
                    }
                })
                .catch(error => {
                    loadingDiv.classList.add('hidden');
                    citySelect.innerHTML = '<option value="">Error loading cities</option>';
                    console.error('Error:', error);
                });
        } // Event listeners
        document.getElementById('courier_service_config_id').addEventListener('change', loadPickupAddresses);
        document.getElementById('pickup_address_id').addEventListener('change', showPickupDetails);
        document.getElementById('order_id')?.addEventListener('change', loadOrderDetails);

        // Initialize pickup type toggle
        document.addEventListener('DOMContentLoaded', function() {
            togglePickupType();

            // Auto-load order details if order is pre-selected
            const orderId = document.getElementById('order_id')?.value;
            if (orderId) {
                loadOrderDetails();
            }
        });
    </script>
@endsection
