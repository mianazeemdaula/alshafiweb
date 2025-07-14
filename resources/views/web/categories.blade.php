@extends('layouts.guest')
@section('title', 'Categories')
@section('content')
    <div
        class="max-w-5xl mx-auto mt-10 p-8 bg-white dark:bg-gray-900 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-bold mb-8 text-green-700 dark:text-green-400 flex items-center">
            <i class="fa-solid fa-layer-group mr-2"></i>{{ __('categories') }}
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ($categories as $cat)
                <div
                    class="p-6 bg-green-50 dark:bg-green-900 rounded-xl shadow hover:shadow-xl transition flex flex-col items-center border border-green-100 dark:border-green-800">
                    @if ($cat->icon)
                        <i class="{{ $cat->icon }} text-3xl text-green-600 dark:text-green-400 mb-2"></i>
                    @else
                        <i class="fa-solid fa-layer-group text-3xl text-green-600 dark:text-green-400 mb-2"></i>
                    @endif
                    <div class="font-semibold text-base text-green-800 dark:text-green-200 mb-1">{{ $cat->name }}</div>
                    <div class="text-gray-500 dark:text-gray-300 text-xs text-center">{{ $cat->description }}</div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
