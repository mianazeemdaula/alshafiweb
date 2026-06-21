@extends('layouts.user')

@section('main')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <a href="{{ route('user.orders.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <h1 class="text-3xl font-bold text-gray-800">{{ __('Order') }} #{{ $order->id }}</h1>
                    </div>
                    <span
                        class="px-4 py-2 text-sm font-medium rounded-full
                    @if ($order->status == 'completed') bg-green-100 text-green-800
                    @elseif($order->status == 'open') bg-yellow-100 text-yellow-800
                    @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                    @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                    @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Order Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Order Details -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Order Information') }}</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('Order Date') }}:</span>
                                <span class="font-medium">{{ $order->created_at->format('F d, Y \a\t h:i A') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('Order Status') }}:</span>
                                <span class="font-medium">{{ ucfirst($order->status) }}</span>
                            </div>
                            @if ($order->tracking_number)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tracking Number:</span>
                                    <span class="font-medium font-mono">{{ $order->tracking_number }}</span>
                                </div>
                            @endif
                            @if ($order->notes)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Notes:</span>
                                    <span class="font-medium">{{ $order->notes }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Shipping Information') }}</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Customer Name:</span>
                                <span class="font-medium">{{ $order->user ? $order->user->name : 'N/A' }}</span>
                            </div>
                            @if ($order->user && $order->user->email)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Email:</span>
                                    <span class="font-medium">{{ $order->user->email }}</span>
                                </div>
                            @endif
                            @if ($order->user && $order->user->mobile)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Phone:</span>
                                    <span class="font-medium">{{ $order->user->mobile }}</span>
                                </div>
                            @endif
                            @if ($order->shipping_address)
                                <div>
                                    <span class="text-gray-600">Shipping Address:</span>
                                    <div class="mt-1 text-gray-900">
                                        @if (is_array($order->shipping_address))
                                            {{ $order->shipping_address['first_name'] ?? '' }}
                                            {{ $order->shipping_address['last_name'] ?? '' }}<br>
                                            {{ $order->shipping_address['address'] ?? '' }}<br>
                                            {{ $order->shipping_address['city'] ?? '' }}
                                            @if (!empty($order->shipping_address['phone']))
                                                <br>Phone: {{ $order->shipping_address['phone'] }}
                                            @endif
                                        @else
                                            {{ $order->shipping_address }}
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Items</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Product</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Quantity</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Unit Price</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($order->orderDetails as $detail)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if ($detail->product && $detail->product->media->count() > 0)
                                                    <img class="h-12 w-12 rounded-lg object-cover mr-4"
                                                        src="{{ asset('storage/' . $detail->product->media->first()->path) }}"
                                                        alt="{{ $detail->product->name }}">
                                                @else
                                                    <div
                                                        class="h-12 w-12 bg-gray-200 rounded-lg mr-4 flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $detail->product->name ?? 'Product Not Found' }}
                                                    </div>
                                                    @if ($detail->product && $detail->product->sku)
                                                        <div class="text-sm text-gray-500">SKU: {{ $detail->product->sku }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $detail->qty }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            RS. {{ number_format($detail->price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            RS. {{ number_format($detail->qty * $detail->price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if ($detail->product && $order->status == 'completed')
                                                @php
                                                    $existingReview = \App\Models\ProductReview::where(
                                                        'user_id',
                                                        auth()->id(),
                                                    )
                                                        ->where('product_id', $detail->product_id)
                                                        ->first();
                                                @endphp
                                                @if ($existingReview)
                                                    <a href="{{ route('user.reviews.edit', $existingReview->id) }}"
                                                        class="text-blue-600 hover:text-blue-900">Edit Review</a>
                                                @else
                                                    <a href="{{ route('user.reviews.create', ['product_id' => $detail->product_id]) }}"
                                                        class="text-green-600 hover:text-green-900">Write Review</a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="border-t border-gray-200 pt-6">
                    <div class="flex justify-end">
                        <div class="w-full max-w-sm">
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Summary</h3>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Subtotal:</span>
                                        <span class="font-medium">RS.
                                            {{ number_format($order->orderDetails->sum(function ($detail) {return $detail->qty * $detail->price;}),2) }}</span>
                                    </div>
                                    @if ($order->discount > 0)
                                        <div class="flex justify-between text-green-600">
                                            <span>Discount:</span>
                                            <span>-RS. {{ number_format($order->discount, 2) }}</span>
                                        </div>
                                    @endif
                                    @if ($order->shipping_cost > 0)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Shipping:</span>
                                            <span class="font-medium">RS.
                                                {{ number_format($order->shipping_cost, 2) }}</span>
                                        </div>
                                    @endif
                                    @if ($order->tax > 0)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Tax:</span>
                                            <span class="font-medium">RS. {{ number_format($order->tax, 2) }}</span>
                                        </div>
                                    @endif
                                    <div class="border-t border-gray-200 pt-2">
                                        <div class="flex justify-between text-lg font-semibold">
                                            <span>Total:</span>
                                            <span>RS. {{ number_format($order->total, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                    @if (in_array($order->status, ['open', 'processing', 'shipped']))
                        <a href="{{ route('user.orders.track', $order->id) }}"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-center">
                            Track Order
                        </a>
                    @endif

                    @if ($order->status == 'open')
                        <button onclick="cancelOrder({{ $order->id }})"
                            class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Cancel Order
                        </button>
                    @endif

                    <a href="{{ route('user.orders.index') }}"
                        class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-center">
                        Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Order Modal -->
    <div id="cancelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.728-.833-2.498 0L4.316 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <div class="mt-2 px-7 py-3">
                    <h3 class="text-lg font-medium text-gray-900">Cancel Order</h3>
                    <p class="text-sm text-gray-500 mt-2">
                        Are you sure you want to cancel this order? This action cannot be undone.
                    </p>
                </div>
                <div class="items-center px-4 py-3 flex justify-end space-x-3">
                    <button onclick="closeCancelModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition-colors">
                        No, Keep Order
                    </button>
                    <form id="cancelForm" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                            Yes, Cancel Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function cancelOrder(orderId) {
            const modal = document.getElementById('cancelModal');
            const form = document.getElementById('cancelForm');
            form.action = `/user/orders/${orderId}/cancel`;
            modal.classList.remove('hidden');
        }

        function closeCancelModal() {
            const modal = document.getElementById('cancelModal');
            modal.classList.add('hidden');
        }

        // Close modal when clicking outside
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('cancelModal');
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeCancelModal();
                }
            });

            // Auto-hide success/error messages after 5 seconds
            const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 5000);
            });
        });
    </script>
@endsection
