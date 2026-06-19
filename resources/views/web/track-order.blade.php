@extends('layouts.guest')

@section('title', 'Track Order')

@section('content')
    <div class="bg-white dark:bg-gray-900">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/40 mb-5">
                    <i class="fa-solid fa-truck text-lg text-emerald-600 dark:text-emerald-400"></i>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                    {{ __('track_order') }}
                </h1>
                <p class="mt-3 text-base text-gray-500 dark:text-gray-400">
                    {{ __('Enter your order number below to see its current status.') }}
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
                <form method="get" action="{{ route('track.order') }}" class="flex flex-col sm:flex-row gap-3">
                    <input type="text" name="order_number"
                        class="flex-1 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm"
                        placeholder="{{ __('Enter your order number') }}" value="{{ request('order_number') }}" required>
                    <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl text-sm font-semibold transition-colors whitespace-nowrap">
                        <i class="fa-solid fa-search mr-2"></i>{{ __('Track') }}
                    </button>
                </form>

                @if (request('order_number'))
                    @if ($order)
                        <div class="mt-6 p-5 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl border border-emerald-100 dark:border-emerald-900">
                            <div class="flex items-center gap-2 mb-3">
                                <i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400"></i>
                                <h3 class="font-semibold text-gray-900 dark:text-white">
                                    {{ __('Order Status:') }}
                                    <span class="text-emerald-700 dark:text-emerald-400">{{ $order->status }}</span>
                                </h3>
                            </div>
                            <dl class="space-y-2 text-sm">
                                <div class="flex gap-2">
                                    <dt class="text-gray-500 dark:text-gray-400">{{ __('Order Number:') }}</dt>
                                    <dd class="font-mono text-gray-900 dark:text-gray-100">{{ $order->order_number }}</dd>
                                </div>
                                <div class="flex gap-2">
                                    <dt class="text-gray-500 dark:text-gray-400">{{ __('Placed on:') }}</dt>
                                    <dd class="text-gray-900 dark:text-gray-100">{{ $order->created_at->format('d M Y, h:i A') }}</dd>
                                </div>
                            </dl>
                        </div>
                    @else
                        <div class="mt-6 p-5 bg-red-50 dark:bg-red-900/30 rounded-xl border border-red-100 dark:border-red-900 flex items-start gap-3">
                            <i class="fa-solid fa-circle-exclamation text-red-600 dark:text-red-400 mt-0.5"></i>
                            <p class="text-sm text-red-700 dark:text-red-300">
                                {{ __('Order not found. Please check your order number.') }}
                            </p>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection

