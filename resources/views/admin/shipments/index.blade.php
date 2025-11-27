@extends('layouts.web')

@section('content')
    <div class="container mx-auto px-2 py-2">
        <div class="bg-white rounded-lg shadow-md p-2">
            <!-- Header -->
            <div class="flex justify-between items-center mb-2">
                <h1 class="text-xl font-bold text-gray-800">Shipments Management</h1>
                <a href="{{ route('admin.shipments.create') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded-lg transition duration-200">
                    <i class="fas fa-plus mr-1"></i>Create Shipment
                </a>
            </div>

            <!-- Filters -->
            <div class="bg-gray-50 rounded-lg p-2 mb-2">
                <form method="GET" id="filterForm" class="space-y-2">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Tracking number, Order ID..."
                                class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Statuses</option>
                                @foreach (\App\Models\Shipment::getStatuses() as $key => $label)
                                    <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Courier</label>
                            <select name="courier"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Couriers</option>
                                @foreach ($courierServices as $service)
                                    <option value="{{ $service->courier }}"
                                        {{ request('courier') == $service->courier ? 'selected' : '' }}>
                                        {{ ucfirst($service->courier) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="col-span-3 flex items-end space-x-2">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                                <i class="fas fa-search mr-1"></i>
                            </button>
                            <a href="{{ route('admin.shipments.index') }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                                <i class="fas fa-times mr-1"></i>
                            </a>
                            <button type="button" onclick="exportCSV()"
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition duration-200">
                                <i class="fas fa-file-csv mr-1"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Shipments Table -->
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Shipment</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Order</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Courier</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Tracking</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Created</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($shipments as $shipment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div>
                                        <div class="font-medium text-gray-900">ID: {{ $shipment->id }}</div>
                                        @if ($shipment->courier_shipment_id)
                                            <div class="text-sm text-gray-600">{{ $shipment->courier_shipment_id }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div>
                                        <a href="{{ route('admin.orders.show', $shipment->order_id) }}"
                                            class="font-medium text-blue-600 hover:text-blue-800">
                                            Order #{{ $shipment->order_id }}
                                        </a>
                                        <div class="text-sm text-gray-600">
                                            {{ $shipment->order->user->name ?? ($shipment->order->customer_name ?? ($shipment->order->shipping_address['first_name'] ?? 'N/A')) }}
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            {{ $shipment->order->reference_number ?? '' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4
                                            py-3">
                                    @if ($shipment->courierService->courier == 'trax')
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                            <i class="fas fa-shipping-fast mr-1"></i>TRAX
                                        </span>
                                    @elseif($shipment->courierService->courier == 'tcs')
                                        <span
                                            class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                                            <i class="fas fa-truck mr-1"></i>TCS
                                        </span>
                                    @elseif($shipment->courierService->courier == 'leopards')
                                        <span
                                            class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-medium">
                                            <i class="fas fa-box mr-1"></i>Leopards
                                        </span>
                                    @elseif($shipment->courierService->courier == 'manual')
                                        <span
                                            class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-medium">
                                            <i class="fas fa-box mr-1"></i>Manual
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $shipment->status_badge }}">
                                        {{ \App\Models\Shipment::getStatuses()[$shipment->status] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($shipment->tracking_number)
                                        <div class="font-mono text-sm">{{ $shipment->tracking_number }}</div>
                                    @else
                                        <span class="text-gray-400">No tracking</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ $shipment->created_at->format('M d, Y H:i') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2">
                                        <!-- View -->
                                        <a href="{{ route('admin.shipments.show', $shipment->id) }}"
                                            class="text-blue-600 hover:text-blue-800 text-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @hasanyrole('admin|label_printer')
                                            <!-- Edit -->
                                            @if ($shipment->status !== 'delivered' && $shipment->status !== 'cancelled')
                                                <a href="{{ route('admin.shipments.edit', $shipment->id) }}"
                                                    class="text-green-600 hover:text-green-800 text-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif

                                            <!-- Cancel -->
                                            @if (!in_array($shipment->status, ['delivered', 'cancelled']))
                                                <button onclick="cancelShipment({{ $shipment->id }})"
                                                    class="text-red-600 hover:text-red-800 text-sm">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            @endif
                                        @endhasanyrole



                                        <!-- Track -->
                                        @if ($shipment->tracking_number)
                                            <button onclick="trackShipment({{ $shipment->id }})"
                                                class="text-purple-600 hover:text-purple-800 text-sm">
                                                <i class="fas fa-search-location"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                    <i class="fas fa-shipping-fast text-4xl mb-4 text-gray-300"></i>
                                    <p class="text-lg mb-2">No shipments found</p>
                                    <p class="text-sm">Create your first shipment to get started</p>
                                    <a href="{{ route('admin.shipments.create') }}"
                                        class="inline-block mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                                        Create Shipment
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($shipments->hasPages())
                <div class="mt-6">
                    {{ $shipments->appends(request()->query())->links() }}
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
        let currentShipmentId = null;

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

                        // Add shipper information if available
                        if (data.shipper) {
                            trackingHtml += `
                                <div class="bg-gray-50 p-3 rounded">
                                    <h5 class="font-medium mb-2">Shipper Information</h5>
                                    <div class="text-sm space-y-1">
                                        ${data.shipper.name ? `<div><strong>Name:</strong> ${data.shipper.name}</div>` : ''}
                                        ${data.shipper.phone ? `<div><strong>Phone:</strong> ${data.shipper.phone}</div>` : ''}
                                    </div>
                                </div>
                            `;
                        }

                        // Add consignee information if available
                        if (data.consignee) {
                            trackingHtml += `
                                <div class="bg-gray-50 p-3 rounded">
                                    <h5 class="font-medium mb-2">Consignee Information</h5>
                                    <div class="text-sm space-y-1">
                                        <div><strong>Name:</strong> ${data.consignee.name || 'N/A'}</div>
                                        ${data.consignee.phone || data.consignee.phone_number_1 ? `<div><strong>Phone:</strong> ${data.consignee.phone || data.consignee.phone_number_1}</div>` : ''}
                                        ${data.delivery && data.delivery.city ? `<div><strong>Destination:</strong> ${data.delivery.city}</div>` : ''}
                                        ${data.consignee.address ? `<div><strong>Address:</strong> ${data.consignee.address}</div>` : ''}
                                    </div>
                                </div>
                            `;
                        }

                        // Add pickup and delivery info
                        if (data.pickup || data.delivery) {
                            trackingHtml += `
                                <div class="grid grid-cols-2 gap-3">
                            `;

                            if (data.pickup) {
                                trackingHtml += `
                                    <div class="bg-gray-50 p-3 rounded">
                                        <h5 class="font-medium mb-2">Pickup</h5>
                                        <div class="text-sm space-y-1">
                                            ${data.pickup.city ? `<div><strong>City:</strong> ${data.pickup.city}</div>` : ''}
                                            ${data.pickup.country ? `<div><strong>Country:</strong> ${data.pickup.country}</div>` : ''}
                                        </div>
                                    </div>
                                `;
                            }

                            if (data.delivery) {
                                trackingHtml += `
                                    <div class="bg-gray-50 p-3 rounded">
                                        <h5 class="font-medium mb-2">Delivery</h5>
                                        <div class="text-sm space-y-1">
                                            ${data.delivery.city ? `<div><strong>City:</strong> ${data.delivery.city}</div>` : ''}
                                            ${data.delivery.delivered_on ? `<div><strong>Delivered On:</strong> ${data.delivery.delivered_on}</div>` : ''}
                                            ${data.delivery.delivered_by ? `<div><strong>Delivered By:</strong> ${data.delivery.delivered_by}</div>` : ''}
                                        </div>
                                    </div>
                                `;
                            }

                            trackingHtml += `
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

                        // Add summary if available
                        if (data.summary) {
                            trackingHtml += `
                                <div class="bg-blue-50 border border-blue-200 p-3 rounded">
                                    <h5 class="font-medium mb-2 text-blue-900">Summary</h5>
                                    <div class="text-sm text-blue-800 whitespace-pre-line">${data.summary}</div>
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
            currentShipmentId = shipmentId;
            document.getElementById('cancelModal').classList.remove('hidden');
        }

        function closeCancelModal() {
            document.getElementById('cancelModal').classList.add('hidden');
            currentShipmentId = null;
        }

        document.getElementById('cancelForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(`/admin/shipments/${currentShipmentId}/cancel`, {
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
        });

        function exportCSV() {
            const form = document.getElementById('filterForm');
            const formData = new FormData(form);
            const params = new URLSearchParams();

            for (const [key, value] of formData.entries()) {
                if (value) {
                    params.append(key, value);
                }
            }

            window.location.href = '{{ route('admin.shipments.export') }}?' + params.toString();
        }
    </script>
@endsection
