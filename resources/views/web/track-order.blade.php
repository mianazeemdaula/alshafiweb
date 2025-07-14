@extends('layouts.guest')

@section('title', 'Track Order')

@section('content')
    <div
        class="max-w-lg mx-auto mt-10 p-8 bg-white dark:bg-gray-900 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-bold mb-6 text-blue-700 dark:text-blue-400 flex items-center">
            <i class="fa-solid fa-truck mr-2"></i>{{ __('track_order') }}
        </h2>
        <form method="get" action="{{ route('track.order') }}" class="flex flex-col gap-4">
            <input type="text" name="order_number"
                class="border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500"
                placeholder="{{ __('Enter your order number') }}" value="{{ request('order_number') }}" required>
            <button type="submit"
                class="bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 text-white px-4 py-2 rounded font-medium transition-colors">
                {{ __('Track') }}</button>
        </form>
        @if (request('order_number'))
            @if ($order)
                <div
                    class="mt-6 p-4 bg-green-50 dark:bg-green-900 rounded-lg border border-green-200 dark:border-green-700">
                    <h3 class="font-semibold text-green-800 dark:text-green-200">
                        {{ __('Order Status:') }}
                        <span class="text-blue-700 dark:text-blue-400">{{ $order->status }}</span>
                    </h3>
                    <div class="text-gray-700 dark:text-gray-200">
                        {{ __('Order Number:') }}
                        <span class="font-mono">{{ $order->order_number }}</span>
                    </div>
                    <div class="text-gray-700 dark:text-gray-200">
                        {{ __('Placed on:') }} {{ $order->created_at->format('d M Y, h:i A') }}
                    </div>
                    <!-- Add more order details as needed -->
                </div>
            @else
                <div
                    class="mt-6 p-4 bg-red-50 dark:bg-red-900 rounded-lg text-red-600 dark:text-red-300 border border-red-200 dark:border-red-700">
                    {{ __('Order not found. Please check your order number.') }}
                </div>
            @endif
        @endif
    </div>
@endsection
