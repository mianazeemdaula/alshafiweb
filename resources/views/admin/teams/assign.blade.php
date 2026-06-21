@extends('layouts.web')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Assign Order Taker to Team Leader</h1>
                <a href="{{ route('admin.teams.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Teams
                </a>
            </div>

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.teams.store-assignment') }}" method="POST" class="max-w-2xl">
                @csrf

                <!-- Select Order Taker -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-1"></i>Select Order Taker
                    </label>
                    <select name="order_taker_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Choose Order Taker --</option>
                        @foreach ($orderTakers as $orderTaker)
                            <option value="{{ $orderTaker->id }}"
                                {{ request('order_taker') == $orderTaker->id ? 'selected' : '' }}
                                {{ $orderTaker->team_leader_id ? 'disabled' : '' }}>
                                {{ $orderTaker->name }} ({{ $orderTaker->email }})
                                @if ($orderTaker->team_leader_id)
                                    - Already Assigned
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <p class="text-sm text-gray-500 mt-1">
                        <i class="fas fa-info-circle"></i> Only unassigned order takers are available
                    </p>
                </div>

                <!-- Select Team Leader -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-tie mr-1"></i>Assign to Team Leader
                    </label>
                    <select name="team_leader_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Choose Team Leader --</option>
                        @foreach ($teamLeaders as $leader)
                            <option value="{{ $leader->id }}">
                                {{ $leader->name }} ({{ $leader->email }}) - {{ $leader->teamMembers->count() }} members
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Buttons -->
                <div class="flex gap-3">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-check mr-2"></i>Assign to Team
                    </button>
                    <a href="{{ route('admin.teams.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                </div>
            </form>

            <!-- Current Team Structure Preview -->
            @if ($teamLeaders->count() > 0)
                <div class="mt-8 border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Current Team Structure</h3>
                    <div class="space-y-3">
                        @foreach ($teamLeaders as $leader)
                            <div class="bg-gray-50 border border-gray-200 rounded p-3">
                                <p class="font-medium text-gray-800">{{ $leader->name }}</p>
                                <p class="text-sm text-gray-600">
                                    Team Members: {{ $leader->teamMembers->count() }}
                                    @if ($leader->teamMembers->count() > 0)
                                        - {{ $leader->teamMembers->pluck('name')->join(', ') }}
                                    @endif
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
