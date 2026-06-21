@extends('layouts.guest')

@section('title', 'Track Order')

@section('content')
    <div class="bg-transparent">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-900/10 dark:border-emerald-800/20 mb-5">
                    <i class="fa-solid fa-truck text-xl text-emerald-750 dark:text-emerald-400"></i>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-emerald-950 dark:text-white font-playfair font-serif">
                    {{ __('track_order') }}
                </h1>
                <p class="mt-3 text-sm text-emerald-850/70 dark:text-emerald-400">
                    {{ __('Enter your order number below to see its current status.') }}
                </p>
            </div>

            <div class="bg-white/90 dark:bg-emerald-950/20 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/30 p-6 sm:p-8 shadow-sm">
                <form method="get" action="{{ route('track.order') }}" class="flex flex-col sm:flex-row gap-3">
                    <input type="text" name="order_number"
                        class="flex-1 h-10 border border-emerald-900/10 dark:border-emerald-800/40 rounded-xl px-4 bg-[#f6f3eb]/40 dark:bg-emerald-950/20 text-emerald-955 dark:text-gray-100 placeholder-emerald-955/30 dark:placeholder-emerald-400/30 focus:outline-none focus:ring-4 focus:ring-emerald-100 dark:focus:ring-emerald-950/30 focus:border-emerald-600 text-xs transition-all"
                        placeholder="{{ __('Enter your order number') }}" value="{{ request('order_number') }}" required>
                    <button type="submit"
                        class="h-10 bg-emerald-700 hover:bg-emerald-800 text-white px-5 rounded-xl text-xs font-bold transition-all whitespace-nowrap shadow-sm hover:shadow-md shadow-emerald-700/10 cursor-pointer flex items-center justify-center">
                        <i class="fa-solid fa-search mr-2"></i>{{ __('Track') }}
                    </button>
                </form>

                @if (request('order_number'))
                    @if ($order)
                        <div class="mt-6 p-5 bg-emerald-50/50 dark:bg-emerald-900/30 rounded-xl border border-emerald-100 dark:border-emerald-900/50">
                            <div class="flex items-center gap-2.5 mb-3">
                                <i class="fa-solid fa-circle-check text-emerald-700 dark:text-emerald-400"></i>
                                <h3 class="font-bold text-emerald-950 dark:text-white">
                                    {{ __('Order Status:') }}
                                    <span class="text-emerald-800 dark:text-emerald-300 font-extrabold">{{ $order->status }}</span>
                                </h3>
                            </div>
                            <dl class="space-y-2.5 text-sm">
                                <div class="flex gap-2">
                                    <dt class="text-emerald-850/60 dark:text-emerald-400 font-semibold">{{ __('Order Number:') }}</dt>
                                    <dd class="font-mono font-bold text-emerald-950 dark:text-emerald-100">{{ $order->order_number }}</dd>
                                </div>
                                <div class="flex gap-2">
                                    <dt class="text-emerald-850/60 dark:text-emerald-400 font-semibold">{{ __('Placed on:') }}</dt>
                                    <dd class="text-emerald-950 dark:text-emerald-100 font-medium">{{ $order->created_at->format('d M Y, h:i A') }}</dd>
                                </div>
                            </dl>
                        </div>
                    @else
                        <div class="mt-6 p-5 bg-rose-50/50 dark:bg-rose-900/30 rounded-xl border border-rose-100 dark:border-rose-900/50 flex items-start gap-3">
                            <i class="fa-solid fa-circle-exclamation text-rose-600 dark:text-rose-400 mt-0.5"></i>
                            <p class="text-sm text-rose-700 dark:text-rose-300 font-semibold">
                                {{ __('Order not found. Please check your order number.') }}
                            </p>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection
