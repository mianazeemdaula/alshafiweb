@extends('layouts.web')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Bonus Management</h1>
                <a href="{{ route('admin.teams.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-users mr-2"></i>Team Management
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-yellow-800 mb-1">Pending Bonuses</h3>
                    <p class="text-2xl font-bold text-yellow-900">PKR {{ number_format($stats['total_pending'] / 100, 2) }}
                    </p>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-green-800 mb-1">Paid Bonuses</h3>
                    <p class="text-2xl font-bold text-green-900">PKR {{ number_format($stats['total_paid'] / 100, 2) }}</p>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-red-800 mb-1">Cancelled Bonuses</h3>
                    <p class="text-2xl font-bold text-red-900">PKR {{ number_format($stats['total_cancelled'] / 100, 2) }}
                    </p>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Order Taker</label>
                        <select name="order_taker_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Order Takers</option>
                            @foreach ($orderTakers as $orderTaker)
                                <option value="{{ $orderTaker->id }}"
                                    {{ request('order_taker_id') == $orderTaker->id ? 'selected' : '' }}>
                                    {{ $orderTaker->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </div>

                    <div class="flex items-end space-x-2">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                            <i class="fas fa-filter mr-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.bonuses.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                            <i class="fas fa-times mr-1"></i>Clear
                        </a>
                    </div>
                </form>
            </div>

            <!-- Bonuses Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Order Taker</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Order</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Order Amount</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Bonus (5%)</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Date</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($bonuses as $bonus)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $bonus->orderTaker->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $bonus->orderTaker->email }}</div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.orders.show', $bonus->order_id) }}"
                                        class="text-blue-600 hover:underline">
                                        Order #{{ $bonus->order_id }}
                                    </a>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="font-medium text-gray-900">PKR
                                        {{ number_format($bonus->order_amount, 2) }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="font-semibold text-green-600">PKR
                                        {{ number_format($bonus->bonus_amount / 100, 2) }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 text-xs rounded
                                        @if ($bonus->status == 'paid') bg-green-100 text-green-800
                                        @elseif($bonus->status == 'cancelled') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($bonus->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm text-gray-900">{{ $bonus->created_at->format('M d, Y') }}</div>
                                    @if ($bonus->paid_at)
                                        <div class="text-xs text-gray-500">Paid: {{ $bonus->paid_at->format('M d, Y') }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <button
                                        onclick="openStatusModal({{ $bonus->id }}, '{{ $bonus->status }}', '{{ $bonus->notes ?? '' }}')"
                                        class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i> Update
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-3"></i>
                                    <p>No bonuses found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $bonuses->links() }}
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div id="statusModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Update Bonus Status</h3>
            <form id="statusForm" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="bonusStatus" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                    <textarea name="notes" id="bonusNotes" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Add any notes about this bonus..."></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeStatusModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function openStatusModal(bonusId, currentStatus, currentNotes) {
            document.getElementById('statusForm').action = `/admin/bonuses/${bonusId}/status`;
            document.getElementById('bonusStatus').value = currentStatus;
            document.getElementById('bonusNotes').value = currentNotes;
            document.getElementById('statusModal').classList.remove('hidden');
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('statusModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeStatusModal();
            }
        });
    </script>
@endsection
