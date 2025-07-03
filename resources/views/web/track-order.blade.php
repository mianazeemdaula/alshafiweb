@extends('layouts.guest')

@section('title', 'Track Order')

@section('content')
    <div class="max-w-lg mx-auto mt-10 p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Track Your Order</h2>
        <form method="get" action="{{ route('track.order') }}" class="flex flex-col gap-4">
            <input type="text" name="order_number" class="border rounded px-3 py-2" placeholder="Enter your order number"
                value="{{ request('order_number') }}" required>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Track</button>
        </form>
        @if (request('order_number'))
            @if ($order)
                <div class="mt-6 p-4 bg-green-50 rounded">
                    <h3 class="font-semibold">Order Status: <span class="text-blue-700">{{ $order->status }}</span></h3>
                    <div>Order Number: <span class="font-mono">{{ $order->order_number }}</span></div>
                    <div>Placed on: {{ $order->created_at->format('d M Y, h:i A') }}</div>
                    <!-- Add more order details as needed -->
                </div>
            @else
                <div class="mt-6 p-4 bg-red-50 rounded text-red-600">Order not found. Please check your order number.</div>
            @endif
        @endif
    </div>
@endsection
