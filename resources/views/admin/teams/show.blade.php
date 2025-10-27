@extends('layouts.web')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Team Leader: {{ $teamLeader->name }}</h1>
                    <p class="text-gray-600">{{ $teamLeader->email }}</p>
                </div>
                <a href="{{ route('admin.teams.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Teams
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-blue-800 mb-1">Team Members</h3>
                    <p class="text-2xl font-bold text-blue-900">{{ $teamLeader->teamMembers->count() }}</p>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-green-800 mb-1">Total Orders</h3>
                    <p class="text-2xl font-bold text-green-900">
                        {{ $teamLeader->teamMembers->sum(function ($member) {return $member->manualOrders->count();}) }}
                    </p>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-purple-800 mb-1">Total Bonuses</h3>
                    <p class="text-2xl font-bold text-purple-900">
                        PKR
                        {{ number_format($teamLeader->teamMembers->sum(function ($member) {return $member->bonuses->sum('bonus_amount');}) / 100,2) }}
                    </p>
                </div>
            </div>

            <!-- Team Members Details -->
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Team Members</h2>

            @if ($teamLeader->teamMembers->count() > 0)
                <div class="space-y-6">
                    @foreach ($teamLeader->teamMembers as $member)
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $member->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $member->email }}</p>
                                    <div class="flex gap-4 mt-2">
                                        <span class="text-sm text-gray-700">
                                            <i class="fas fa-shopping-cart text-blue-600 mr-1"></i>
                                            <strong>{{ $member->manualOrders->count() }}</strong> orders
                                        </span>
                                        <span class="text-sm text-gray-700">
                                            <i class="fas fa-dollar-sign text-green-600 mr-1"></i>
                                            PKR
                                            <strong>{{ number_format($member->bonuses->sum('bonus_amount') / 100, 2) }}</strong>
                                            in bonuses
                                        </span>
                                    </div>
                                </div>
                                <form action="{{ route('admin.teams.remove-assignment', $member->id) }}" method="POST"
                                    onsubmit="return confirm('Remove {{ $member->name }} from this team?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-800 px-3 py-1 border border-red-300 rounded hover:bg-red-50">
                                        <i class="fas fa-user-minus mr-1"></i>Remove
                                    </button>
                                </form>
                            </div>

                            <!-- Recent Orders -->
                            @if ($member->manualOrders->count() > 0)
                                <div class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Recent Orders</h4>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full text-sm">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    <th class="px-3 py-2 text-left">Order #</th>
                                                    <th class="px-3 py-2 text-left">Customer</th>
                                                    <th class="px-3 py-2 text-left">Status</th>
                                                    <th class="px-3 py-2 text-left">Total</th>
                                                    <th class="px-3 py-2 text-left">Date</th>
                                                    <th class="px-3 py-2 text-left">Bonus</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                @foreach ($member->manualOrders->take(10) as $order)
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="px-3 py-2">
                                                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                                                class="text-blue-600 hover:underline">
                                                                #{{ $order->id }}
                                                            </a>
                                                        </td>
                                                        <td class="px-3 py-2">{{ $order->user->name ?? 'N/A' }}</td>
                                                        <td class="px-3 py-2">
                                                            <span
                                                                class="px-2 py-1 text-xs rounded
                                                                @if ($order->status == 'delivered') bg-green-100 text-green-800
                                                                @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                                                @else bg-blue-100 text-blue-800 @endif">
                                                                {{ ucfirst($order->status) }}
                                                            </span>
                                                        </td>
                                                        <td class="px-3 py-2">PKR {{ number_format($order->total, 2) }}
                                                        </td>
                                                        <td class="px-3 py-2">{{ $order->created_at->format('M d, Y') }}
                                                        </td>
                                                        <td class="px-3 py-2">
                                                            @if ($order->bonus)
                                                                <span class="text-green-600">
                                                                    PKR
                                                                    {{ number_format($order->bonus->bonus_amount / 100, 2) }}
                                                                </span>
                                                            @else
                                                                <span class="text-gray-400">-</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <div class="mt-4 text-sm text-gray-500 italic">
                                    No orders yet
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-users text-4xl mb-3"></i>
                    <p>No team members assigned yet</p>
                    <a href="{{ route('admin.teams.assign') }}"
                        class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-user-plus mr-2"></i>Assign Order Taker
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
