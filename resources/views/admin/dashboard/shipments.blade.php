@extends('layouts.web')

@section('title', 'Shipment Dashboard')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Shipment Dashboard</h1>
                        <p class="text-sm text-gray-600">Real-time insights and analytics</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center space-x-2 text-sm text-gray-600">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span id="lastUpdated">Updated just now</span>
                        </div>
                        <button onclick="refreshDashboard()"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-sync-alt mr-2"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Shipments -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Shipments</p>
                            <div class="flex items-baseline space-x-2">
                                <p class="text-2xl font-bold text-gray-900" id="totalShipments">
                                    {{ number_format($kpis['total_shipments']['value']) }}</p>
                                @if ($kpis['total_shipments']['growth'] >= 0)
                                    <span class="text-sm font-medium text-green-600">
                                        <i class="fas fa-arrow-up mr-1"></i>{{ $kpis['total_shipments']['growth'] }}%
                                    </span>
                                @else
                                    <span class="text-sm font-medium text-red-600">
                                        <i class="fas fa-arrow-down mr-1"></i>{{ abs($kpis['total_shipments']['growth']) }}%
                                    </span>
                                @endif
                            </div>
                            <div class="flex space-x-4 mt-2 text-xs text-gray-500">
                                <span>Today: {{ $kpis['total_shipments']['today'] }}</span>
                                <span>Week: {{ $kpis['total_shipments']['week'] }}</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-shipping-fast text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Delivered -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Delivered</p>
                            <div class="flex items-baseline space-x-2">
                                <p class="text-2xl font-bold text-gray-900" id="deliveredShipments">
                                    {{ number_format($kpis['delivered']['value']) }}</p>
                                @if ($kpis['delivered']['growth'] >= 0)
                                    <span class="text-sm font-medium text-green-600">
                                        <i class="fas fa-arrow-up mr-1"></i>{{ $kpis['delivered']['growth'] }}%
                                    </span>
                                @else
                                    <span class="text-sm font-medium text-red-600">
                                        <i class="fas fa-arrow-down mr-1"></i>{{ abs($kpis['delivered']['growth']) }}%
                                    </span>
                                @endif
                            </div>
                            <div class="flex space-x-4 mt-2 text-xs text-gray-500">
                                <span>Today: {{ $kpis['delivered']['today'] }}</span>
                                <span>Week: {{ $kpis['delivered']['week'] }}</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Pending -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Pending</p>
                            <div class="flex items-baseline space-x-2">
                                <p class="text-2xl font-bold text-gray-900" id="pendingShipments">
                                    {{ number_format($kpis['pending']['value']) }}</p>
                            </div>
                            <div class="flex space-x-4 mt-2 text-xs text-gray-500">
                                <span>Today: {{ $kpis['pending']['today'] }}</span>
                                <span>Week: {{ $kpis['pending']['week'] }}</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Revenue -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                            <div class="flex items-baseline space-x-2">
                                <p class="text-2xl font-bold text-gray-900" id="totalRevenue">RS
                                    {{ number_format($kpis['revenue']['total'], 2) }}</p>
                                @if ($kpis['revenue']['growth'] >= 0)
                                    <span class="text-sm font-medium text-green-600">
                                        <i class="fas fa-arrow-up mr-1"></i>{{ $kpis['revenue']['growth'] }}%
                                    </span>
                                @else
                                    <span class="text-sm font-medium text-red-600">
                                        <i class="fas fa-arrow-down mr-1"></i>{{ abs($kpis['revenue']['growth']) }}%
                                    </span>
                                @endif
                            </div>
                            <div class="flex space-x-4 mt-2 text-xs text-gray-500">
                                <span>Today: RS {{ number_format($kpis['revenue']['today'], 0) }}</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Delivery Rate</h3>
                    <div class="text-center">
                        <div class="relative w-32 h-32 mx-auto">
                            <canvas id="deliveryRateChart" width="128" height="128"></canvas>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span
                                    class="text-2xl font-bold text-gray-900">{{ $kpis['delivery_rate']['value'] }}%</span>
                            </div>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600">This Week</p>
                                <p class="font-semibold">{{ $kpis['delivery_rate']['week'] }}%</p>
                            </div>
                            <div>
                                <p class="text-gray-600">This Month</p>
                                <p class="font-semibold">{{ $kpis['delivery_rate']['month'] }}%</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Avg Delivery Time</h3>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2">{{ $kpis['avg_delivery_time']['value'] }}</div>
                        <p class="text-gray-600 mb-4">days</p>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600">This Week</p>
                                <p class="font-semibold">{{ $kpis['avg_delivery_time']['week'] }} days</p>
                            </div>
                            <div>
                                <p class="text-gray-600">This Month</p>
                                <p class="font-semibold">{{ $kpis['avg_delivery_time']['month'] }} days</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Distribution</h3>
                    <div class="relative">
                        <canvas id="statusChart" width="200" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Daily Trends -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Daily Shipments Trend</h3>
                        <div class="flex space-x-2">
                            <button class="text-xs px-3 py-1 bg-blue-100 text-blue-600 rounded-full">30 Days</button>
                        </div>
                    </div>
                    <div style="height: 300px;">
                        <canvas id="dailyTrendChart"></canvas>
                    </div>
                </div>

                <!-- Courier Performance -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Courier Performance</h3>
                    <div style="height: 300px;">
                        <canvas id="courierChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Revenue Analytics & City Performance -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Revenue Analytics -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Revenue Analytics</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                            <div>
                                <p class="text-sm text-gray-600">Monthly Revenue</p>
                                <p class="text-xl font-bold text-gray-900">RS
                                    {{ number_format($revenueAnalytics['monthly_revenue'], 2) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">Growth</p>
                                <p
                                    class="text-lg font-semibold {{ $revenueAnalytics['monthly_growth'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $revenueAnalytics['monthly_growth'] }}%
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center p-4 bg-blue-50 rounded-lg">
                                <p class="text-sm text-gray-600">Avg Order Value</p>
                                <p class="text-lg font-bold text-blue-600">RS
                                    {{ number_format($revenueAnalytics['avg_order_value'], 2) }}</p>
                            </div>
                            <div class="text-center p-4 bg-green-50 rounded-lg">
                                <p class="text-sm text-gray-600">COD Collected</p>
                                <p class="text-lg font-bold text-green-600">RS
                                    {{ number_format($revenueAnalytics['total_cod_collected'], 2) }}</p>
                            </div>
                        </div>

                        <div class="text-center p-4 bg-yellow-50 rounded-lg">
                            <p class="text-sm text-gray-600">Pending Collection</p>
                            <p class="text-lg font-bold text-yellow-600">RS
                                {{ number_format($revenueAnalytics['pending_collection'], 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Top Cities -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Top Performing Cities</h3>
                    <div class="space-y-3">
                        @foreach ($cityPerformance->take(8) as $city)
                            <div
                                class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-medium text-gray-900">{{ $city->city_name }}</span>
                                        <span class="text-sm font-medium text-gray-600">{{ $city->total_shipments }}
                                            shipments</span>
                                    </div>
                                    <div class="flex items-center justify-between mt-1">
                                        <div class="w-full bg-gray-200 rounded-full h-2 mr-3">
                                            <div class="bg-blue-600 h-2 rounded-full"
                                                style="width: {{ $city->delivery_rate }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-600">{{ $city->delivery_rate }}%</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Shipments -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Shipments</h3>
                        <a href="{{ route('admin.shipments.index') }}"
                            class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            View All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tracking</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Courier</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($recentShipments as $shipment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $shipment->tracking_number ?? 'Pending' }}</div>
                                                <div class="text-sm text-gray-500">Order #{{ $shipment->order_id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $shipment->delivery_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $shipment->delivery_phone }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ ucfirst($shipment->courierService->courier ?? 'N/A') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        RS {{ number_format($shipment->cod_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'processing' => 'bg-blue-100 text-blue-800',
                                                'shipped' => 'bg-purple-100 text-purple-800',
                                                'delivered' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                                'returned' => 'bg-gray-100 text-gray-800',
                                            ];
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$shipment->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst(str_replace('_', ' ', $shipment->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $shipment->created_at->format('M j, Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Chart configurations and colors
        const chartColors = {
            primary: '#3B82F6',
            success: '#10B981',
            warning: '#F59E0B',
            danger: '#EF4444',
            info: '#06B6D4',
            purple: '#8B5CF6'
        };

        // Status Distribution Chart
        const statusData = @json($statusDistribution);
        const statusChart = new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(statusData),
                datasets: [{
                    data: Object.values(statusData),
                    backgroundColor: [
                        chartColors.success,
                        chartColors.primary,
                        chartColors.warning,
                        chartColors.danger,
                        chartColors.info,
                        chartColors.purple
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });

        // Delivery Rate Chart (Circular Progress)
        const deliveryRate = {{ $kpis['delivery_rate']['value'] }};
        const deliveryRateChart = new Chart(document.getElementById('deliveryRateChart'), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [deliveryRate, 100 - deliveryRate],
                    backgroundColor: [chartColors.success, '#E5E7EB'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Daily Trend Chart
        const dailyData = @json($dailyTrend);
        const dailyTrendChart = new Chart(document.getElementById('dailyTrendChart'), {
            type: 'line',
            data: {
                labels: dailyData.map(d => d.label),
                datasets: [{
                    label: 'Shipments',
                    data: dailyData.map(d => d.shipments),
                    borderColor: chartColors.primary,
                    backgroundColor: chartColors.primary + '20',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Delivered',
                    data: dailyData.map(d => d.delivered),
                    borderColor: chartColors.success,
                    backgroundColor: chartColors.success + '20',
                    tension: 0.4,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Courier Performance Chart
        const courierData = @json($courierPerformance);
        const courierChart = new Chart(document.getElementById('courierChart'), {
            type: 'bar',
            data: {
                labels: courierData.map(c => c.courier.toUpperCase()),
                datasets: [{
                    label: 'Total Shipments',
                    data: courierData.map(c => c.total_shipments),
                    backgroundColor: chartColors.primary,
                    borderRadius: 4
                }, {
                    label: 'Delivered',
                    data: courierData.map(c => c.delivered),
                    backgroundColor: chartColors.success,
                    borderRadius: 4
                }, {
                    label: 'Failed',
                    data: courierData.map(c => c.failed),
                    backgroundColor: chartColors.danger,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Auto-refresh functionality
        function refreshDashboard() {
            const refreshBtn = document.querySelector('button[onclick="refreshDashboard()"]');
            const icon = refreshBtn.querySelector('i');

            icon.classList.add('fa-spin');
            refreshBtn.disabled = true;

            // Simulate refresh (you can implement actual AJAX calls here)
            setTimeout(() => {
                icon.classList.remove('fa-spin');
                refreshBtn.disabled = false;
                updateLastUpdated();
            }, 1000);
        }

        function updateLastUpdated() {
            document.getElementById('lastUpdated').textContent = 'Updated just now';
        }

        // Auto-refresh every 5 minutes
        setInterval(() => {
            // You can implement AJAX calls to update data here
            updateLastUpdated();
        }, 300000);

        // Real-time updates simulation
        setInterval(() => {
            // Update timestamp
            const now = new Date();
            const timeString = now.toLocaleString();
            document.getElementById('lastUpdated').textContent = `Updated at ${timeString}`;
        }, 60000);
    </script>
@endsection
