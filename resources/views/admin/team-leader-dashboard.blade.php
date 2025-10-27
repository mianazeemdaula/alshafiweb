@extends('layouts.web')

@section('content')
    <!-- Team Leader Dashboard -->
    <div class="p-4 lg:p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">

        <!-- Header -->
        <div class="mb-6">
            <div class="bg-gradient-to-r from-purple-600 via-indigo-600 to-blue-600 rounded-2xl p-6 shadow-xl">
                <div class="flex items-center justify-between">
                    <div class="text-white">
                        <h1 class="text-3xl font-bold mb-2">👥 Team Leader Dashboard</h1>
                        <p class="text-white/90">Welcome back, {{ auth()->user()->name }}!</p>
                        <p class="text-white/80 text-sm mt-1">Manage your team and monitor performance</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                            <i class="fa fa-users-cog text-4xl text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Overview -->
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="fa fa-chart-line text-purple-600"></i>
                Team Overview
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Team Members -->
                <div
                    class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-5 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <i class="fa fa-users text-2xl text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-white/90 text-sm font-medium mb-1">Team Members</h3>
                    <p class="text-3xl font-bold text-white">{{ $stats['team_members'] }}</p>
                </div>

                <!-- Team Orders -->
                <div
                    class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-5 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <i class="fa fa-shopping-cart text-2xl text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-white/90 text-sm font-medium mb-1">Team Orders</h3>
                    <p class="text-3xl font-bold text-white">{{ $teamStats['total_team_orders'] }}</p>
                </div>

                <!-- Team Bonuses -->
                <div
                    class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-5 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <i class="fa fa-dollar-sign text-2xl text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-white/90 text-sm font-medium mb-1">Team Bonuses</h3>
                    <p class="text-3xl font-bold text-white">PKR
                        {{ number_format($teamStats['total_team_bonuses'] / 100, 2) }}</p>
                </div>

                <!-- Total Visible Orders -->
                <div
                    class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl p-5 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <i class="fa fa-eye text-2xl text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-white/90 text-sm font-medium mb-1">Total Visible</h3>
                    <p class="text-3xl font-bold text-white">{{ $stats['total_orders'] }}</p>
                </div>
            </div>
        </div>

        <!-- Order Types Breakdown -->
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="fa fa-chart-bar text-blue-600"></i>
                Order Types
            </h2>

            <div class="grid grid-cols-2 gap-4">
                <!-- Website Orders -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-lg">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center">
                            <i class="fa fa-globe text-2xl text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-700 dark:text-gray-300 text-sm font-medium">Website Orders</h3>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['website_orders'] }}</p>
                            <p class="text-xs text-gray-500">Available to all team leaders</p>
                        </div>
                    </div>
                </div>

                <!-- Manual Orders (Team) -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-lg">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                            <i class="fa fa-hand-pointer text-2xl text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-700 dark:text-gray-300 text-sm font-medium">Manual Orders (Team)</h3>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['manual_orders'] }}</p>
                            <p class="text-xs text-gray-500">Created by your team members</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Status Distribution -->
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="fa fa-tasks text-green-600"></i>
                Order Status Distribution
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <!-- Pending -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow text-center">
                    <div
                        class="w-12 h-12 mx-auto bg-gradient-to-br from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mb-2">
                        <i class="fa fa-clock text-xl text-white"></i>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Pending</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['pending_orders'] }}</p>
                </div>

                <!-- Processing -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow text-center">
                    <div
                        class="w-12 h-12 mx-auto bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center mb-2">
                        <i class="fa fa-cog text-xl text-white"></i>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Processing</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['processing_orders'] }}</p>
                </div>

                <!-- Shipped -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow text-center">
                    <div
                        class="w-12 h-12 mx-auto bg-gradient-to-br from-cyan-500 to-blue-500 rounded-full flex items-center justify-center mb-2">
                        <i class="fa fa-shipping-fast text-xl text-white"></i>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Shipped</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['shipped_orders'] }}</p>
                </div>

                <!-- Delivered -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow text-center">
                    <div
                        class="w-12 h-12 mx-auto bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center mb-2">
                        <i class="fa fa-check-circle text-xl text-white"></i>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Delivered</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['delivered_orders'] }}</p>
                </div>

                <!-- Cancelled -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow text-center">
                    <div
                        class="w-12 h-12 mx-auto bg-gradient-to-br from-red-500 to-pink-500 rounded-full flex items-center justify-center mb-2">
                        <i class="fa fa-times-circle text-xl text-white"></i>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Cancelled</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['cancelled_orders'] }}</p>
                </div>
            </div>
        </div>

        <!-- Team Members Performance -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="fa fa-users text-purple-600"></i>
                Team Members Performance
            </h3>

            @if ($teamMembers->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($teamMembers as $member)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-lg">{{ substr($member->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $member->name }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ $member->email }}</p>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        <i class="fa fa-shopping-cart text-blue-600 mr-1"></i>Orders
                                    </span>
                                    <span
                                        class="font-bold text-gray-900 dark:text-white">{{ $member->manualOrders->count() }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        <i class="fa fa-dollar-sign text-green-600 mr-1"></i>Bonuses
                                    </span>
                                    <span class="font-bold text-green-600">PKR
                                        {{ number_format($member->bonuses->sum('bonus_amount') / 100, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        <i class="fa fa-check-circle text-emerald-600 mr-1"></i>Delivered
                                    </span>
                                    <span
                                        class="font-bold text-gray-900 dark:text-white">{{ $member->manualOrders->where('status', 'delivered')->count() }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fa fa-users text-4xl mb-3"></i>
                    <p>No team members assigned yet</p>
                    <p class="text-sm mt-2">Contact admin to assign order takers to your team</p>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="fa fa-bolt text-yellow-600"></i>
                Quick Actions
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <a href="{{ route('admin.orders.index') }}"
                    class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900 dark:to-purple-900 rounded-lg hover:shadow-md transition-all group">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fa fa-list text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">View All Orders</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Manage all visible orders</p>
                        </div>
                    </div>
                    <i class="fa fa-chevron-right text-gray-400 group-hover:translate-x-1 transition-transform"></i>
                </a>

                <a href="{{ route('admin.orders.index', ['order_source' => 'manual']) }}"
                    class="flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900 dark:to-pink-900 rounded-lg hover:shadow-md transition-all group">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fa fa-hand-pointer text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">Team Manual Orders</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">{{ $stats['manual_orders'] }} orders</p>
                        </div>
                    </div>
                    <i class="fa fa-chevron-right text-gray-400 group-hover:translate-x-1 transition-transform"></i>
                </a>

                <a href="{{ route('admin.orders.index', ['order_source' => 'website']) }}"
                    class="flex items-center justify-between p-4 bg-gradient-to-r from-cyan-50 to-blue-50 dark:from-cyan-900 dark:to-blue-900 rounded-lg hover:shadow-md transition-all group">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-cyan-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fa fa-globe text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">Website Orders</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">{{ $stats['website_orders'] }} orders</p>
                        </div>
                    </div>
                    <i class="fa fa-chevron-right text-gray-400 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

    </div>
@endsection
