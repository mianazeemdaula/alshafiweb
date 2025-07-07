@extends('layouts.guest')

@section('content')
    @include('components.user-nav')

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">{{ __('My Reviews') }}</h1>
                <a href="{{ route('user.dashboard') }}" class="text-blue-600 hover:text-blue-800">
                    ← {{ __('Back to Dashboard') }}
                </a>
            </div>

            <!-- Filter Tabs -->
            <div class="mb-6">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('user.reviews.index') }}"
                        class="px-4 py-2 rounded-lg {{ !request('rating') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition-colors">
                        {{ __('All Reviews') }}
                    </a>
                    @for ($i = 5; $i >= 1; $i--)
                        <a href="{{ route('user.reviews.index', ['rating' => $i]) }}"
                            class="px-4 py-2 rounded-lg {{ request('rating') == $i ? 'bg-yellow-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} transition-colors flex items-center">
                            {{ $i }}
                            <svg class="w-4 h-4 ml-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </a>
                    @endfor
                </div>
            </div>

            @if ($reviews->count() > 0)
                <!-- Reviews List -->
                <div class="space-y-6">
                    @foreach ($reviews as $review)
                        <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                            <div class="flex flex-col md:flex-row gap-6">
                                <!-- Product Image -->
                                <div class="flex-shrink-0">
                                    @if ($review->product && $review->product->media->count() > 0)
                                        <img class="h-24 w-24 rounded-lg object-cover"
                                            src="{{ asset('storage/' . $review->product->media->first()->path) }}"
                                            alt="{{ $review->product->name }}">
                                    @else
                                        <div class="h-24 w-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Review Content -->
                                <div class="flex-1">
                                    <div class="flex flex-col md:flex-row md:items-start md:justify-between mb-3">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                {{ $review->product->name ?? 'Product Not Found' }}
                                            </h3>
                                            @if ($review->product && $review->product->sku)
                                                <p class="text-sm text-gray-500">SKU: {{ $review->product->sku }}</p>
                                            @endif
                                        </div>
                                        <div class="flex items-center space-x-2 mt-2 md:mt-0">
                                            <span
                                                class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>

                                    <!-- Rating -->
                                    <div class="flex items-center mb-3">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                        <span class="ml-2 text-sm text-gray-600">({{ $review->rating }}/5)</span>
                                    </div>

                                    <!-- Review Comment -->
                                    @if ($review->comment)
                                        <div class="mb-4">
                                            <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                                        </div>
                                    @endif

                                    <!-- Review Status -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            @if ($review->approved)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Published
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Pending Approval
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex space-x-2">
                                            <a href="{{ route('user.reviews.edit', $review->id) }}"
                                                class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                                                Edit
                                            </a>
                                            <button onclick="deleteReview({{ $review->id }})"
                                                class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700 transition-colors">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $reviews->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No reviews found</h3>
                    <p class="mt-2 text-gray-500">
                        @if (request('rating'))
                            You don't have any {{ request('rating') }}-star reviews yet.
                        @else
                            You haven't written any product reviews yet.
                        @endif
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('user.orders.index', ['status' => 'completed']) }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            Review Your Purchases
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Review Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <div class="mt-2 px-7 py-3">
                    <h3 class="text-lg font-medium text-gray-900">Delete Review</h3>
                    <p class="text-sm text-gray-500 mt-2">
                        Are you sure you want to delete this review? This action cannot be undone.
                    </p>
                </div>
                <div class="items-center px-4 py-3 flex justify-end space-x-3">
                    <button onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition-colors">
                        Cancel
                    </button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                            Delete Review
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function deleteReview(reviewId) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = `/user/reviews/${reviewId}`;
            modal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
        }

        // Close modal when clicking outside
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('deleteModal');
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeDeleteModal();
                }
            });
        });
    </script>
@endsection
