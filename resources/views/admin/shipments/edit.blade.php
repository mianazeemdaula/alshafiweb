@extends('layouts.web')

@section('content')
    <div class="container mx-auto px-2 py-2">
        <div class="bg-white rounded-lg shadow-md p-2">
            <!-- Header -->
            <div class="flex items-center mb-2">
                <a href="{{ route('admin.shipments.show', $shipment->id) }}" class="text-blue-600 hover:text-blue-800 mr-2">
                    <i class="fas fa-arrow-left mr-1"></i>Back to Shipment
                </a>
                <h1 class="text-xl font-bold text-gray-800">Edit Shipment #{{ $shipment->id }}</h1>
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

            <form action="{{ route('admin.shipments.update', $shipment->id) }}" method="POST" class="space-y-2">
                @csrf
                @method('PUT')

                <!-- Current Information -->
                <div class="bg-gray-50 rounded-lg p-2">
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Current Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                        <div>
                            <span class="text-sm font-medium text-gray-600">Order:</span>
                            <div class="text-gray-900">
                                <a href="{{ route('admin.orders.show', $shipment->order->id) }}"
                                    class="text-blue-600 hover:text-blue-800">
                                    Order #{{ $shipment->order->id }}
                                </a>
                            </div>
                        </div>

                        <div>
                            <span class="text-sm font-medium text-gray-600">Courier:</span>
                            <div class="text-gray-900">{{ ucfirst($shipment->courierService->courier) }}</div>
                        </div>

                        <div>
                            <span class="text-sm font-medium text-gray-600">Current Status:</span>
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $shipment->status_badge }}">
                                {{ \App\Models\Shipment::getStatuses()[$shipment->status] }}
                            </span>
                        </div>
                    </div>

                    @if ($shipment->tracking_number)
                        <div class="mt-3">
                            <span class="text-sm font-medium text-gray-600">Tracking Number:</span>
                            <span class="font-mono text-sm ml-2">{{ $shipment->tracking_number }}</span>
                        </div>
                    @endif
                </div>

                <!-- Status Update -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Shipment Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status"
                        class="w-full md:w-1/3 border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                        @foreach (\App\Models\Shipment::getStatuses() as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('status', $shipment->status) == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-sm text-gray-600 mt-1">Update the current status of the shipment</p>
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
                                value="{{ old('weight', $shipment->weight) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="1.000" required>
                        </div>

                        <div>
                            <label for="declared_value" class="block text-sm font-medium text-gray-700 mb-2">
                                Declared Value ($)
                            </label>
                            <input type="number" name="declared_value" id="declared_value" step="0.01" min="0"
                                value="{{ old('declared_value', $shipment->declared_value) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="0.00">
                        </div>

                        <div>
                            <label for="cod_amount" class="block text-sm font-medium text-gray-700 mb-2">
                                COD Amount ($)
                            </label>
                            <input type="number" name="cod_amount" id="cod_amount" step="0.01" min="0"
                                value="{{ old('cod_amount', $shipment->cod_amount) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="0.00">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="special_instructions" class="block text-sm font-medium text-gray-700 mb-2">
                            Special Instructions
                        </label>
                        <textarea name="special_instructions" id="special_instructions" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Any special handling instructions...">{{ old('special_instructions', $shipment->special_instructions) }}</textarea>
                    </div>
                </div>

                <!-- Address Information (Read-only for reference) -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Pickup Address -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Pickup Address (Read-only)</h3>

                        @php $pickup = $shipment->pickup_address; @endphp
                        <div class="space-y-2 text-sm">
                            <div><strong>Name:</strong> {{ $pickup['name'] ?? 'N/A' }}</div>
                            <div><strong>Phone:</strong> {{ $pickup['phone'] ?? 'N/A' }}</div>
                            <div><strong>Address:</strong> {{ $pickup['address'] ?? 'N/A' }}</div>
                            <div><strong>City:</strong> {{ $pickup['city'] ?? 'N/A' }}</div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Contact admin to modify pickup address</p>
                    </div>

                    <!-- Delivery Address -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Delivery Address (Read-only)</h3>

                        @php $delivery = $shipment->delivery_address; @endphp
                        <div class="space-y-2 text-sm">
                            <div><strong>Name:</strong> {{ $delivery['name'] ?? 'N/A' }}</div>
                            <div><strong>Phone:</strong> {{ $delivery['phone'] ?? 'N/A' }}</div>
                            <div><strong>Address:</strong> {{ $delivery['address'] ?? 'N/A' }}</div>
                            <div><strong>City:</strong> {{ $delivery['city'] ?? 'N/A' }}</div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Contact admin to modify delivery address</p>
                    </div>
                </div>

                <!-- Tracking Information -->
                @if ($shipment->tracking_number || $shipment->courier_shipment_id)
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Tracking Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if ($shipment->tracking_number)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tracking Number</label>
                                    <div class="font-mono text-sm bg-white p-2 rounded border">
                                        {{ $shipment->tracking_number }}</div>
                                </div>
                            @endif

                            @if ($shipment->courier_shipment_id)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Courier Shipment ID</label>
                                    <div class="font-mono text-sm bg-white p-2 rounded border">
                                        {{ $shipment->courier_shipment_id }}</div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-4">
                            <button type="button" onclick="trackShipment({{ $shipment->id }})"
                                class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg transition duration-200">
                                <i class="fas fa-search-location mr-2"></i>Track Current Status
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Warning for Status Changes -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <i class="fas fa-exclamation-triangle text-yellow-400 mr-3 mt-1"></i>
                        <div>
                            <h4 class="text-yellow-800 font-medium">Important Notes:</h4>
                            <ul class="text-yellow-700 text-sm mt-1 list-disc list-inside">
                                <li>Changing status to "Delivered" will automatically update the order status</li>
                                <li>Changing status to "Cancelled" will mark the shipment as cancelled</li>
                                <li>Address changes require creating a new shipment</li>
                                <li>Tracking information cannot be manually edited</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3 pt-6 border-t">
                    <a href="{{ route('admin.shipments.show', $shipment->id) }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-save mr-2"></i>Update Shipment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Track Modal -->
    <div id="trackModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg p-6 max-w-lg w-full mx-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Tracking Information</h3>
                <div id="trackingResult"></div>
                <div class="mt-4 flex justify-end">
                    <button onclick="closeTrackModal()"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function trackShipment(shipmentId) {
            const resultDiv = document.getElementById('trackingResult');
            resultDiv.innerHTML =
                '<div class="text-center py-4"><i class="fas fa-spinner fa-spin"></i> Tracking shipment...</div>';
            document.getElementById('trackModal').classList.remove('hidden');

            fetch(`/admin/shipments/${shipmentId}/track`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        resultDiv.innerHTML = `
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    <h4 class="font-medium mb-2">Tracking Results</h4>
                    <pre class="text-sm whitespace-pre-wrap">${JSON.stringify(data.data, null, 2)}</pre>
                </div>
            `;
                    } else {
                        resultDiv.innerHTML = `
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <i class="fas fa-exclamation-circle mr-2"></i>${data.message}
                </div>
            `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    resultDiv.innerHTML = `
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <i class="fas fa-exclamation-circle mr-2"></i>Tracking failed
            </div>
        `;
                });
        }

        function closeTrackModal() {
            document.getElementById('trackModal').classList.add('hidden');
        }

        // Status change warning
        document.getElementById('status').addEventListener('change', function() {
            const status = this.value;
            if (status === 'delivered' || status === 'cancelled') {
                if (!confirm(
                        `Are you sure you want to change the status to "${status}"? This action will update the order status as well.`
                    )) {
                    this.value = '{{ $shipment->status }}'; // Reset to original value
                }
            }
        });
    </script>
@endsection
