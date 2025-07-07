@extends('layouts.guest')

@section('content')
    @include('components.user-nav')

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center mb-6">
                    <a href="{{ route('user.reviews.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h1 class="text-3xl font-bold text-gray-800">Write a Review</h1>
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('user.reviews.store') }}" method="POST" id="review-form">
                    @csrf

                    <!-- Product Selection -->
                    @if (isset($product))
                        <!-- Pre-selected Product -->
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Product</label>
                            <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
                                @if ($product->media->count() > 0)
                                    <img class="h-16 w-16 rounded-lg object-cover"
                                        src="{{ asset('storage/' . $product->media->first()->path) }}"
                                        alt="{{ $product->name }}">
                                @else
                                    <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="font-medium text-gray-900">{{ $product->name }}</h3>
                                    @if ($product->sku)
                                        <p class="text-sm text-gray-500">SKU: {{ $product->sku }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Product Selection Dropdown -->
                        <div class="mb-6">
                            <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Select Product <span class="text-red-500">*</span>
                            </label>
                            <select id="product_id" name="product_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Choose a product to review...</option>
                                @foreach ($purchasedProducts as $purchasedProduct)
                                    <option value="{{ $purchasedProduct->id }}"
                                        {{ old('product_id') == $purchasedProduct->id ? 'selected' : '' }}>
                                        {{ $purchasedProduct->name }}
                                        @if ($purchasedProduct->sku)
                                            - SKU: {{ $purchasedProduct->sku }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @if ($purchasedProducts->isEmpty())
                                <p class="mt-2 text-sm text-gray-500">
                                    You can only review products you have purchased.
                                    <a href="{{ route('user.orders.index', ['status' => 'completed']) }}"
                                        class="text-blue-600 hover:text-blue-800">View your completed orders</a>
                                </p>
                            @endif
                        </div>
                    @endif

                    <!-- Rating -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Rating <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center space-x-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button" onclick="setRating({{ $i }})"
                                    class="rating-star text-gray-300 hover:text-yellow-400 transition-colors"
                                    data-rating="{{ $i }}">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </button>
                            @endfor
                        </div>
                        <input type="hidden" id="rating" name="rating" value="{{ old('rating') }}" required>
                        <p id="rating-text" class="mt-2 text-sm text-gray-500">Click the stars to rate this product</p>
                    </div>

                    <!-- Review Comment -->
                    <div class="mb-6">
                        <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                            Your Review
                        </label>
                        <textarea id="comment" name="comment" rows="5"
                            placeholder="Tell others about your experience with this product..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('comment') }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Share your honest opinion to help other customers make
                            informed decisions.</p>
                    </div>

                    <!-- Review Guidelines -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <h3 class="text-sm font-medium text-blue-800 mb-2">Review Guidelines</h3>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Be honest and helpful in your review</li>
                            <li>• Focus on the product's features, quality, and your experience</li>
                            <li>• Avoid inappropriate language or personal information</li>
                            <li>• Reviews are subject to approval before being published</li>
                        </ul>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('user.reviews.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" id="submit-btn"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed">
                            Submit Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        let currentRating = {{ old('rating', 0) }};

        function setRating(rating) {
            currentRating = rating;
            document.getElementById('rating').value = rating;
            updateStars();
            updateRatingText();
            validateForm();
        }

        function updateStars() {
            const stars = document.querySelectorAll('.rating-star');
            stars.forEach((star, index) => {
                const rating = parseInt(star.dataset.rating);
                if (rating <= currentRating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });
        }

        function updateRatingText() {
            const ratingText = document.getElementById('rating-text');
            const texts = {
                0: 'Click the stars to rate this product',
                1: 'Poor - This product did not meet expectations',
                2: 'Fair - This product has some issues',
                3: 'Good - This product is decent',
                4: 'Very Good - This product is great',
                5: 'Excellent - This product is outstanding!'
            };
            ratingText.textContent = texts[currentRating];
            ratingText.className = `mt-2 text-sm ${currentRating > 0 ? 'text-blue-600' : 'text-gray-500'}`;
        }

        function validateForm() {
            const submitBtn = document.getElementById('submit-btn');
            const productId = document.getElementById('product_id')?.value ||
            {{ isset($product) ? $product->id : 'null' }};
            const hasRating = currentRating > 0;

            if (productId && hasRating) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize rating if there's an old value
            if (currentRating > 0) {
                updateStars();
                updateRatingText();
            }

            // Add event listener for product selection if dropdown exists
            const productSelect = document.getElementById('product_id');
            if (productSelect) {
                productSelect.addEventListener('change', validateForm);
            }

            // Initial validation
            validateForm();

            // Auto-hide success messages after 5 seconds
            const successAlert = document.querySelector('.bg-green-100');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.transition = 'opacity 0.5s';
                    successAlert.style.opacity = '0';
                    setTimeout(() => {
                        successAlert.remove();
                    }, 500);
                }, 5000);
            }

            // Character counter for comment
            const commentTextarea = document.getElementById('comment');
            const maxLength = 1000;

            const charCounter = document.createElement('p');
            charCounter.className = 'mt-1 text-sm text-gray-500 text-right';
            commentTextarea.parentNode.appendChild(charCounter);

            function updateCharCounter() {
                const remaining = maxLength - commentTextarea.value.length;
                charCounter.textContent = `${commentTextarea.value.length}/${maxLength} characters`;
                charCounter.className =
                    `mt-1 text-sm text-right ${remaining < 50 ? 'text-red-500' : 'text-gray-500'}`;
            }

            commentTextarea.addEventListener('input', updateCharCounter);
            commentTextarea.setAttribute('maxlength', maxLength);
            updateCharCounter();
        });
    </script>
@endsection
