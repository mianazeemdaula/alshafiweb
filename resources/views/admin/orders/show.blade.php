@extends('layouts.web')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Order #{{ $order->id }}</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Order Info -->
            <div class="bg-white rounded shadow p-4">
                <h2 class="font-semibold text-lg mb-2">Order Details</h2>
                <div class="text-sm text-gray-700 mb-1">Order ID: <span class="font-mono">{{ $order->id }}</span></div>
                <div class="text-sm text-gray-700 mb-1">Date: {{ $order->created_at->format('Y-m-d H:i') }}</div>
                <div class="text-sm text-gray-700 mb-1">Status: <span
                        class="font-semibold">{{ ucfirst($order->status) }}</span></div>
                <div class="text-sm text-gray-700 mb-1">Payment: <span
                        class="font-semibold">{{ strtoupper($order->payment_method) }}</span></div>
                <div class="text-sm text-gray-700 mb-1">Total: <span class="font-bold">{{ $order->currency }}
                        {{ number_format($order->total, 2) }}</span></div>
            </div>
            <!-- Customer Info -->
            <div class="bg-white rounded shadow p-4">
                <h2 class="font-semibold text-lg mb-2">Customer</h2>
                <div class="text-sm text-gray-700 mb-1">Name:
                    {{ $order->user->name ?? $order->shipping_first_name . ' ' . $order->shipping_last_name }}</div>
                <div class="text-sm text-gray-700 mb-1">Email: {{ $order->user->email ?? '-' }}</div>
                <div class="text-sm text-gray-700 mb-1">Phone: {{ $order->shipping_phone }}</div>
            </div>
            <!-- Shipping Info -->
            <div class="bg-white rounded shadow p-4">
                <h2 class="font-semibold text-lg mb-2">Shipping Address</h2>
                @if (is_array($order->shipping_address))
                    {{ $order->shipping_address['first_name'] ?? '' }}
                    {{ $order->shipping_address['last_name'] ?? '' }}<br>
                    {{ $order->shipping_address['address'] ?? '' }}<br>
                    {{ $order->shipping_address['city'] ?? '' }}
                    @if (!empty($order->shipping_address['postal_code']))
                        {{ $order->shipping_address['postal_code'] }}
                    @endif
                    @if (!empty($order->shipping_address['phone']))
                        <br>Phone: {{ $order->shipping_address['phone'] }}
                    @endif
                @else
                    {{ $order->shipping_address }}
                @endif
                <div class="text-sm text-gray-700 mb-1">
                    {{ $order->shipping_city }}, {{ $order->shipping_postal_code }}
                </div>
                <div class="text-sm text-gray-700 mb-1">Notes: {{ $order->notes ?? '-' }}</div>
            </div>
        </div>
        <!-- Order Items -->
        <div class="bg-white rounded shadow p-4 mb-8">
            <h2 class="font-semibold text-lg mb-4">Order Items</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-3 py-2 text-left">#</th>
                            <th class="px-3 py-2 text-left">Product</th>
                            <th class="px-3 py-2 text-left">SKU</th>
                            <th class="px-3 py-2 text-right">Price</th>
                            <th class="px-3 py-2 text-right">Qty</th>
                            <th class="px-3 py-2 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->details as $i => $item)
                            <tr class="border-b">
                                <td class="px-3 py-2">{{ $i + 1 }}</td>
                                <td class="px-3 py-2">
                                    {{ $item->product->name ?? 'Product Deleted' }}
                                    @if ($item->product && $item->product->media->first())
                                        <img src="{{ asset($item->product->media->first()->file_path) }}" alt=""
                                            class="w-12 h-12 object-cover rounded mt-1">
                                    @endif
                                </td>
                                <td class="px-3 py-2">{{ $item->product->sku ?? '-' }}</td>
                                <td class="px-3 py-2 text-right">{{ $order->currency }}
                                    {{ number_format($item->price, 2) }}</td>
                                <td class="px-3 py-2 text-right">{{ $item->qty }}</td>
                                <td class="px-3 py-2 text-right">{{ $order->currency }}
                                    {{ number_format($item->price * $item->qty, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Totals -->
        <div class="flex flex-col md:flex-row justify-end gap-6">
            <div class="bg-white rounded shadow p-4 w-full md:w-1/3">
                <h2 class="font-semibold text-lg mb-2">Order Summary</h2>
                <div class="flex justify-between text-sm mb-1">
                    <span>Subtotal:</span>
                    <span>{{ $order->currency }} {{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm mb-1">
                    <span>Shipping:</span>
                    <span>{{ $order->currency }} {{ number_format($order->shipping_amount, 2) }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold border-t pt-2 mt-2">
                    <span>Total:</span>
                    <span>{{ $order->currency }} {{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Shipment Information -->
        <div class="bg-white rounded shadow p-4 mt-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-lg">Shipment Information</h2>
                @if (!$order->shipment)
                    <a href="{{ route('admin.shipments.create', ['order_id' => $order->id]) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-shipping-fast mr-2"></i>Ship Order
                    </a>
                @endif
            </div>

            @if ($order->shipment)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Shipment ID</label>
                        <div class="text-gray-900">
                            <a href="{{ route('admin.shipments.show', $order->shipment->id) }}"
                                class="text-blue-600 hover:text-blue-800 font-medium">
                                #{{ $order->shipment->id }}
                            </a>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Status</label>
                        <div>
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $order->shipment->status_badge }}">
                                {{ \App\Models\Shipment::getStatuses()[$order->shipment->status] }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Courier</label>
                        <div class="text-gray-900">{{ ucfirst($order->shipment->courierService->courier) }}</div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Tracking Number</label>
                        <div class="text-gray-900">
                            @if ($order->shipment->tracking_number)
                                <span class="font-mono text-sm">{{ $order->shipment->tracking_number }}</span>
                            @else
                                <span class="text-gray-400">Not available</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex space-x-3">
                    <a href="{{ route('admin.shipments.show', $order->shipment->id) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm transition duration-200">
                        <i class="fas fa-eye mr-1"></i>View Details
                    </a>

                    @if ($order->shipment->tracking_number)
                        <button onclick="trackShipment({{ $order->shipment->id }})"
                            class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded text-sm transition duration-200">
                            <i class="fas fa-search-location mr-1"></i>Track
                        </button>
                    @endif

                    @if (!in_array($order->shipment->status, ['delivered', 'cancelled']))
                        <a href="{{ route('admin.shipments.edit', $order->shipment->id) }}"
                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm transition duration-200">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                    @endif
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-shipping-fast text-4xl mb-4 text-gray-300"></i>
                    <p class="text-lg mb-2">No shipment created</p>
                    <p class="text-sm mb-4">Create a shipment to track this order's delivery</p>
                    <a href="{{ route('admin.shipments.create', ['order_id' => $order->id]) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-plus mr-2"></i>Create Shipment
                    </a>
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
    </script>
@endsection
