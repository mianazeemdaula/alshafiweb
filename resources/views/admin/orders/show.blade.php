@extends('layouts.admin')

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
    </div>
@endsection
