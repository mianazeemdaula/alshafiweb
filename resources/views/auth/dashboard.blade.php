@extends('layouts.web')

@section('content')
<div class="p-4">
    <h2 class="text-2xl font-semibold mb-4">Dashboard Overview</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-medium">Total Products</h3>
            <p class="text-2xl font-bold">120</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-medium">Total Orders</h3>
            <p class="text-2xl font-bold">350</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-medium">Total Users</h3>
            <p class="text-2xl font-bold">85</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-medium">Revenue</h3>
            <p class="text-2xl font-bold">$15,000</p>
        </div>
    </div>
    </div>
@endsection