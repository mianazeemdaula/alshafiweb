@extends('layouts.guest')
@section('title', 'News')
@section('content')
    <div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-blue-700 flex items-center"><i class="fa-solid fa-newspaper mr-2"></i>Latest
            News</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ([
            'Grand Opening Sale!' => 'Enjoy up to 50% off on all products during our grand opening week. Shop now and save big!',
            'New Arrivals: Summer Collection' => 'Check out our latest summer arrivals—fresh styles, vibrant colors, and exclusive deals.',
            'Customer Success Story' => 'Read how our customer Jane transformed her home with our products.',
            'Service Expansion' => 'We now deliver to 10+ new cities! See if your area is included.',
        ] as $title => $desc)
                <div class="p-4 bg-blue-50 rounded-lg shadow hover:shadow-lg transition">
                    <div class="text-xs text-gray-400 mb-1 flex items-center"><i
                            class="fa-solid fa-calendar mr-1"></i>{{ date('Y-m-d') }}</div>
                    <div class="font-semibold text-lg text-blue-800 mb-2">{{ $title }}</div>
                    <div class="text-gray-600 text-sm">{{ $desc }}</div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
