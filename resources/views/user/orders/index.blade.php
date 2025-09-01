@extends('layouts.user')

@section('main')

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">{{ __('My Orders') }}</h1>
                <a href="{{ route('user.dashboard') }}" class="text-blue-600 hover:text-blue-800">
                    ← {{ __('Back to Dashboard') }}
                </a>
            </div>

            <!-- Order Status Filter -->
            <div class="mb-6">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('user.orders.index') }}"
                        class="px-4 py-2 rounded-lg {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition-colors">
                        {{ __('All Orders') }}
                    </a>
                    <a href="{{ route('user.orders.index', ['status' => 'open']) }}"
                        class="px-4 py-2 rounded-lg {{ request('status') == 'open' ? 'bg-yellow-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition-colors">
                        {{ __('Pending') }}
                    </a>
                    <a href="{{ route('user.orders.index', ['status' => 'processing']) }}"
                        class="px-4 py-2 rounded-lg {{ request('status') == 'processing' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition-colors">
                        Processing
                    </a>
                    <a href="{{ route('user.orders.index', ['status' => 'shipped']) }}"
                        class="px-4 py-2 rounded-lg {{ request('status') == 'shipped' ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition-colors">
                        Shipped
                    </a>
                    <a href="{{ route('user.orders.index', ['status' => 'completed']) }}"
                        class="px-4 py-2 rounded-lg {{ request('status') == 'completed' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition-colors">
                        Completed
                    </a>
                    <a href="{{ route('user.orders.index', ['status' => 'cancelled']) }}"
                        class="px-4 py-2 rounded-lg {{ request('status') == 'cancelled' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition-colors">
                        Cancelled
                    </a>
                </div>
            </div>

            @if ($orders->count() > 0)
                <!-- Orders List -->
                <div class="space-y-4">
                    @foreach ($orders as $order)
                        <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-4 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900">Order #{{ $order->id }}</h3>
                                        <span
                                            class="px-3 py-1 text-xs font-medium rounded-full
                                    @if ($order->status == 'completed') bg-green-100 text-green-800
                                    @elseif($order->status == 'open') bg-yellow-100 text-yellow-800
                                    @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                    @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                                    @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                                        <div>
                                            <span class="font-medium">Order Date:</span>
                                            {{ $order->created_at->format('M d, Y') }}
                                        </div>
                                        <div>
                                            <span class="font-medium">Total Amount:</span>
                                            RS. {{ number_format($order->total, 2) }}
                                        </div>
                                        <div>
                                            <span class="font-medium">Items:</span>
                                            {{ $order->orderDetails->count() }}
                                            {{ Str::plural('item', $order->orderDetails->count()) }}
                                        </div>
                                    </div>

                                    <!-- Order Items Preview -->
                                    @if ($order->orderDetails->count() > 0)
                                        <div class="mt-3 pt-3 border-t border-gray-100">
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($order->orderDetails->take(3) as $detail)
                                                    <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">
                                                        {{ $detail->product->name ?? 'Product' }} ({{ $detail->qty }})
                                                    </span>
                                                @endforeach
                                                @if ($order->orderDetails->count() > 3)
                                                    <span class="text-xs text-gray-500">
                                                        +{{ $order->orderDetails->count() - 3 }} more
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div
                                    class="mt-4 md:mt-0 md:ml-6 flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                                    <a href="{{ route('user.orders.show', $order->id) }}"
                                        class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors text-center">
                                        View Details
                                    </a>

                                    @if ($order->status == 'completed')
                                        <a href="{{ route('user.orders.track', $order->id) }}"
                                            class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-colors text-center">
                                            Track Order
                                        </a>
                                    @elseif(in_array($order->status, ['open', 'processing']))
                                        <a href="{{ route('user.orders.track', $order->id) }}"
                                            class="px-4 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition-colors text-center">
                                            Track Order
                                        </a>

                                        @if ($order->status == 'open')
                                            <button onclick="cancelOrder({{ $order->id }})"
                                                class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition-colors">
                                                Cancel
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No orders found</h3>
                    <p class="mt-2 text-gray-500">
                        @if (request('status'))
                            You don't have any {{ request('status') }} orders yet.
                        @else
                            You haven't placed any orders yet.
                        @endif
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('web.products') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Start Shopping
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Cancel Order Modal -->
    <div id="cancelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.728-.833-2.498 0L4.316 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <div class="mt-2 px-7 py-3">
                    <h3 class="text-lg font-medium text-gray-900">Cancel Order</h3>
                    <p class="text-sm text-gray-500 mt-2">
                        Are you sure you want to cancel this order? This action cannot be undone.
                    </p>
                </div>
                <div class="items-center px-4 py-3 flex justify-end space-x-3">
                    <button onclick="closeCancelModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition-colors">
                        No, Keep Order
                    </button>
                    <form id="cancelForm" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                            Yes, Cancel Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function cancelOrder(orderId) {
            const modal = document.getElementById('cancelModal');
            const form = document.getElementById('cancelForm');
            form.action = `/user/orders/${orderId}/cancel`;
            modal.classList.remove('hidden');
        }

        function closeCancelModal() {
            const modal = document.getElementById('cancelModal');
            modal.classList.add('hidden');
        }

        // Close modal when clicking outside
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('cancelModal');
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeCancelModal();
                }
            });
        });
    </script>
@endsection
