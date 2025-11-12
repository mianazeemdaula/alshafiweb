@extends('layouts.web')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Admin Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400">Welcome back! Here's what's happening with your store today.</p>
        </div>

        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Revenue -->
            <div
                class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-dollar-sign text-2xl"></i>
                    </div>
                    <span class="text-sm font-medium bg-white/20 px-3 py-1 rounded-full">Total</span>
                </div>
                <h3 class="text-sm font-medium opacity-90 mb-1">Total Revenue</h3>
                <p class="text-3xl font-bold">Rs {{ number_format($revenueStats['total_revenue'], 0) }}</p>
                <div class="mt-3 text-sm opacity-75">
                    <span>Today: Rs {{ number_format($revenueStats['today_revenue'], 0) }}</span>
                </div>
            </div>

            <!-- Total Orders -->
            <div
                class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-shopping-cart text-2xl"></i>
                    </div>
                    <span class="text-sm font-medium bg-white/20 px-3 py-1 rounded-full">All Time</span>
                </div>
                <h3 class="text-sm font-medium opacity-90 mb-1">Total Orders</h3>
                <p class="text-3xl font-bold">{{ number_format($stats['total_orders']) }}</p>
                <div class="mt-3 text-sm opacity-75">
                    <span>Today: {{ $stats['today_orders'] }} | This Month: {{ $stats['month_orders'] }}</span>
                </div>
            </div>

            <!-- Total Products -->
            <div
                class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-box text-2xl"></i>
                    </div>
                    <span class="text-sm font-medium bg-white/20 px-3 py-1 rounded-full">Catalog</span>
                </div>
                <h3 class="text-sm font-medium opacity-90 mb-1">Total Products</h3>
                <p class="text-3xl font-bold">{{ number_format($stats['total_products']) }}</p>
                <div class="mt-3 text-sm opacity-75">
                    <span>Active: {{ $stats['active_products'] }} | Categories: {{ $stats['total_categories'] }}</span>
                </div>
            </div>

            <!-- Total Users -->
            <div
                class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <span class="text-sm font-medium bg-white/20 px-3 py-1 rounded-full">Members</span>
                </div>
                <h3 class="text-sm font-medium opacity-90 mb-1">Total Users</h3>
                <p class="text-3xl font-bold">{{ number_format($stats['total_users']) }}</p>
                <div class="mt-3 text-sm opacity-75">
                    <span>Order Takers: {{ $teamStats['order_takers'] }} | Team Leaders:
                        {{ $teamStats['team_leaders'] }}</span>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Sales Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Sales Overview (Last 30 Days)</h2>
                    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <span class="flex items-center"><span class="w-3 h-3 bg-blue-500 rounded-full mr-1"></span>
                            Revenue</span>
                    </div>
                </div>
                <canvas id="salesChart" height="100"></canvas>
            </div>

            <!-- Orders Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Orders Trend (Last 30 Days)</h2>
                    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <span class="flex items-center"><span class="w-3 h-3 bg-green-500 rounded-full mr-1"></span>
                            Orders</span>
                    </div>
                </div>
                <canvas id="ordersChart" height="100"></canvas>
            </div>
        </div>

        <!-- Order Status & Revenue Breakdown -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Order Status Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6">Order Status</h2>
                <canvas id="orderStatusChart" height="200"></canvas>
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 dark:text-gray-400"><i
                                class="fas fa-circle text-yellow-500 text-xs mr-2"></i>Pending</span>
                        <span class="font-bold text-gray-800 dark:text-white">{{ $orderStatus['pending'] }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 dark:text-gray-400"><i
                                class="fas fa-circle text-blue-500 text-xs mr-2"></i>Processing</span>
                        <span class="font-bold text-gray-800 dark:text-white">{{ $orderStatus['processing'] }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 dark:text-gray-400"><i
                                class="fas fa-circle text-purple-500 text-xs mr-2"></i>Shipped</span>
                        <span class="font-bold text-gray-800 dark:text-white">{{ $orderStatus['shipped'] }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 dark:text-gray-400"><i
                                class="fas fa-circle text-green-500 text-xs mr-2"></i>Delivered</span>
                        <span class="font-bold text-gray-800 dark:text-white">{{ $orderStatus['delivered'] }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 dark:text-gray-400"><i
                                class="fas fa-circle text-red-500 text-xs mr-2"></i>Cancelled</span>
                        <span class="font-bold text-gray-800 dark:text-white">{{ $orderStatus['cancelled'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Revenue Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6">Revenue Stats</h2>
                <div class="space-y-4">
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Revenue</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">Rs
                            {{ number_format($revenueStats['total_revenue'], 0) }}</p>
                    </div>
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Today's Revenue</p>
                        <p class="text-2xl font-bold text-green-600">Rs
                            {{ number_format($revenueStats['today_revenue'], 0) }}</p>
                    </div>
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">This Month</p>
                        <p class="text-2xl font-bold text-blue-600">Rs
                            {{ number_format($revenueStats['month_revenue'], 0) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Average Order Value</p>
                        <p class="text-2xl font-bold text-purple-600">Rs
                            {{ number_format($revenueStats['average_order_value'], 0) }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6">Quick Stats</h2>
                <div class="space-y-4">
                    <!-- Shipments -->
                    <div class="flex items-center justify-between p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Pending Shipments</p>
                            <p class="text-xl font-bold text-gray-800 dark:text-white">
                                {{ $shipmentStats['pending_shipments'] }}</p>
                        </div>
                        <i class="fas fa-shipping-fast text-3xl text-blue-500"></i>
                    </div>

                    <!-- Active Offers -->
                    <div class="flex items-center justify-between p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Active Offers</p>
                            <p class="text-xl font-bold text-gray-800 dark:text-white">{{ $offerStats['active_offers'] }}
                            </p>
                        </div>
                        <i class="fas fa-tags text-3xl text-orange-500"></i>
                    </div>

                    <!-- Team Bonuses -->
                    <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Bonuses Paid</p>
                            <p class="text-xl font-bold text-gray-800 dark:text-white">Rs
                                {{ number_format($teamStats['total_bonuses_paid'], 0) }}</p>
                        </div>
                        <i class="fas fa-gift text-3xl text-green-500"></i>
                    </div>

                    <!-- Pending Bonuses -->
                    <div class="flex items-center justify-between p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Pending Bonuses</p>
                            <p class="text-xl font-bold text-gray-800 dark:text-white">Rs
                                {{ number_format($teamStats['pending_bonuses'], 0) }}</p>
                        </div>
                        <i class="fas fa-clock text-3xl text-yellow-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Products & Recent Orders -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Top Products -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6">Top 5 Products</h2>
                <div class="space-y-4">
                    @forelse($topProducts as $product)
                        <div
                            class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold">
                                    {{ substr($product->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-white">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Sold:
                                        {{ $product->total_sold ?? 0 }} units</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-green-600">Rs
                                    {{ number_format($product->total_revenue ?? 0, 0) }}</p>
                                <p class="text-xs text-gray-500">Revenue</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">No products sold yet</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6">Recent Orders</h2>
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @forelse($recentOrders as $order)
                        <div
                            class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:shadow-md transition-shadow">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800 dark:text-white text-sm">Order #{{ $order->id }}
                                </p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $order->user->name ?? 'Guest' }}
                                </p>
                                <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-800 dark:text-white">Rs
                                    {{ number_format($order->total, 0) }}</p>
                                <span
                                    class="text-xs px-2 py-1 rounded-full
                            @if ($order->status === 'delivered') bg-green-100 text-green-800
                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                            @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">No orders yet</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Order Source Distribution -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6">Order Sources</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div
                    class="flex items-center justify-between p-6 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl text-white">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Website Orders</p>
                        <p class="text-4xl font-bold">{{ number_format($orderSource['website']) }}</p>
                        <p class="text-sm opacity-75 mt-2">
                            {{ $stats['total_orders'] > 0 ? round(($orderSource['website'] / $stats['total_orders']) * 100, 1) : 0 }}%
                            of total</p>
                    </div>
                    <i class="fas fa-globe text-5xl opacity-20"></i>
                </div>
                <div
                    class="flex items-center justify-between p-6 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl text-white">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Manual Orders</p>
                        <p class="text-4xl font-bold">{{ number_format($orderSource['manual']) }}</p>
                        <p class="text-sm opacity-75 mt-2">
                            {{ $stats['total_orders'] > 0 ? round(($orderSource['manual'] / $stats['total_orders']) * 100, 1) : 0 }}%
                            of total</p>
                    </div>
                    <i class="fas fa-phone text-5xl opacity-20"></i>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="module">
        // Sales Chart (Last 30 Days)
        const salesCtx = document.getElementById('salesChart');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Revenue (Rs)',
                    data: {!! json_encode($salesChartData) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rs ' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rs ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Orders Chart (Last 30 Days)
        const ordersCtx = document.getElementById('ordersChart');
        new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Orders',
                    data: {!! json_encode($ordersChartData) !!},
                    backgroundColor: 'rgba(34, 197, 94, 0.8)',
                    borderColor: 'rgb(34, 197, 94)',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Order Status Pie Chart
        const statusCtx = document.getElementById('orderStatusChart');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'],
                datasets: [{
                    data: [
                        {{ $orderStatus['pending'] }},
                        {{ $orderStatus['processing'] }},
                        {{ $orderStatus['shipped'] }},
                        {{ $orderStatus['delivered'] }},
                        {{ $orderStatus['cancelled'] }}
                    ],
                    backgroundColor: [
                        'rgba(234, 179, 8, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(168, 85, 247, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endsection

@section('js')
    <script type="module">
        const ctx1 = document.getElementById('chart-1');
        const ctx2 = document.getElementById('chart-2');
        const ctx3 = document.getElementById('chart-3');
        new Chart(ctx1, {
            type: 'line',
            responsive: true,
            data: {
                labels: ['16', '17', '18', '19', '20', '21'],
                datasets: [{
                    label: 'Sales',
                    data: [12, 19, 3, 5, 15, 3],
                    tension: 0.4,
                    borderColor: '#22c55e',
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                }
            },
        });
        new Chart(ctx2, {
            type: 'bar',
            responsive: true,
            data: {
                labels: ['16', '17', '18', '19', '20', '21'],
                datasets: [{
                    label: 'Sales',
                    data: [12, 19, 3, 5, 15, 3],
                    barThickness: 20,
                    backgroundColor: '#22c55e',
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                }
            },
        });
        new Chart(ctx3, {
            type: 'line',
            responsive: true,
            data: {
                labels: ['Dropshipper', 'Disptachers', 'Packker', 'Admin', ],
                datasets: [{
                    label: '',
                    data: [25, 15, 18, 6],
                    backgroundColor: 'rgb(234, 50, 0)',
                    borderColor: '#22c55e',
                    tension: 0.4,
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                },
            },
        });
    </script>
@endsection
