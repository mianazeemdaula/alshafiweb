@extends('layouts.guest')
@section('content')
    <div class="p-4 bg-white dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl sm:text-3xl font-bold text-center mb-6 text-blue-800 dark:text-blue-300">Customer Reviews
            </h1>
            <p class="text-center text-gray-600 dark:text-gray-400 mb-8">See what our customers are saying about Al Shaafi
                products and service.</p>

            @if ($reviews->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach ($reviews as $review)
                        <div
                            class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow p-5 border border-gray-200 dark:border-gray-700 flex flex-col">
                            <div class="flex items-center mb-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white font-bold text-lg mr-3">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $review->user->name }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $review->created_at->format('M d, Y') }}</div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <span
                                    class="font-medium text-blue-700 dark:text-blue-300">{{ $review->product->name ?? 'Product' }}</span>
                            </div>
                            <div class="flex items-center mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star text-yellow-400"></i>
                                @endfor
                                <span class="ml-2 text-xs text-gray-500">({{ $review->rating }}/5)</span>
                            </div>
                            <div class="text-gray-700 dark:text-gray-200 text-sm mb-2">{{ $review->comment }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8">{{ $reviews->links() }}</div>
            @else
                <div class="text-center py-12">
                    <div class="text-gray-400 text-4xl mb-4">📝</div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">No Reviews Yet</h3>
                    <p class="text-gray-500 dark:text-gray-400">Be the first to leave a review for our products!</p>
                </div>
            @endif
        </div>
    </div>
@endsection
