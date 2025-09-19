@extends('layouts.web')

@section('content')
    <div class="container mx-auto px-2 py-3">
        <div class="flex justify-between items-center mb-3">
            <h1 class="text-xl font-bold">Order #{{ $order->number ?? $order->id }}</h1>
            <a href="{{ route('admin.orders.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded text-sm transition duration-200">
                <i class="fas fa-arrow-left mr-1"></i>Back to Orders
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
            <!-- Order Info -->
            <div class="bg-white rounded shadow p-3">
                <h2 class="font-semibold text-base mb-2">Order Details</h2>
                <div class="text-sm text-gray-700 mb-1">Order ID: <span
                        class="font-mono">{{ $order->number ?? $order->id }}</span></div>
                <div class="text-sm text-gray-700 mb-1">Date: {{ $order->created_at->format('Y-m-d H:i') }}</div>
                <div class="text-sm text-gray-700 mb-1">Status: <span
                        class="font-semibold">{{ ucfirst($order->status) }}</span></div>
                <div class="text-sm text-gray-700 mb-1">Payment: <span
                        class="font-semibold">{{ $order->paymentMethod->name ?? 'N/A' }}</span></div>
                <div class="text-sm text-gray-700 mb-1">Payment Status: <span
                        class="font-semibold">{{ ucfirst($order->payment_status) }}</span></div>
                <div class="text-sm text-gray-700 mb-1">Total: <span class="font-bold">RS
                        {{ number_format($order->total, 2) }}</span></div>
            </div>

            <!-- Customer Info -->
            <div class="bg-white rounded shadow p-3">
                <h2 class="font-semibold text-base mb-2">Customer Information</h2>
                @if ($order->user_id)
                    <!-- Existing User -->
                    <div class="text-sm text-gray-700 mb-1">Name: {{ $order->user->name ?? 'N/A' }}</div>
                    <div class="text-sm text-gray-700 mb-1">Email: {{ $order->user->email ?? 'N/A' }}</div>
                    <div class="text-sm text-gray-700 mb-1">Phone: {{ $order->user->phone ?? 'N/A' }}</div>
                    <div class="text-xs text-blue-600 mt-2">Registered Customer</div>
                @else
                    <!-- Manual Customer -->
                    <div class="text-sm text-gray-700 mb-1">Name: {{ $order->customer_name ?? 'N/A' }}</div>
                    <div class="text-sm text-gray-700 mb-1">Email: {{ $order->customer_email ?? 'N/A' }}</div>
                    <div class="text-sm text-gray-700 mb-1">Phone: {{ $order->customer_phone ?? 'N/A' }}</div>
                    <div class="text-xs text-green-600 mt-2">Manual Entry</div>
                @endif
            </div>

            <!-- Shipping Info -->
            <div class="bg-white rounded shadow p-3">
                <h2 class="font-semibold text-base mb-2">Shipping Address</h2>
                <div class="text-sm text-gray-700 mb-1">
                    {{ $order->street_address ?? 'N/A' }}
                </div>
                <div class="text-sm text-gray-700 mb-1">
                    {{ $order->city->name ?? 'N/A' }}, {{ $order->country->name ?? 'N/A' }}
                </div>
                @if ($order->zip_code)
                    <div class="text-sm text-gray-700 mb-1">ZIP: {{ $order->zip_code }}</div>
                @endif
                <div class="text-sm text-gray-700 mb-1">Shipping Cost: RS
                    {{ number_format($order->shipping_cost, 2) }}</div>
                @if ($order->extra_note)
                    <div class="text-sm text-gray-700 mt-2">
                        <strong>Notes:</strong> {{ $order->extra_note }}
                    </div>
                @endif
            </div>
        </div>
        <!-- Order Items -->
        <div class="bg-white rounded shadow p-3 mb-4">
            <h2 class="font-semibold text-base mb-3">Order Items</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2 text-left">#</th>
                            <th class="px-2 py-2 text-left">Product</th>
                            <th class="px-2 py-2 text-right">Price</th>
                            <th class="px-2 py-2 text-right">Qty</th>
                            <th class="px-2 py-2 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderDetails as $i => $item)
                            <tr class="border-b">
                                <td class="px-2 py-2">{{ $i + 1 }}</td>
                                <td class="px-2 py-2">
                                    <div class="flex items-center">
                                        @if ($item->product && $item->product->media->first())
                                            <img src="{{ asset($item->product->media->first()->file_path) }}"
                                                alt="" class="w-10 h-10 object-cover rounded mr-2">
                                        @endif
                                        <div>
                                            <div class="font-medium">{{ $item->product->name ?? 'Product Deleted' }}</div>
                                            @if ($item->product)
                                                <div class="text-xs text-gray-500">SKU: {{ $item->product->sku ?? 'N/A' }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 py-2 text-right">RS {{ number_format($item->price, 2) }}</td>
                                <td class="px-2 py-2 text-right">{{ $item->qty }}</td>
                                <td class="px-2 py-2 text-right">RS
                                    {{ number_format($item->price * $item->qty, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Totals -->
        <div class="flex flex-col md:flex-row justify-between gap-3">
            <!-- Order Summary -->
            <div class="bg-white rounded shadow p-3 w-full md:w-1/3">
                <h2 class="font-semibold text-base mb-2">Order Summary</h2>
                @php
                    $subtotal = $order->orderDetails->sum(function ($item) {
                        return $item->price * $item->qty;
                    });
                @endphp
                <div class="flex justify-between text-sm mb-1">
                    <span>Subtotal:</span>
                    <span>RS {{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm mb-1">
                    <span>Shipping:</span>
                    <span>RS {{ number_format($order->shipping_cost, 2) }}</span>
                </div>
                @if ($order->discount > 0)
                    <div class="flex justify-between text-sm mb-1 text-green-600">
                        <span>Discount:</span>
                        <span>-RS {{ number_format($order->discount, 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between text-base font-bold border-t pt-2 mt-2">
                    <span>Total:</span>
                    <span>RS {{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            <!-- Order Actions -->
            <div class="bg-white rounded shadow p-3 w-full md:w-1/3">
                <h2 class="font-semibold text-base mb-2">Actions</h2>
                <div class="space-y-2">
                    @if ($order->status === 'pending')
                        <button
                            class="w-full bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded text-sm transition duration-200">
                            <i class="fas fa-check mr-1"></i>Mark as Confirmed
                        </button>
                    @endif

                    @if ($order->status !== 'cancelled')
                        <button
                            class="w-full bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm transition duration-200">
                            <i class="fas fa-times mr-1"></i>Cancel Order
                        </button>
                    @endif

                    <a href="{{ route('admin.orders.index') }}"
                        class="w-full block text-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded text-sm transition duration-200">
                        <i class="fas fa-edit mr-1"></i>Edit Order
                    </a>

                    @if (!$order->shipment)
                        <a href="{{ route('admin.shipments.create', ['order_id' => $order->id]) }}"
                            class="w-full block text-center bg-purple-500 hover:bg-purple-600 text-white px-3 py-2 rounded text-sm transition duration-200">
                            <i class="fas fa-shipping-fast mr-1"></i>Create Shipment
                        </a>
                    @else
                        <a href="{{ route('admin.shipments.show', $order->shipment) }}"
                            class="w-full block text-center bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded text-sm transition duration-200">
                            <i class="fas fa-eye mr-1"></i>View Shipment
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Shipment Information -->
        @if ($order->shipment)
            <div class="bg-white rounded shadow p-3 mt-4">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="font-semibold text-base">Shipment Information</h2>
                    <a href="{{ route('admin.shipments.show', $order->shipment->id) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded text-sm transition duration-200">
                        <i class="fas fa-eye mr-1"></i>View Details
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Shipment ID</label>
                        <div class="text-gray-900 font-mono text-sm">#{{ $order->shipment->id }}</div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Status</label>
                        <div>
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst($order->shipment->status) }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-600">Courier</label>
                        <div class="text-gray-900">{{ $order->shipment->courierService->courier ?? 'N/A' }}</div>
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
            </div>
        @endif
    </div>
@endsection

@push('scripts')
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
@endpush
