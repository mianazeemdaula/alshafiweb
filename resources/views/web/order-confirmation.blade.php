@extends('layouts.guest')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Success Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                    <i class="fa-solid fa-check text-2xl text-green-600"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Confirmed!</h1>
                <p class="text-lg text-gray-600">Thank you for your order. We'll send you a confirmation email shortly.</p>
            </div>

            <!-- Order Details -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h2 class="text-xl font-semibold text-gray-900">Order Details</h2>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Order Information
                            </h3>
                            <div class="space-y-1">
                                <p><span class="font-medium">Order ID:</span> #{{ $order->id }}</p>
                                <p><span class="font-medium">Order Date:</span>
                                    {{ $order->created_at->format('M d, Y h:i A') }}</p>
                                <p><span class="font-medium">Payment Method:</span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Cash on Delivery
                                    </span>
                                </p>
                                <p><span class="font-medium">Status:</span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Shipping Address</h3>
                            @if ($order->shipping_address)
                                <div class="text-sm">
                                    <p class="font-medium">{{ $order->shipping_address['first_name'] ?? '' }}
                                        {{ $order->shipping_address['last_name'] ?? '' }}</p>
                                    <p>{{ $order->shipping_address['phone'] ?? '' }}</p>
                                    <p>{{ $order->shipping_address['address'] ?? $order->street_address }}</p>
                                    <p>{{ $order->shipping_address['city'] ?? '' }}</p>
                                </div>
                            @else
                                <div class="text-sm">
                                    <p>{{ $order->street_address }}</p>
                                    @if ($order->zip_code)
                                        <p>{{ $order->zip_code }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Order Items</h3>
                        <div class="space-y-4">
                            @foreach ($order->orderDetails as $detail)
                                <div class="flex items-center space-x-4 py-4 border-b last:border-b-0">
                                    <div
                                        class="flex-shrink-0 w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        @if ($detail->product->media->first())
                                            <img src="{{ asset($detail->product->media->first()->file_path) }}"
                                                alt="{{ $detail->product->name }}"
                                                class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <i class="fa-solid fa-box text-gray-400"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $detail->product->name }}</h4>
                                        <p class="text-sm text-gray-500">Quantity: {{ $detail->qty }}</p>
                                        <p class="text-sm text-gray-500">Price: RS. {{ number_format($detail->price, 2) }}
                                            each</p>
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">
                                        RS. {{ number_format($detail->price * $detail->qty, 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Total -->
                    <div class="mt-6 pt-6 border-t">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-medium text-gray-900">Total Amount:</span>
                            <span class="text-2xl font-bold text-gray-900">Rs.
                                {{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- What's Next -->
            <div class="bg-blue-50 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-blue-900 mb-2">What's Next?</h3>
                <ul class="space-y-2 text-sm text-blue-800">
                    <li class="flex items-start">
                        <i class="fa-solid fa-circle-check text-blue-600 mt-0.5 mr-2"></i>
                        <span>We'll prepare your order for shipping</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fa-solid fa-truck text-blue-600 mt-0.5 mr-2"></i>
                        <span>Your order will be delivered to your specified address</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fa-solid fa-money-bill text-blue-600 mt-0.5 mr-2"></i>
                        <span>Pay cash when you receive your order</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fa-solid fa-envelope text-blue-600 mt-0.5 mr-2"></i>
                        <span>We'll send you updates via email</span>
                    </li>
                </ul>
            </div>

            @if ($order->extra_note)
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Order Notes</h3>
                    <p class="text-gray-700">{{ $order->extra_note }}</p>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('web.products') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium text-center">
                    Continue Shopping
                </a>
                @auth
                    <a href="/dashboard"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-medium text-center">
                        View My Orders
                    </a>
                @endauth
            </div>
        </div>
    </div>
@endsection
