@extends('layouts.web')

@section('content')
    <div class="p-4">
        <h2 class="text-2xl font-semibold mb-4">Dashboard Overview</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white shadow-md rounded-lg p-4">
                <h3 class="text-lg font-medium">Total Products</h3>
                <p class="text-2xl font-bold">{{ $stats['products'] }}</p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-4">
                <h3 class="text-lg font-medium">Total Categories</h3>
                <p class="text-2xl font-bold">{{ $stats['categories'] }}</p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-4">
                <h3 class="text-lg font-medium">Total Orders</h3>
                <p class="text-2xl font-bold">{{ $stats['orders'] }}</p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-4">
                <h3 class="text-lg font-medium">Total Users</h3>
                <p class="text-2xl font-bold">{{ $stats['users'] }}</p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-4">
                <h3 class="text-lg font-medium">Revenue</h3>
                <p class="text-2xl font-bold">RS. {{ $stats['revenue'] }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 my-4 shadow-sm">
        <div class="bg-white p-4 rounded-xl flex flex-col items-start">
            <h1 class="text-base font-bold">Orders</h1>
            <canvas id="chart-1" class=""></canvas>
        </div>
        <div class="bg-white p-4 rounded-xl flex flex-col items-start shadow-sm">
            <h1 class="text-base font-bold">Sales</h1>
            <canvas id="chart-2" class=""></canvas>
        </div>
        <div class=" bg-white p-4 rounded-xl flex flex-col items-start shadow-sm">
            <h1 class="text-base font-bold">Users</h1>
            <canvas id="chart-3" class=""></canvas>
        </div>
    </div>
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
