@extends('layouts.web')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Team Management</h1>
                <a href="{{ route('admin.teams.assign') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-user-plus mr-2"></i>Assign Order Taker
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Team Leaders Section -->
            <div class="space-y-6">
                @forelse ($teamLeaders as $leader)
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">
                                    <i class="fas fa-user-tie text-blue-600 mr-2"></i>{{ $leader->name }}
                                </h3>
                                <p class="text-sm text-gray-600">{{ $leader->email }}</p>
                                <span class="inline-block mt-1 px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">Team
                                    Leader</span>
                            </div>
                            <a href="{{ route('admin.teams.show', $leader->id) }}"
                                class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye mr-1"></i>View Details
                            </a>
                        </div>

                        <!-- Team Members -->
                        @if ($leader->teamMembers->count() > 0)
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Team Members
                                    ({{ $leader->teamMembers->count() }})</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                    @foreach ($leader->teamMembers as $member)
                                        <div
                                            class="bg-white border border-gray-200 rounded p-3 flex justify-between items-center">
                                            <div>
                                                <p class="font-medium text-gray-800">{{ $member->name }}</p>
                                                <p class="text-xs text-gray-600">{{ $member->email }}</p>
                                                <div class="flex gap-2 mt-1">
                                                    <span class="text-xs text-gray-500">
                                                        <i
                                                            class="fas fa-shopping-cart mr-1"></i>{{ $member->manualOrders->count() }}
                                                        orders
                                                    </span>
                                                    <span class="text-xs text-gray-500">
                                                        <i
                                                            class="fas fa-dollar-sign mr-1"></i>{{ $member->bonuses->sum('bonus_amount') / 100 }}
                                                        PKR
                                                    </span>
                                                </div>
                                            </div>
                                            <form action="{{ route('admin.teams.remove-assignment', $member->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Remove this order taker from the team?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="mt-4 text-gray-500 text-sm italic">
                                <i class="fas fa-info-circle mr-1"></i>No team members assigned yet
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-users text-4xl mb-3"></i>
                        <p>No team leaders found. Create users with the "Team Leader" role first.</p>
                    </div>
                @endforelse
            </div>

            <!-- Unassigned Order Takers -->
            @if ($unassignedOrderTakers->count() > 0)
                <div class="mt-8 border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-user-clock text-orange-600 mr-2"></i>Unassigned Order Takers
                        ({{ $unassignedOrderTakers->count() }})
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach ($unassignedOrderTakers as $orderTaker)
                            <div class="bg-orange-50 border border-orange-200 rounded p-3">
                                <p class="font-medium text-gray-800">{{ $orderTaker->name }}</p>
                                <p class="text-xs text-gray-600">{{ $orderTaker->email }}</p>
                                <a href="{{ route('admin.teams.assign') }}?order_taker={{ $orderTaker->id }}"
                                    class="text-xs text-blue-600 hover:text-blue-800 mt-2 inline-block">
                                    <i class="fas fa-link mr-1"></i>Assign to Team
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
