@extends('layouts.web')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Orders Management</h1>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.orders.create') }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-plus mr-2"></i>New Order
                    </a>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Order ID, Customer name..."
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing
                            </option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered
                            </option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                        <select name="payment_status"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Payment Status</option>
                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed
                            </option>
                        </select>
                    </div>

                    <div class="flex items-end space-x-2">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                            <i class="fas fa-search mr-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.orders.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                            <i class="fas fa-times mr-1"></i>Clear
                        </a>
                    </div>
                </form>
            </div>

            <!-- Orders Table for Desktop -->
            <div class="desktop-only overflow-x-auto">
                <table class="enhanced-table w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Order</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Customer</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Payment</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Total</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Date</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($orders as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div>
                                        <div class="font-medium text-gray-900">Order #{{ $item->id }}</div>
                                        @if ($item->shipment)
                                            <div class="text-xs text-blue-600">
                                                <i class="fas fa-shipping-fast mr-1"></i>
                                                {{ ucfirst($item->shipment->courierService->courier ?? '') }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <div class="user-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $item->user->name ?? 'Guest' }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $item->user->mobile ?? ($item->user->email ?? '') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="space-y-1">
                                        <div>
                                            @php
                                                $statusColors = [
                                                    'pending' => 'status-pending',
                                                    'processing' => 'status-processing',
                                                    'shipped' => 'status-shipped',
                                                    'delivered' => 'status-delivered',
                                                    'cancelled' => 'status-cancelled',
                                                ];
                                                $statusClass =
                                                    $statusColors[$item->status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="status-badge {{ $statusClass }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </div>
                                        @if ($item->shipment)
                                            <div>
                                                <span class="status-badge {{ $item->shipment->status_badge }}">
                                                    {{ \App\Models\Shipment::getStatuses()[$item->shipment->status] ?? '' }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div>
                                        <div class="text-sm text-gray-900">
                                            {{ $item->paymentMethod->name ?? 'N/A' }}
                                        </div>
                                        @php
                                            $paymentColors = [
                                                'paid' => 'status-delivered',
                                                'pending' => 'status-pending',
                                                'failed' => 'status-cancelled',
                                            ];
                                            $paymentClass =
                                                $paymentColors[$item->payment_status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="status-badge {{ $paymentClass }}">
                                            {{ ucfirst($item->payment_status) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900">
                                        ${{ number_format($item->total, 2) }}
                                    </div>
                                    @if ($item->shipping_cost > 0)
                                        <div class="text-xs text-gray-500">
                                            +${{ number_format($item->shipping_cost, 2) }} shipping
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm text-gray-900">
                                        {{ $item->created_at->format('M d, Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $item->created_at->format('H:i') }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="action-buttons">
                                        <!-- View -->
                                        <a href="{{ route('admin.orders.show', $item->id) }}"
                                            class="action-btn action-btn-view" title="View Order">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('admin.orders.edit', $item->id) }}"
                                            class="action-btn action-btn-edit" title="Edit Order">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Ship Order -->
                                        @if (!$item->shipment && $item->status !== 'cancelled')
                                            <a href="{{ route('admin.shipments.create', ['order_id' => $item->id]) }}"
                                                class="action-btn action-btn-ship" title="Ship Order">
                                                <i class="fas fa-shipping-fast"></i>
                                            </a>
                                        @endif

                                        <!-- Track Shipment -->
                                        @if ($item->shipment && $item->shipment->tracking_number)
                                            <a href="{{ route('admin.shipments.show', $item->shipment->id) }}"
                                                class="action-btn action-btn-track" title="Track Shipment">
                                                <i class="fas fa-search-location"></i>
                                            </a>
                                        @endif

                                        <!-- Delete -->
                                        @if ($item->status === 'cancelled' || $item->status === 'pending')
                                            <form action="{{ route('admin.orders.destroy', $item->id) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this order?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn action-btn-delete"
                                                    title="Delete Order">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                    <i class="fas fa-shopping-cart text-4xl mb-4 text-gray-300"></i>
                                    <p class="text-lg mb-2">No orders found</p>
                                    <p class="text-sm">Orders will appear here once customers start placing them</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Orders Cards for Mobile -->
            <div class="mobile-only space-y-4">
                @forelse ($orders as $item)
                    <div class="order-card">
                        <div class="order-card-header">
                            <div>
                                <div class="order-card-title">Order #{{ $item->id }}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $item->created_at->format('M d, Y H:i') }}
                                </div>
                            </div>
                            <div class="action-buttons">
                                <a href="{{ route('admin.orders.show', $item->id) }}" class="action-btn action-btn-view"
                                    title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.orders.edit', $item->id) }}" class="action-btn action-btn-edit"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>

                        <div class="order-card-content">
                            <div class="order-card-row">
                                <span class="order-card-label">Customer:</span>
                                <span class="order-card-value">{{ $item->user->name ?? 'Guest' }}</span>
                            </div>

                            <div class="order-card-row">
                                <span class="order-card-label">Status:</span>
                                <span class="order-card-value">
                                    @php
                                        $statusColors = [
                                            'pending' => 'status-pending',
                                            'processing' => 'status-processing',
                                            'shipped' => 'status-shipped',
                                            'delivered' => 'status-delivered',
                                            'cancelled' => 'status-cancelled',
                                        ];
                                        $statusClass = $statusColors[$item->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </span>
                            </div>

                            <div class="order-card-row">
                                <span class="order-card-label">Payment:</span>
                                <span class="order-card-value">
                                    @php
                                        $paymentColors = [
                                            'paid' => 'status-delivered',
                                            'pending' => 'status-pending',
                                            'failed' => 'status-cancelled',
                                        ];
                                        $paymentClass =
                                            $paymentColors[$item->payment_status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="status-badge {{ $paymentClass }}">
                                        {{ ucfirst($item->payment_status) }}
                                    </span>
                                </span>
                            </div>

                            <div class="order-card-row">
                                <span class="order-card-label">Total:</span>
                                <span class="order-card-value font-medium">
                                    ${{ number_format($item->total, 2) }}
                                </span>
                            </div>

                            @if ($item->shipment)
                                <div class="order-card-row">
                                    <span class="order-card-label">Courier:</span>
                                    <span class="order-card-value">
                                        {{ ucfirst($item->shipment->courierService->courier ?? '') }}
                                    </span>
                                </div>

                                <div class="order-card-row">
                                    <span class="order-card-label">Shipment:</span>
                                    <span class="order-card-value">
                                        <span class="status-badge {{ $item->shipment->status_badge }}">
                                            {{ \App\Models\Shipment::getStatuses()[$item->shipment->status] ?? '' }}
                                        </span>
                                    </span>
                                </div>
                            @endif

                            <div class="order-card-row">
                                <span class="order-card-label">Actions:</span>
                                <div class="action-buttons">
                                    @if (!$item->shipment && $item->status !== 'cancelled')
                                        <a href="{{ route('admin.shipments.create', ['order_id' => $item->id]) }}"
                                            class="action-btn action-btn-ship" title="Ship">
                                            <i class="fas fa-shipping-fast"></i>
                                        </a>
                                    @endif

                                    @if ($item->shipment && $item->shipment->tracking_number)
                                        <a href="{{ route('admin.shipments.show', $item->shipment->id) }}"
                                            class="action-btn action-btn-track" title="Track">
                                            <i class="fas fa-search-location"></i>
                                        </a>
                                    @endif

                                    @if ($item->status === 'cancelled' || $item->status === 'pending')
                                        <form action="{{ route('admin.orders.destroy', $item->id) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Delete order?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn action-btn-delete" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-shopping-cart text-4xl mb-4 text-gray-300"></i>
                        <p class="text-lg mb-2">No orders found</p>
                        <p class="text-sm">Orders will appear here once customers start placing them</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($orders->hasPages())
                <div class="mt-6">
                    <x-pagging :paginator="$orders" />
                </div>
            @endif
        </div>
    </div>
@endsection
