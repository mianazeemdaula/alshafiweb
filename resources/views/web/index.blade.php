@extends('layouts.guest')
@section('content')
    <div class="p-4">
        <div class="grid lg:grid-cols-3 grid-rows-2 grid-cols-2 gap-4">
            <div class="bg-gray-500 h-[500px] col-span-2 lg:row-span-2 rounded-lg"></div>
            <div class="bg-red-300 rounded-lg">
            </div>
            <div class="bg-blue-300 rounded-lg">
            </div>
        </div>
    </div>

    <div class="p-4 bg-slate-100">
        <div class="mb-2 flex items-center justify-between">
            <h1 class="text-xl font-light">Our Products</h1>
            <a href="#" class="text-base font-light">View All</a>
        </div>
        <div class="grid grid-cols-5 gap-4 ">
            @foreach (App\Models\Product::take(10)->get() as $item)
                <x-product-card1 :product="$item" />
            @endforeach
        </div>
    </div>

    <div class="mt-3 p-4">
        <div class="grid lg:grid-cols-3 gap-4">
            <div class="bg-orange-200 rounded-lg">
                <div class="flex items-center justify-center h-48">
                    AD 2
                </div>
            </div>
            <div class="bg-blue-200 rounded-lg">
                <div class="flex items-center justify-center h-48">
                    AD 2
                </div>
            </div>
            <div class="bg-green-300 rounded-lg">
                <div class="flex items-center justify-center h-48">
                    AD 2
                </div>
            </div>
        </div>
    </div>

    {{-- reviews section --}}
    <div class="p-4 bg-slate-100">
        <div class="grid grid-cols-5 gap-4">
            @foreach (range(1, 5) as $item)
                <div class="bg-white p-4 rounded-lg">
                    <div class="">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gray-200 rounded-full"></div>
                            <div class="ml-2">
                                <div class="text-sm font-light">User Name</div>
                                <div class="text-xs font-light">{{ now()->format('d-m-Y') }}</div>
                            </div>
                        </div>
                        <div class="flex items-center text-gray-600 text-sm my-2">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis animi consequatur itaque
                            hic fugit obcaecati nisi, maxime eveniet ut corporis fugiat quidem sapiente sequi eligendi
                            quis numquam dicta placeat id!
                        </div>
                        <div class="text-xs">
                            @php
                                echo str_repeat('⭐', 5);
                            @endphp
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
