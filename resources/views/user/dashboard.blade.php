@extends('layouts.guest')

@section('content')
    @include('components.user-nav')

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ __('My Dashboard') }}</h1>

            <!-- User Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-blue-100 p-6 rounded-lg border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-blue-800">{{ __('Total Orders') }}</h3>
                            <p class="text-3xl font-bold text-blue-600">{{ $stats['total_orders'] }}</p>
                        </div>
                        <div class="text-blue-500">
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-yellow-100 p-6 rounded-lg border-l-4 border-yellow-500">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-yellow-800">{{ __('Pending Orders') }}</h3>
                            <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending_orders'] }}</p>
                        </div>
                        <div class="text-yellow-500">
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-green-100 p-6 rounded-lg border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-green-800">{{ __('Completed Orders') }}</h3>
                            <p class="text-3xl font-bold text-green-600">{{ $stats['completed_orders'] }}</p>
                        </div>
                        <div class="text-green-500">
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-purple-100 p-6 rounded-lg border-l-4 border-purple-500">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-purple-800">{{ __('Total Spent') }}</h3>
                            <p class="text-3xl font-bold text-purple-600">RS. {{ number_format($stats['total_spent'], 2) }}
                            </p>
                        </div>
                        <div class="text-purple-500">
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.51-1.31c-.562-.649-1.413-1.076-2.353-1.253V5z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-indigo-100 p-6 rounded-lg border-l-4 border-indigo-500">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-indigo-800">{{ __('Total Reviews') }}</h3>
                            <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_reviews'] }}</p>
                        </div>
                        <div class="text-indigo-500">
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                    </div>
                </div>

                @if (isset($stats['referral_products']))
                    <div class="bg-pink-100 p-6 rounded-lg border-l-4 border-pink-500">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-pink-800">Referral Products</h3>
                                <p class="text-3xl font-bold text-pink-600">{{ $stats['referral_products'] }}</p>
                            </div>
                            <div class="text-pink-500">
                                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <a href="{{ route('user.profile.show') }}"
                    class="bg-white border border-gray-200 p-6 rounded-lg hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold">{{ __('My Profile') }}</h3>
                            <p class="text-gray-600">{{ __('Manage your account') }}</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('user.orders.index') }}"
                    class="bg-white border border-gray-200 p-6 rounded-lg hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold">{{ __('My Orders') }}</h3>
                            <p class="text-gray-600">{{ __('Track your orders') }}</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('user.reviews.index') }}"
                    class="bg-white border border-gray-200 p-6 rounded-lg hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="bg-yellow-100 p-3 rounded-full">
                            <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold">My Reviews</h3>
                            <p class="text-gray-600">Manage your reviews</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Recent Orders -->
            @if ($recent_orders->count() > 0)
                <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Recent Orders</h2>
                        <a href="{{ route('user.orders.index') }}" class="text-blue-600 hover:text-blue-800">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Order ID</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($recent_orders as $order)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            #{{ $order->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if ($order->status == 'completed') bg-green-100 text-green-800
                                    @elseif($order->status == 'pending' || $order->status == 'open') bg-yellow-100 text-yellow-800
                                    @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">RS.
                                            {{ number_format($order->total, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('user.orders.show', $order->id) }}"
                                                class="text-blue-600 hover:text-blue-900">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Recent Reviews -->
            @if ($recent_reviews->count() > 0)
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Recent Reviews</h2>
                        <a href="{{ route('user.reviews.index') }}" class="text-blue-600 hover:text-blue-800">View
                            All</a>
                    </div>
                    <div class="space-y-4">
                        @foreach ($recent_reviews as $review)
                            <div class="border-b border-gray-200 pb-4 last:border-b-0">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{ $review->product->name ?? 'Product' }}
                                        </h4>
                                        <div class="flex items-center mt-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                            <span
                                                class="ml-2 text-sm text-gray-600">{{ $review->created_at->format('M d, Y') }}</span>
                                        </div>
                                        @if ($review->comment)
                                            <p class="mt-2 text-gray-700">{{ Str::limit($review->comment, 100) }}</p>
                                        @endif
                                    </div>
                                    <a href="{{ route('user.reviews.edit', $review->id) }}"
                                        class="text-blue-600 hover:text-blue-900 text-sm">Edit</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
