@extends('layouts.web')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Order Details: {{ $order->number }}</h1>
                <a href="{{ route('admin.specialist-orders.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </a>
            </div>

            <!-- Order Status & Info -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                    <p class="text-sm text-blue-600 font-medium">Order Status</p>
                    @php
                        $statusColors = [
                            'open' => 'bg-blue-100 text-blue-800',
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'processing' => 'bg-indigo-100 text-indigo-800',
                            'shipped' => 'bg-purple-100 text-purple-800',
                            'delivered' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                            'returned' => 'bg-gray-100 text-gray-800',
                        ];
                        $statusColor = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="mt-2 inline-block px-3 py-1 text-sm font-semibold rounded-full {{ $statusColor }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                    <p class="text-sm text-green-600 font-medium">Total Amount</p>
                    <p class="text-2xl font-bold text-green-800">Rs {{ number_format($order->total) }}</p>
                </div>
                <div
                    class="bg-{{ $order->penalty ? 'red' : 'gray' }}-50 rounded-lg p-4 border border-{{ $order->penalty ? 'red' : 'gray' }}-200">
                    <p class="text-sm text-{{ $order->penalty ? 'red' : 'gray' }}-600 font-medium">Penalty Status</p>
                    @if ($order->penalty)
                        <p class="text-xl font-bold text-red-800">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Rs {{ number_format($order->penalty->penalty_amount) }}
                        </p>
                        <p class="text-xs text-red-600 mt-1">{{ $order->penalty->reason }}</p>
                    @else
                        <p class="text-xl font-bold text-gray-800">No Penalty</p>
                    @endif
                </div>
            </div>

            <!-- Customer & Order Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Customer Information -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">
                        <i class="fas fa-user mr-2"></i>Customer Information
                    </h3>
                    <div class="space-y-2 text-sm">
                        <div>
                            <span class="font-medium text-gray-600">Name:</span>
                            <span class="text-gray-800">{{ $order->customer_name }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Phone:</span>
                            <span class="text-gray-800">{{ $order->customer_phone }}</span>
                        </div>
                        @if ($order->customer_email)
                            <div>
                                <span class="font-medium text-gray-600">Email:</span>
                                <span class="text-gray-800">{{ $order->customer_email }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">
                        <i class="fas fa-map-marker-alt mr-2"></i>Shipping Address
                    </h3>
                    <div class="space-y-2 text-sm">
                        <div>
                            <span class="font-medium text-gray-600">Address:</span>
                            <span class="text-gray-800">{{ $order->street_address }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">City:</span>
                            <span class="text-gray-800">{{ $order->city->name ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Country:</span>
                            <span class="text-gray-800">{{ $order->country->name ?? 'N/A' }}</span>
                        </div>
                        @if ($order->zip_code)
                            <div>
                                <span class="font-medium text-gray-600">Zip Code:</span>
                                <span class="text-gray-800">{{ $order->zip_code }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Details -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">
                    <i class="fas fa-box mr-2"></i>Order Items
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Product</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Price</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Quantity</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($order->orderDetails as $detail)
                                <tr>
                                    <td class="px-4 py-2">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $detail->product->name ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-700">Rs {{ number_format($detail->price) }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $detail->qty }}</td>
                                    <td class="px-4 py-2 text-sm font-semibold text-gray-900">
                                        Rs {{ number_format($detail->price * $detail->qty) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">
                    <i class="fas fa-calculator mr-2"></i>Order Summary
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="text-gray-800">Rs
                            {{ number_format($order->orderDetails->sum(function ($detail) {return $detail->price * $detail->qty;})) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping Cost:</span>
                        <span class="text-gray-800">Rs {{ number_format($order->shipping_cost) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Discount:</span>
                        <span class="text-red-600">- Rs {{ number_format($order->discount) }}</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-gray-300">
                        <span class="font-semibold text-gray-800">Total:</span>
                        <span class="font-bold text-lg text-gray-900">Rs {{ number_format($order->total) }}</span>
                    </div>
                    @if ($order->penalty)
                        <div
                            class="flex justify-between pt-2 border-t border-red-200 bg-red-50 -mx-4 px-4 py-2 rounded mt-2">
                            <span class="font-semibold text-red-800">Penalty Applied:</span>
                            <span class="font-bold text-red-900">- Rs
                                {{ number_format($order->penalty->penalty_amount) }}</span>
                        </div>
                    @endif
                </div>

                @if ($order->extra_note)
                    <div class="mt-4 pt-4 border-t border-gray-300">
                        <span class="font-medium text-gray-600">Note:</span>
                        <p class="text-sm text-gray-800 mt-1">{{ $order->extra_note }}</p>
                    </div>
                @endif
            </div>

            <!-- Additional Information -->
            <div class="mt-6 text-sm text-gray-600">
                <div class="flex justify-between">
                    <span>Order Created: {{ $order->created_at->format('M d, Y h:i A') }}</span>
                    <span>Payment Method: {{ $order->paymentMethod->name ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
