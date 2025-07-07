@extends('layouts.guest')

@section('content')
    @include('components.user-nav')

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-800">{{ __('My Profile') }}</h1>
                    <div class="space-x-4">
                        <a href="{{ route('user.profile.edit') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            {{ __('Edit Profile') }}
                        </a>
                        <a href="{{ route('user.profile.change-password') }}"
                            class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                            {{ __('Change Password') }}
                        </a>
                    </div>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Profile Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Personal Information -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Personal Information</h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                <div class="mt-1 text-gray-900 bg-gray-50 p-3 rounded-md">{{ $user->name }}</div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email Address</label>
                                <div class="mt-1 text-gray-900 bg-gray-50 p-3 rounded-md">{{ $user->email }}</div>
                            </div>

                            @if ($user->mobile)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Mobile Number</label>
                                    <div class="mt-1 text-gray-900 bg-gray-50 p-3 rounded-md">{{ $user->mobile }}</div>
                                </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Member Since</label>
                                <div class="mt-1 text-gray-900 bg-gray-50 p-3 rounded-md">
                                    {{ $user->created_at->format('F d, Y') }}</div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email Verified</label>
                                <div class="mt-1 bg-gray-50 p-3 rounded-md">
                                    @if ($user->email_verified_at)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Verified
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Not Verified
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Account Information</h2>

                        <div class="space-y-4">
                            @if ($user->level_id && $user->userLevel)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">User Level</label>
                                    <div class="mt-1 text-gray-900 bg-gray-50 p-3 rounded-md">{{ $user->userLevel->name }}
                                    </div>
                                </div>
                            @endif

                            @if ($user->ref_code)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Referral Code</label>
                                    <div class="mt-1 text-gray-900 bg-gray-50 p-3 rounded-md font-mono">
                                        {{ $user->ref_code }}</div>
                                </div>
                            @endif

                            @if ($user->referrer)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Referred By</label>
                                    <div class="mt-1 text-gray-900 bg-gray-50 p-3 rounded-md">{{ $user->referrer }}</div>
                                </div>
                            @endif

                            @if ($user->extra_discount)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Extra Discount</label>
                                    <div class="mt-1 text-gray-900 bg-gray-50 p-3 rounded-md">{{ $user->extra_discount }}%
                                    </div>
                                </div>
                            @endif

                            <!-- User Roles -->
                            @if ($user->roles->count() > 0)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Roles</label>
                                    <div class="mt-1 bg-gray-50 p-3 rounded-md">
                                        @foreach ($user->roles as $role)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                                                {{ ucfirst($role->name) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Account Statistics -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Account Statistics</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600">{{ $stats['total_orders'] }}</div>
                            <div class="text-sm text-gray-600">Total Orders</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600">RS.
                                {{ number_format($stats['total_spent'], 2) }}</div>
                            <div class="text-sm text-gray-600">Total Spent</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-yellow-600">{{ $stats['total_reviews'] }}</div>
                            <div class="text-sm text-gray-600">Product Reviews</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600">{{ $stats['days_member'] }}</div>
                            <div class="text-sm text-gray-600">Days as Member</div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Quick Actions</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('user.orders.index') }}"
                            class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <svg class="w-8 h-8 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                            </svg>
                            <div>
                                <div class="font-medium text-gray-900">View Orders</div>
                                <div class="text-sm text-gray-600">Track your purchases</div>
                            </div>
                        </a>

                        <a href="{{ route('user.reviews.index') }}"
                            class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                            <svg class="w-8 h-8 text-yellow-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <div>
                                <div class="font-medium text-gray-900">Manage Reviews</div>
                                <div class="text-sm text-gray-600">Rate your purchases</div>
                            </div>
                        </a>

                        <a href="{{ route('user.dashboard') }}"
                            class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <svg class="w-8 h-8 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                            </svg>
                            <div>
                                <div class="font-medium text-gray-900">Dashboard</div>
                                <div class="text-sm text-gray-600">Overview of your account</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
