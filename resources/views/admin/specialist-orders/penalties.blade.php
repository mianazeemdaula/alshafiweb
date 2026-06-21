@extends('layouts.web')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Specialist Penalties</h1>
                    <p class="text-sm text-gray-600 mt-1">Track penalties for non-delivered orders</p>
                </div>
                <a href="{{ route('admin.specialist-orders.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Orders
                </a>
            </div>

            <!-- Total Penalties Card -->
            <div class="bg-red-50 rounded-lg p-6 border border-red-200 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-red-600 font-medium mb-1">Total Penalties Applied</p>
                        <p class="text-3xl font-bold text-red-800">Rs {{ number_format($totalPenalties) }}</p>
                        <p class="text-sm text-red-600 mt-1">{{ $penalties->total() }} penalty records</p>
                    </div>
                    <i class="fas fa-exclamation-triangle text-6xl text-red-300"></i>
                </div>
            </div>

            <!-- Penalties Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Order #</th>
                            @role('admin')
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Specialist</th>
                            @endrole
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Reason</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Amount</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Date</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($penalties as $penalty)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.specialist-orders.show', $penalty->order) }}"
                                        class="text-blue-600 hover:text-blue-800 font-medium">
                                        {{ $penalty->order->number ?? 'N/A' }}
                                    </a>
                                </td>
                                @role('admin')
                                    <td class="px-4 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $penalty->specialist->name ?? 'N/A' }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $penalty->specialist->email ?? 'N/A' }}
                                        </div>
                                    </td>
                                @endrole
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900">{{ $penalty->reason }}</span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-red-600">
                                        Rs {{ number_format($penalty->penalty_amount) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'applied' => 'bg-red-100 text-red-800',
                                            'reversed' => 'bg-green-100 text-green-800',
                                        ];
                                        $statusColor = $statusColors[$penalty->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                        {{ ucfirst($penalty->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $penalty->created_at->format('M d, Y') }}
                                    </div>
                                    @if ($penalty->applied_at)
                                        <div class="text-xs text-gray-500">
                                            Applied: {{ $penalty->applied_at->format('M d, Y') }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <div class="text-sm text-gray-700 max-w-xs truncate" title="{{ $penalty->notes }}">
                                        {{ $penalty->notes ?? '-' }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->hasRole('admin') ? '7' : '6' }}"
                                    class="px-4 py-8 text-center text-gray-500">
                                    <i class="fas fa-check-circle text-4xl mb-2 text-green-500"></i>
                                    <p>No penalties found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $penalties->links() }}
            </div>

            <!-- Info Box -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <i class="fas fa-info-circle text-blue-500 text-xl mr-3 mt-1"></i>
                    <div>
                        <h4 class="font-semibold text-blue-800 mb-1">About Penalties</h4>
                        <p class="text-sm text-blue-700">
                            A penalty of Rs 200 is automatically applied when a specialist order is marked as
                            <span class="font-semibold">returned</span> or <span class="font-semibold">cancelled</span>
                            (non-delivery). If the order status changes to <span class="font-semibold">delivered</span>
                            later, the penalty will be automatically reversed.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
