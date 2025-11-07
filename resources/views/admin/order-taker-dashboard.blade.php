@extends('layouts.web')

@section('content')
    <!-- Modern Order Taker Dashboard -->
    <div class="p-4 lg:p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">

        <!-- Header -->
        <div class="mb-6">
            <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 rounded-2xl p-6 shadow-xl">
                <div class="flex items-center justify-between">
                    <div class="text-white">
                        <h1 class="text-3xl font-bold mb-2">📦 Order Management Dashboard</h1>
                        <p class="text-white/90">Welcome back, {{ auth()->user()->name }}!</p>
                        <p class="text-white/80 text-sm mt-1">Track and manage all orders from here</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                            <i class="fa fa-clipboard-list text-4xl text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Statistics Grid -->
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="fa fa-chart-bar text-blue-600"></i>
                My Manual Orders Statistics
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <!-- Total Orders -->
                <div
                    class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-5 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <i class="fa fa-shopping-cart text-2xl text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-white/90 text-sm font-medium mb-1">My Orders</h3>
                    <p class="text-3xl font-bold text-white">{{ $stats['total_orders'] }}</p>
                </div>

                <!-- Pending Orders -->
                <div
                    class="bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl p-5 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <i class="fa fa-clock text-2xl text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-white/90 text-sm font-medium mb-1">Pending</h3>
                    <p class="text-3xl font-bold text-white">{{ $stats['pending_orders'] }}</p>
                </div>

                <!-- Processing Orders -->
                <div
                    class="bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl p-5 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <i class="fa fa-cog fa-spin text-2xl text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-white/90 text-sm font-medium mb-1">Processing</h3>
                    <p class="text-3xl font-bold text-white">{{ $stats['processing_orders'] }}</p>
                </div>

                <!-- Shipped Orders -->
                <div
                    class="bg-gradient-to-br from-cyan-500 to-blue-500 rounded-xl p-5 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <i class="fa fa-shipping-fast text-2xl text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-white/90 text-sm font-medium mb-1">Shipped</h3>
                    <p class="text-3xl font-bold text-white">{{ $stats['shipped_orders'] }}</p>
                </div>

                <!-- Delivered Orders -->
                <div
                    class="bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl p-5 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <i class="fa fa-check-circle text-2xl text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-white/90 text-sm font-medium mb-1">Delivered</h3>
                    <p class="text-3xl font-bold text-white">{{ $stats['delivered_orders'] }}</p>
                </div>

                <!-- Cancelled Orders -->
                <div
                    class="bg-gradient-to-br from-red-500 to-pink-500 rounded-xl p-5 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <i class="fa fa-times-circle text-2xl text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-white/90 text-sm font-medium mb-1">Cancelled</h3>
                    <p class="text-3xl font-bold text-white">{{ $stats['cancelled_orders'] }}</p>
                </div>
            </div>
        </div>

        <!-- Bonus Summary Section -->
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="fa fa-dollar-sign text-green-600"></i>
                My Bonus Summary
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Total Bonuses -->
                <div
                    class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-5 shadow-lg hover:shadow-xl transition-all">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <i class="fa fa-coins text-2xl text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-white/90 text-sm font-medium mb-1">Total Bonuses</h3>
                    <p class="text-3xl font-bold text-white">PKR {{ number_format($bonusStats['total_bonuses'], 2) }}
                    </p>
                    <p class="text-white/70 text-xs mt-1">{{ $bonusStats['bonus_count'] }} bonuses earned</p>
                </div>

                <!-- Pending Bonuses -->
                <div
                    class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-5 shadow-lg hover:shadow-xl transition-all">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <i class="fa fa-clock text-2xl text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-white/90 text-sm font-medium mb-1">Pending</h3>
                    <p class="text-3xl font-bold text-white">PKR
                        {{ number_format($bonusStats['pending_bonuses'], 2) }}</p>
                    <p class="text-white/70 text-xs mt-1">Awaiting payment</p>
                </div>

                <!-- Paid Bonuses -->
                <div
                    class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-5 shadow-lg hover:shadow-xl transition-all">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <i class="fa fa-check-circle text-2xl text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-white/90 text-sm font-medium mb-1">Paid</h3>
                    <p class="text-3xl font-bold text-white">PKR {{ number_format($bonusStats['paid_bonuses'], 2) }}
                    </p>
                    <p class="text-white/70 text-xs mt-1">Successfully received</p>
                </div>

                <!-- Bonus Rate -->
                {{-- <div
                    class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl p-5 shadow-lg hover:shadow-xl transition-all">
                    <div class="flex items-center justify-between mb-2">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <i class="fa fa-percentage text-2xl text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-white/90 text-sm font-medium mb-1">Bonus Rate</h3>
                    <p class="text-3xl font-bold text-white">5%</p>
                    <p class="text-white/70 text-xs mt-1">On delivered orders</p>
                </div> --}}
            </div>
        </div>

        <!-- Order Status Breakdown -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Order Flow Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <div
                        class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fa fa-chart-pie text-white text-sm"></i>
                    </div>
                    Order Status Distribution
                </h3>
                <canvas id="orderStatusChart" class="w-full" style="max-height: 300px;"></canvas>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <div
                        class="w-8 h-8 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg flex items-center justify-center">
                        <i class="fa fa-bolt text-white text-sm"></i>
                    </div>
                    Quick Actions
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.orders.index') }}"
                        class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900 dark:to-purple-900 rounded-lg hover:shadow-md transition-all group">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fa fa-list text-white"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">View All Orders</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Manage all orders</p>
                            </div>
                        </div>
                        <i class="fa fa-chevron-right text-gray-400 group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}"
                        class="flex items-center justify-between p-4 bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900 dark:to-orange-900 rounded-lg hover:shadow-md transition-all group">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-yellow-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fa fa-clock text-white"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Pending Orders</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $stats['pending_orders'] }} orders
                                    waiting</p>
                            </div>
                        </div>
                        <i class="fa fa-chevron-right text-gray-400 group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <a href="{{ route('admin.shipments.index') }}"
                        class="flex items-center justify-between p-4 bg-gradient-to-r from-cyan-50 to-blue-50 dark:from-cyan-900 dark:to-blue-900 rounded-lg hover:shadow-md transition-all group">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-cyan-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fa fa-truck text-white"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">View Shipments</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Track shipments</p>
                            </div>
                        </div>
                        <i class="fa fa-chevron-right text-gray-400 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Order Progress Tracker -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                <div
                    class="w-8 h-8 bg-gradient-to-r from-green-600 to-emerald-600 rounded-lg flex items-center justify-center">
                    <i class="fa fa-tasks text-white text-sm"></i>
                </div>
                Order Processing Flow
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <!-- Pending -->
                <div class="text-center">
                    <div class="relative">
                        <div
                            class="w-16 h-16 mx-auto bg-gradient-to-br from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mb-3 shadow-lg">
                            <i class="fa fa-hourglass-start text-2xl text-white"></i>
                        </div>
                        @php
                            $pendingPercent =
                                $stats['total_orders'] > 0
                                    ? round(($stats['pending_orders'] / $stats['total_orders']) * 100)
                                    : 0;
                        @endphp
                        <span
                            class="absolute -top-1 -right-1 bg-white dark:bg-gray-900 text-yellow-600 text-xs font-bold px-2 py-1 rounded-full shadow">{{ $pendingPercent }}%</span>
                    </div>
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Pending</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['pending_orders'] }}</p>
                </div>

                <!-- Processing -->
                <div class="text-center">
                    <div class="relative">
                        <div
                            class="w-16 h-16 mx-auto bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center mb-3 shadow-lg">
                            <i class="fa fa-cogs text-2xl text-white"></i>
                        </div>
                        @php
                            $processingPercent =
                                $stats['total_orders'] > 0
                                    ? round(($stats['processing_orders'] / $stats['total_orders']) * 100)
                                    : 0;
                        @endphp
                        <span
                            class="absolute -top-1 -right-1 bg-white dark:bg-gray-900 text-purple-600 text-xs font-bold px-2 py-1 rounded-full shadow">{{ $processingPercent }}%</span>
                    </div>
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Processing</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['processing_orders'] }}</p>
                </div>

                <!-- Shipped -->
                <div class="text-center">
                    <div class="relative">
                        <div
                            class="w-16 h-16 mx-auto bg-gradient-to-br from-cyan-500 to-blue-500 rounded-full flex items-center justify-center mb-3 shadow-lg">
                            <i class="fa fa-shipping-fast text-2xl text-white"></i>
                        </div>
                        @php
                            $shippedPercent =
                                $stats['total_orders'] > 0
                                    ? round(($stats['shipped_orders'] / $stats['total_orders']) * 100)
                                    : 0;
                        @endphp
                        <span
                            class="absolute -top-1 -right-1 bg-white dark:bg-gray-900 text-cyan-600 text-xs font-bold px-2 py-1 rounded-full shadow">{{ $shippedPercent }}%</span>
                    </div>
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Shipped</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['shipped_orders'] }}</p>
                </div>

                <!-- Delivered -->
                <div class="text-center">
                    <div class="relative">
                        <div
                            class="w-16 h-16 mx-auto bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center mb-3 shadow-lg">
                            <i class="fa fa-check-double text-2xl text-white"></i>
                        </div>
                        @php
                            $deliveredPercent =
                                $stats['total_orders'] > 0
                                    ? round(($stats['delivered_orders'] / $stats['total_orders']) * 100)
                                    : 0;
                        @endphp
                        <span
                            class="absolute -top-1 -right-1 bg-white dark:bg-gray-900 text-green-600 text-xs font-bold px-2 py-1 rounded-full shadow">{{ $deliveredPercent }}%</span>
                    </div>
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Delivered</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['delivered_orders'] }}</p>
                </div>

                <!-- Cancelled -->
                <div class="text-center">
                    <div class="relative">
                        <div
                            class="w-16 h-16 mx-auto bg-gradient-to-br from-red-500 to-pink-500 rounded-full flex items-center justify-center mb-3 shadow-lg">
                            <i class="fa fa-ban text-2xl text-white"></i>
                        </div>
                        @php
                            $cancelledPercent =
                                $stats['total_orders'] > 0
                                    ? round(($stats['cancelled_orders'] / $stats['total_orders']) * 100)
                                    : 0;
                        @endphp
                        <span
                            class="absolute -top-1 -right-1 bg-white dark:bg-gray-900 text-red-600 text-xs font-bold px-2 py-1 rounded-full shadow">{{ $cancelledPercent }}%</span>
                    </div>
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Cancelled</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['cancelled_orders'] }}</p>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script type="module">
        // Order Status Chart
        const ctx = document.getElementById('orderStatusChart');

        const chartData = {
            labels: ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'],
            datasets: [{
                label: 'Orders',
                data: [
                    {{ $stats['pending_orders'] }},
                    {{ $stats['processing_orders'] }},
                    {{ $stats['shipped_orders'] }},
                    {{ $stats['delivered_orders'] }},
                    {{ $stats['cancelled_orders'] }}
                ],
                backgroundColor: [
                    'rgba(251, 191, 36, 0.8)', // Yellow - Pending
                    'rgba(139, 92, 246, 0.8)', // Purple - Processing
                    'rgba(6, 182, 212, 0.8)', // Cyan - Shipped
                    'rgba(34, 197, 94, 0.8)', // Green - Delivered
                    'rgba(239, 68, 68, 0.8)' // Red - Cancelled
                ],
                borderColor: [
                    'rgb(251, 191, 36)',
                    'rgb(139, 92, 246)',
                    'rgb(6, 182, 212)',
                    'rgb(34, 197, 94)',
                    'rgb(239, 68, 68)'
                ],
                borderWidth: 2
            }]
        };

        new Chart(ctx, {
            type: 'doughnut',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.parsed + ' orders';
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                label += ` (${percentage}%)`;
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // Add animation on page load
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.grid > div');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
@endsection
