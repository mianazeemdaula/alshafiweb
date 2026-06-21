@extends('layouts.web')

@section('content')
    <div class="container mx-auto px-1 sm:px-2 py-2 max-w-7xl">
        <div class="bg-white rounded-lg shadow-md p-3 sm:p-4">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-3">
                <div class="flex items-center">
                    <a href="{{ route('admin.shipments.index') }}" class="text-blue-600 hover:text-blue-800 mr-3">
                        <i class="fas fa-arrow-left mr-1"></i>Back to Shipments
                    </a>
                    <h1 class="text-xl font-bold text-gray-800">Shipment #{{ $shipment->id }}</h1>
                </div>

                <div class="flex flex-wrap gap-2 sm:space-x-2">
                    @if (!in_array($shipment->status, ['delivered', 'cancelled']))
                        <a href="{{ route('admin.shipments.edit', $shipment->id) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg transition duration-200 text-sm">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                    @endif

                    @if ($shipment->tracking_number)
                        <button onclick="trackShipment({{ $shipment->id }})"
                            class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-2 rounded-lg transition duration-200 text-sm">
                            <i class="fas fa-search-location mr-1"></i>Track
                        </button>

                        <a href="{{ route('admin.shipments.download-slip', $shipment->id) }}" target="_blank"
                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg transition duration-200 text-sm">
                            <i class="fas fa-download mr-1"></i>Download Slip
                        </a>
                    @endif

                    @if (!in_array($shipment->status, ['delivered', 'cancelled']))
                        <button onclick="cancelShipment({{ $shipment->id }})"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg transition duration-200 text-sm">
                            <i class="fas fa-ban mr-1"></i>Cancel
                        </button>
                    @endif
                </div>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-3 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('warning'))
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-3 py-3 rounded mb-4">
                    {{ session('warning') }}
                </div>
            @endif

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 sm:gap-6">
                <!-- Shipment Information -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Shipment Information</h3>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Status:</span>
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $shipment->status_badge }}">
                                {{ \App\Models\Shipment::getStatuses()[$shipment->status] }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Courier:</span>
                            <div>
                                @if ($shipment->courierService->courier == 'trax')
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                        <i class="fas fa-shipping-fast mr-1"></i>TRAX
                                    </span>
                                @elseif($shipment->courierService->courier == 'tcs')
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                                        <i class="fas fa-truck mr-1"></i>TCS
                                    </span>
                                @elseif($shipment->courierService->courier == 'leopards')
                                    <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-medium">
                                        <i class="fas fa-box mr-1"></i>Leopards
                                    </span>
                                @elseif($shipment->courierService->courier == 'postex')
                                    <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs font-medium">
                                        <i class="fas fa-box mr-1"></i>PostEx
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if ($shipment->tracking_number)
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Tracking Number:</span>
                                <span class="font-mono text-sm">{{ $shipment->tracking_number }}</span>
                            </div>
                        @endif

                        @if ($shipment->courier_shipment_id)
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Courier Shipment ID:</span>
                                <span class="font-mono text-sm">{{ $shipment->courier_shipment_id }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Weight:</span>
                            <span class="text-gray-800">{{ $shipment->weight }} kg</span>
                        </div>

                        @if ($shipment->declared_value)
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Declared Value:</span>
                                <span class="text-gray-800">RS {{ number_format($shipment->declared_value, 2) }}</span>
                            </div>
                        @endif

                        @if ($shipment->cod_amount)
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">COD Amount:</span>
                                <span class="text-gray-800">RS {{ number_format($shipment->cod_amount, 2) }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Created:</span>
                            <span class="text-gray-800">{{ $shipment->created_at->format('M d, Y H:i') }}</span>
                        </div>

                        @if ($shipment->shipped_at)
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Shipped:</span>
                                <span class="text-gray-800">{{ $shipment->shipped_at->format('M d, Y H:i') }}</span>
                            </div>
                        @endif

                        @if ($shipment->delivered_at)
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Delivered:</span>
                                <span class="text-gray-800">{{ $shipment->delivered_at->format('M d, Y H:i') }}</span>
                            </div>
                        @endif

                        @if ($shipment->cancelled_at)
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Cancelled:</span>
                                <span class="text-gray-800">{{ $shipment->cancelled_at->format('M d, Y H:i') }}</span>
                            </div>
                            @if ($shipment->cancellation_reason)
                                <div class="mt-2">
                                    <span class="font-medium text-gray-600">Reason:</span>
                                    <p class="text-sm text-gray-700 mt-1">{{ $shipment->cancellation_reason }}</p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Order Information -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Information</h3>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Order ID:</span>
                            <a href="{{ route('admin.orders.show', $shipment->order->id) }}"
                                class="text-blue-600 hover:text-blue-800">
                                #{{ $shipment->order->id }}
                            </a>
                        </div>

                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Customer:</span>
                            <span class="text-gray-800">{{ $shipment->order->user->name ?? 'N/A' }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Order Total:</span>
                            <span class="text-gray-800">RS {{ number_format($shipment->order->total_amount, 2) }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Order Status:</span>
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst($shipment->order->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="mt-4">
                        <h4 class="font-medium text-gray-700 mb-2">Order Items</h4>
                        <div class="space-y-2">
                            @foreach ($shipment->order->orderDetails as $detail)
                                <div class="bg-white rounded p-3 border">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <div class="font-medium text-sm">{{ $detail->product->name ?? 'Product' }}
                                            </div>
                                            <div class="text-xs text-gray-600">Qty: {{ $detail->quantity }}</div>
                                        </div>
                                        <div class="text-sm font-medium">
                                            RS {{ number_format($detail->price / 100, 2) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Addresses -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                <!-- Pickup Address -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Pickup Address</h3>

                    @php $pickup = $shipment->pickup_address; @endphp
                    <div class="space-y-2">
                        <div><strong>Name:</strong> {{ $pickup['name'] ?? 'N/A' }}</div>
                        <div><strong>Phone:</strong> {{ $pickup['phone'] ?? 'N/A' }}</div>
                        <div><strong>Address:</strong> {{ $pickup['address'] ?? 'N/A' }}</div>
                        <div><strong>City:</strong> {{ $pickup['city'] ?? 'N/A' }}</div>
                    </div>
                </div>

                <!-- Delivery Address -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Delivery Address</h3>

                    @php $delivery = $shipment->delivery_address; @endphp
                    <div class="space-y-2">
                        <div><strong>Name:</strong> {{ $delivery['name'] ?? 'N/A' }}</div>
                        <div><strong>Phone:</strong> {{ $delivery['phone'] ?? 'N/A' }}</div>
                        <div><strong>Address:</strong> {{ $delivery['address'] ?? 'N/A' }}</div>
                        <div><strong>City:</strong> {{ $delivery['city'] ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>

            <!-- Special Instructions -->
            @if ($shipment->special_instructions)
                <div class="mt-6 bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Special Instructions</h3>
                    <p class="text-gray-700">{{ $shipment->special_instructions }}</p>
                </div>
            @endif

            <!-- Courier Response -->
            @if ($shipment->courier_response)
                <div class="mt-6 bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Courier API Response</h3>
                    <pre class="bg-gray-800 text-green-400 p-4 rounded text-sm overflow-x-auto">{{ json_encode($shipment->courier_response, JSON_PRETTY_PRINT) }}</pre>
                </div>
            @endif
        </div>
    </div>

    <!-- Track Modal -->
    <div id="trackModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full my-8 flex flex-col"
                style="max-height: calc(100vh - 4rem);">
                <div class="px-6 py-4 border-b border-gray-200 flex-shrink-0">
                    <h3 class="text-lg font-medium text-gray-900">Tracking Information</h3>
                </div>
                <div id="trackingResult" class="flex-1 overflow-y-auto px-6 py-4"></div>
                <div class="px-6 py-4 border-t border-gray-200 flex-shrink-0 flex justify-end">
                    <button onclick="closeTrackModal()"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Modal -->
    <div id="cancelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Cancel Shipment</h3>
                <form id="cancelForm">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cancellation Reason</label>
                        <textarea name="cancellation_reason" rows="3" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Please provide a reason for cancellation..."></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeCancelModal()"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                            Cancel
                        </button>
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                            Confirm Cancellation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function trackShipment(shipmentId) {
            fetch(`/admin/shipments/${shipmentId}/track`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const resultDiv = document.getElementById('trackingResult');
                    if (data.success) {
                        let trackingHtml = `
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                <h4 class="font-medium mb-2">✓ ${data.message || 'Tracking information retrieved successfully'}</h4>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="bg-gray-50 p-3 rounded">
                                    <div class="grid grid-cols-2 gap-2 text-sm">
                                        <div><strong>Tracking Number:</strong> ${data.tracking_number || 'N/A'}</div>
                                        <div><strong>Current Status:</strong> <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">${data.current_status || data.status || 'Unknown'}</span></div>
                                    </div>
                                </div>
                        `;

                        // Add consignee information if available
                        if (data.consignee) {
                            trackingHtml += `
                                <div class="bg-gray-50 p-3 rounded">
                                    <h5 class="font-medium mb-2">Consignee Information</h5>
                                    <div class="text-sm space-y-1">
                                        <div><strong>Name:</strong> ${data.consignee.name || 'N/A'}</div>
                                        <div><strong>Phone:</strong> ${data.consignee.phone_number_1 || 'N/A'}</div>
                                        <div><strong>Destination:</strong> ${data.consignee.destination || 'N/A'}</div>
                                        ${data.consignee.address ? `<div><strong>Address:</strong> ${data.consignee.address}</div>` : ''}
                                    </div>
                                </div>
                            `;
                        }

                        // Add tracking history if available
                        if (data.tracking_history && data.tracking_history.length > 0) {
                            trackingHtml += `
                                <div class="bg-gray-50 p-3 rounded">
                                    <h5 class="font-medium mb-3">Tracking History</h5>
                                    <div class="space-y-3 max-h-96 overflow-y-auto pr-2">
                            `;

                            data.tracking_history.forEach((event, index) => {
                                const datetime = event.datetime || event.date_time || 'N/A';
                                const status = event.status || event.activity || 'Unknown';
                                const location = event.location || event.recievedby || '';
                                const remarks = event.remarks || event.status_reason || '';

                                trackingHtml += `
                                    <div class="relative pl-6 pb-3 ${index < data.tracking_history.length - 1 ? 'border-l-2 border-blue-300' : ''}">
                                        <div class="absolute left-0 top-0 -ml-2 w-4 h-4 rounded-full bg-blue-500 border-2 border-white"></div>
                                        <div class="bg-white p-3 rounded-lg shadow-sm">
                                            <div class="text-sm font-semibold text-gray-900">${status}</div>
                                            <div class="text-xs text-gray-600 mt-1">
                                                <i class="far fa-clock mr-1"></i>${datetime}
                                            </div>
                                            ${location ? `<div class="text-xs text-gray-500 mt-1"><i class="fas fa-map-marker-alt mr-1"></i>${location}</div>` : ''}
                                            ${remarks && remarks !== status ? `<div class="text-xs text-gray-500 mt-1">${remarks}</div>` : ''}
                                        </div>
                                    </div>
                                `;
                            });

                            trackingHtml += `
                                    </div>
                                </div>
                            `;
                        }

                        trackingHtml += `</div>`;
                        resultDiv.innerHTML = trackingHtml;
                    } else {
                        resultDiv.innerHTML = `
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                <i class="fas fa-exclamation-circle mr-2"></i>${data.message || 'Failed to track shipment'}
                            </div>
                        `;
                    }
                    document.getElementById('trackModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    const resultDiv = document.getElementById('trackingResult');
                    resultDiv.innerHTML = `
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <i class="fas fa-exclamation-circle mr-2"></i>Network error occurred while tracking shipment
                        </div>
                    `;
                    document.getElementById('trackModal').classList.remove('hidden');
                });
        }

        function closeTrackModal() {
            document.getElementById('trackModal').classList.add('hidden');
        }

        function cancelShipment(shipmentId) {
            document.getElementById('cancelModal').classList.remove('hidden');

            document.getElementById('cancelForm').onsubmit = function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                fetch(`/admin/shipments/${shipmentId}/cancel`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Cancellation failed: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while cancelling the shipment.');
                    });
            };
        }

        function closeCancelModal() {
            document.getElementById('cancelModal').classList.add('hidden');
        }
    </script>
@endsection
