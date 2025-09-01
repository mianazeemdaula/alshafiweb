@extends('layouts.web')

@section('main')

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center mb-6">
                    <a href="{{ route('user.orders.show', $order->id) }}" class="text-gray-600 hover:text-gray-800 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h1 class="text-3xl font-bold text-gray-800">Track Order #{{ $order->id }}</h1>
                </div>

                <!-- Order Summary Card -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <div class="text-sm text-gray-600">Order Date</div>
                            <div class="font-semibold">{{ $order->created_at->format('M d, Y') }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Order Status</div>
                            <span
                                class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                            @if ($order->status == 'completed') bg-green-100 text-green-800
                            @elseif($order->status == 'open') bg-yellow-100 text-yellow-800
                            @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                            @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                            @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600">Total Amount</div>
                            <div class="font-semibold">RS. {{ number_format($order->total, 2) }}</div>
                        </div>
                        @if ($order->tracking_number)
                            <div>
                                <div class="text-sm text-gray-600">Tracking Number</div>
                                <div class="font-semibold font-mono">{{ $order->tracking_number }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Order Progress Tracker -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Order Progress</h2>

                    @php
                        $statuses = [
                            'open' => ['label' => 'Order Placed', 'icon' => 'shopping-cart'],
                            'processing' => ['label' => 'Processing', 'icon' => 'cog'],
                            'shipped' => ['label' => 'Shipped', 'icon' => 'truck'],
                            'completed' => ['label' => 'Delivered', 'icon' => 'check-circle'],
                        ];

                        $statusOrder = ['open', 'processing', 'shipped', 'completed'];
                        $currentStatusIndex = array_search($order->status, $statusOrder);
                        $isCancelled = $order->status == 'cancelled';
                    @endphp

                    @if ($isCancelled)
                        <!-- Cancelled Order Display -->
                        <div class="flex items-center justify-center p-8 bg-red-50 rounded-lg">
                            <div class="text-center">
                                <div
                                    class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-red-900">Order Cancelled</h3>
                                <p class="text-red-700 mt-2">This order has been cancelled.</p>
                                @if ($order->cancelled_at)
                                    <p class="text-sm text-red-600 mt-1">Cancelled on
                                        {{ $order->cancelled_at->format('M d, Y \a\t h:i A') }}</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <!-- Progress Steps -->
                        <div class="relative">
                            <!-- Progress Line -->
                            <div class="absolute top-5 left-0 w-full h-0.5 bg-gray-200">
                                <div class="h-full bg-blue-600 transition-all duration-500"
                                    style="width: {{ $currentStatusIndex !== false ? (($currentStatusIndex + 1) / count($statusOrder)) * 100 : 0 }}%">
                                </div>
                            </div>

                            <!-- Steps -->
                            <div class="relative flex justify-between">
                                @foreach ($statusOrder as $index => $status)
                                    @php
                                        $isPassed = $currentStatusIndex !== false && $index <= $currentStatusIndex;
                                        $isCurrent = $currentStatusIndex !== false && $index == $currentStatusIndex;
                                        $statusData = $statuses[$status];
                                    @endphp

                                    <div class="flex flex-col items-center">
                                        <!-- Step Circle -->
                                        <div
                                            class="relative z-10 w-10 h-10 rounded-full flex items-center justify-center
                                        {{ $isPassed ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-400' }}
                                        {{ $isCurrent ? 'ring-4 ring-blue-200' : '' }}">
                                            @if ($statusData['icon'] == 'shopping-cart')
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                                </svg>
                                            @elseif($statusData['icon'] == 'cog')
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @elseif($statusData['icon'] == 'truck')
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                                    <path
                                                        d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707L16 7.586A1 1 0 0015.414 7H14z" />
                                                </svg>
                                            @elseif($statusData['icon'] == 'check-circle')
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                        </div>

                                        <!-- Step Label -->
                                        <div class="mt-2 text-center">
                                            <div
                                                class="text-sm font-medium {{ $isPassed ? 'text-blue-600' : 'text-gray-500' }}">
                                                {{ $statusData['label'] }}
                                            </div>
                                            @if ($isCurrent)
                                                <div class="text-xs text-blue-600 mt-1">Current</div>
                                            @elseif($isPassed)
                                                <div class="text-xs text-green-600 mt-1">✓ Complete</div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Current Status Description -->
                        <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                            @if ($order->status == 'open')
                                <h3 class="font-medium text-blue-900">Your order has been placed!</h3>
                                <p class="text-blue-700 mt-1">We've received your order and will start processing it soon.
                                </p>
                            @elseif($order->status == 'processing')
                                <h3 class="font-medium text-blue-900">Your order is being processed</h3>
                                <p class="text-blue-700 mt-1">We're preparing your items for shipment.</p>
                            @elseif($order->status == 'shipped')
                                <h3 class="font-medium text-blue-900">Your order has been shipped!</h3>
                                <p class="text-blue-700 mt-1">Your order is on its way and should arrive soon.</p>
                                @if ($order->tracking_number)
                                    <p class="text-blue-700 mt-1">Tracking Number: <span
                                            class="font-mono">{{ $order->tracking_number }}</span></p>
                                @endif
                            @elseif($order->status == 'completed')
                                <h3 class="font-medium text-blue-900">Order delivered!</h3>
                                <p class="text-blue-700 mt-1">Your order has been successfully delivered. Thank you for
                                    shopping with us!</p>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Order Items -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Items in this Order</h2>
                    <div class="space-y-4">
                        @foreach ($order->orderDetails as $detail)
                            <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                                @if ($detail->product && $detail->product->media->count() > 0)
                                    <img class="h-16 w-16 rounded-lg object-cover"
                                        src="{{ asset('storage/' . $detail->product->media->first()->path) }}"
                                        alt="{{ $detail->product->name }}">
                                @else
                                    <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif

                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">
                                        {{ $detail->product->name ?? 'Product Not Found' }}</h4>
                                    <p class="text-sm text-gray-600">Quantity: {{ $detail->qty }}</p>
                                    <p class="text-sm text-gray-600">Price: RS. {{ number_format($detail->price, 2) }}</p>
                                </div>

                                <div class="text-right">
                                    <div class="font-medium text-gray-900">RS.
                                        {{ number_format($detail->qty * $detail->price, 2) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('user.orders.show', $order->id) }}"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-center">
                        View Order Details
                    </a>

                    @if ($order->status == 'completed')
                        <a href="{{ route('user.orders.index') }}"
                            class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-center">
                            Write Reviews
                        </a>
                    @endif

                    <a href="{{ route('user.orders.index') }}"
                        class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-center">
                        Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Auto-refresh the page every 30 seconds if order is not completed or cancelled
        document.addEventListener('DOMContentLoaded', function() {
            const orderStatus = '{{ $order->status }}';
            if (!['completed', 'cancelled'].includes(orderStatus)) {
                setTimeout(() => {
                    window.location.reload();
                }, 30000); // 30 seconds
            }
        });
    </script>
@endsection
