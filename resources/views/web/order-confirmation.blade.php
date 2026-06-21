@extends('layouts.guest')
@section('content')
    <div class="container mx-auto px-4 py-12 bg-transparent">
        <div class="max-w-4xl mx-auto">
            <!-- Success Header -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-100 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-900/50 text-emerald-700 dark:text-emerald-400 rounded-full mb-4 shadow-sm">
                    <i class="fa-solid fa-check text-2xl"></i>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-emerald-950 dark:text-emerald-100 mb-2 font-serif font-playfair">Order Confirmed!</h1>
                <p class="text-sm text-emerald-850/60 dark:text-emerald-400">Thank you for your order. We'll send you a confirmation email shortly.</p>
            </div>

            <!-- Order Details -->
            <div class="bg-white/90 dark:bg-emerald-950/20 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/30 overflow-hidden mb-6 shadow-sm">
                <div class="px-6 py-4 bg-emerald-50/40 dark:bg-emerald-900/10 border-b border-emerald-900/10 dark:border-emerald-800/30">
                    <h2 class="text-xl font-bold text-emerald-950 dark:text-emerald-100 font-serif">Order Details</h2>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-xs font-bold text-emerald-950/50 dark:text-emerald-400 uppercase tracking-wider mb-3">Order Information</h3>
                            <div class="space-y-2 text-sm text-emerald-850/80 dark:text-emerald-300">
                                <p class="flex justify-between sm:justify-start sm:gap-2"><span class="font-bold text-emerald-950 dark:text-emerald-100">Order ID:</span> <span>#{{ $order->id }}</span></p>
                                <p class="flex justify-between sm:justify-start sm:gap-2"><span class="font-bold text-emerald-950 dark:text-emerald-100">Order Date:</span> <span>{{ $order->created_at->format('M d, Y h:i A') }}</span></p>
                                <p class="flex justify-between sm:justify-start sm:gap-2"><span class="font-bold text-emerald-950 dark:text-emerald-100">Payment Method:</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/50 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-900/50">
                                        Cash on Delivery
                                    </span>
                                </p>
                                <p class="flex justify-between sm:justify-start sm:gap-2"><span class="font-bold text-emerald-950 dark:text-emerald-100">Status:</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-200 dark:bg-amber-950/40 dark:text-amber-300 dark:border-amber-900/50">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold text-emerald-950/50 dark:text-emerald-400 uppercase tracking-wider mb-3">Shipping Address</h3>
                            @if ($order->shipping_address)
                                <div class="text-sm text-emerald-850/80 dark:text-emerald-300 space-y-1">
                                    <p class="font-bold text-emerald-950 dark:text-emerald-100">{{ $order->shipping_address['first_name'] ?? '' }}
                                        {{ $order->shipping_address['last_name'] ?? '' }}</p>
                                    <p>{{ $order->shipping_address['phone'] ?? '' }}</p>
                                    <p>{{ $order->shipping_address['address'] ?? $order->street_address }}</p>
                                    <p>{{ $order->shipping_address['city'] ?? '' }}</p>
                                </div>
                            @else
                                <div class="text-sm text-emerald-850/80 dark:text-emerald-300 space-y-1">
                                    <p class="font-medium text-emerald-950 dark:text-emerald-100">{{ $order->street_address }}</p>
                                    @if ($order->zip_code)
                                        <p>{{ $order->zip_code }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="border-t border-emerald-900/10 dark:border-emerald-800/30 pt-6">
                        <h3 class="text-lg font-bold text-emerald-950 dark:text-emerald-100 font-serif mb-4">Order Items</h3>
                        <div class="space-y-4 divide-y divide-emerald-900/5 dark:divide-emerald-800/10">
                            @foreach ($order->orderDetails as $detail)
                                <div class="flex items-center space-x-4 py-4 first:pt-0">
                                    <div class="flex-shrink-0 w-16 h-16 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-900/10 rounded-xl flex items-center justify-center overflow-hidden">
                                        @if ($detail->product->media->first())
                                            <img src="{{ asset($detail->product->media->first()->file_path) }}"
                                                alt="{{ $detail->product->name }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <i class="fa-solid fa-box text-emerald-700/40 text-lg"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-bold text-emerald-950 dark:text-emerald-100">{{ $detail->product->name }}</h4>
                                        <p class="text-xs text-emerald-850/60 dark:text-emerald-400 mt-1">Quantity: {{ $detail->qty }}</p>
                                        <p class="text-xs text-emerald-850/60 dark:text-emerald-400">Price: RS. {{ number_format($detail->price, 2) }} each</p>
                                    </div>
                                    <div class="text-sm font-extrabold text-emerald-950 dark:text-emerald-50">
                                        RS. {{ number_format($detail->price * $detail->qty, 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Total -->
                    <div class="mt-6 pt-6 border-t border-emerald-900/10 dark:border-emerald-800/30">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-emerald-950 dark:text-emerald-100 font-serif">Total Amount:</span>
                            <span class="text-2xl font-extrabold text-emerald-900 dark:text-emerald-50">Rs.
                                {{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- What's Next -->
            <div class="bg-emerald-50/20 dark:bg-emerald-950/10 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/30 p-6 mb-6 shadow-sm">
                <h3 class="text-lg font-bold text-emerald-950 dark:text-emerald-100 font-serif mb-4">What's Next?</h3>
                <ul class="space-y-3 text-sm text-emerald-850 dark:text-emerald-300">
                    <li class="flex items-start">
                        <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 mr-3"></i>
                        <span class="font-medium">We'll prepare your order for shipping</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fa-solid fa-truck text-emerald-600 mt-0.5 mr-3"></i>
                        <span class="font-medium">Your order will be delivered to your specified address</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fa-solid fa-money-bill text-emerald-600 mt-0.5 mr-3"></i>
                        <span class="font-medium">Pay cash when you receive your order</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fa-solid fa-envelope text-emerald-600 mt-0.5 mr-3"></i>
                        <span class="font-medium">We'll send you updates via email</span>
                    </li>
                </ul>
            </div>

            @if ($order->extra_note)
                <div class="bg-white/90 dark:bg-emerald-950/20 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/30 p-6 mb-6 shadow-sm">
                    <h3 class="text-lg font-bold text-emerald-950 dark:text-emerald-100 font-serif mb-2">Order Notes</h3>
                    <p class="text-sm text-emerald-850 dark:text-emerald-300 leading-relaxed">{{ $order->extra_note }}</p>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('web.products') }}"
                    class="h-11 px-5 inline-flex items-center justify-center bg-emerald-700 hover:bg-emerald-800 dark:bg-emerald-600 dark:hover:bg-emerald-500 text-white rounded-xl font-bold text-sm transition-all shadow-sm hover:shadow-md shadow-emerald-700/10 cursor-pointer">
                    Continue Shopping
                </a>
                @auth
                    <a href="/dashboard"
                        class="h-11 px-5 inline-flex items-center justify-center border border-emerald-200 dark:border-emerald-800/50 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-800 dark:text-emerald-200 rounded-xl font-bold text-sm transition-all hover:bg-emerald-100 dark:hover:bg-emerald-900/40 cursor-pointer">
                        View My Orders
                    </a>
                @endauth
            </div>
        </div>
    </div>
@endsection
