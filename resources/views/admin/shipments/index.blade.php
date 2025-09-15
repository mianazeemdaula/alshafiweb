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
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-2">
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

                    <div class="flex items-end space-x-2">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                            <i class="fas fa-search mr-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.shipments.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                            <i class="fas fa-times mr-1"></i>Clear
                        </a>
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
                                        <div class="text-sm text-gray-600">{{ $shipment->order->user->name ?? 'N/A' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
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

                                        <!-- Edit -->
                                        @if ($shipment->status !== 'delivered' && $shipment->status !== 'cancelled')
                                            <a href="{{ route('admin.shipments.edit', $shipment->id) }}"
                                                class="text-green-600 hover:text-green-800 text-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif

                                        <!-- Track -->
                                        @if ($shipment->tracking_number)
                                            <button onclick="trackShipment({{ $shipment->id }})"
                                                class="text-purple-600 hover:text-purple-800 text-sm">
                                                <i class="fas fa-search-location"></i>
                                            </button>
                                        @endif

                                        <!-- Cancel -->
                                        @if (!in_array($shipment->status, ['delivered', 'cancelled']))
                                            <button onclick="cancelShipment({{ $shipment->id }})"
                                                class="text-red-600 hover:text-red-800 text-sm">
                                                <i class="fas fa-ban"></i>
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
                    document.getElementById('trackModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
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
    </script>
@endsection
