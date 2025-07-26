@extends('layouts.guest')
@section('content')
    <div class="max-w-4xl mx-auto p-4">
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 flex flex-col md:flex-row gap-8">
            <!-- Product Images -->
            <div class="flex-shrink-0 w-full md:w-1/3 flex flex-col gap-4">
                @if ($product->media->count() > 0)
                    <img src="{{ asset($product->media->first()->file_path) }}" alt="{{ $product->name }}"
                        class="rounded-lg w-full h-64 object-cover mb-2">
                    <div class="flex gap-2 flex-wrap">
                        @foreach ($product->media as $media)
                            <img src="{{ asset($media->file_path) }}" alt="{{ $product->name }}"
                                class="w-16 h-16 rounded object-cover border">
                        @endforeach
                    </div>
                @else
                    <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                        <i class="fa-solid fa-image text-4xl"></i>
                    </div>
                @endif
            </div>
            <!-- Product Info -->
            <div class="flex-1 flex flex-col gap-4">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $product->name }}</h1>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-lg font-semibold text-green-600 dark:text-green-400">RS. {{ $product->price }}</span>
                    @if ($product->old_price)
                        <span class="text-sm line-through text-gray-500">RS. {{ $product->old_price }}</span>
                    @endif
                </div>
                <div class="mb-2">
                    <span class="font-medium text-gray-700 dark:text-gray-300">SKU:</span>
                    <span class="text-xs text-gray-500">{{ $product->sku }}</span>
                </div>
                <div class="mb-2">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Category:</span>
                    <span class="text-xs text-blue-600 dark:text-blue-400">{{ $product->category->name ?? '-' }}</span>
                </div>
                <div class="mb-2">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Brand:</span>
                    <span class="text-xs text-gray-500">{{ $product->brand->name ?? '-' }}</span>
                </div>
                <div class="mb-2">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Stock:</span>
                    <span
                        class="text-xs {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">{{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}</span>
                </div>
                <div class="mb-4">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Description:</span>
                    <div class="text-sm text-gray-700 dark:text-gray-200 mt-1">{!! $product->description !!}</div>
                </div>
                <!-- Add to Cart Button (interactive) -->
                <div class="flex items-center justify-between flex-col sm:flex-row gap-2 sm:gap-0">
                    <div class="flex items-center space-x-1 sm:space-x-2 order-2 sm:order-1">
                        <button type="button"
                            class="quantity-btn bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 w-6 h-6 sm:w-8 sm:h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors"
                            data-action="minus" data-product-card="{{ $product->id }}">
                            <i class="fa-solid fa-minus text-xs"></i>
                        </button>
                        <input type="number"
                            class="quantity-input w-8 sm:w-12 text-center border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded px-1 py-1 text-xs sm:text-sm"
                            value="1" min="1" max="10" data-product-card="{{ $product->id }}">
                        <button type="button"
                            class="quantity-btn bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 w-6 h-6 sm:w-8 sm:h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors"
                            data-action="plus" data-product-card="{{ $product->id }}">
                            <i class="fa-solid fa-plus text-xs"></i>
                        </button>
                    </div>

                    <button type="button"
                        class="add-to-cart-btn {{ $product->stock <= 0 ? 'bg-gray-400 dark:bg-gray-600 cursor-not-allowed' : 'bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600' }} text-white w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center transition-colors duration-200 order-1 sm:order-2"
                        data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}"
                        data-product-price="{{ $product->price }}" {{ $product->stock <= 0 ? 'disabled' : '' }}
                        title="{{ $product->stock <= 0 ? 'Out of Stock' : 'Add to Cart' }}">
                        @if ($product->stock <= 0)
                            <i class="fa-solid fa-ban text-xs sm:text-sm"></i>
                        @else
                            <i class="fa-solid fa-cart-plus text-xs sm:text-sm"></i>
                        @endif
                    </button>
                </div>
            </div>
        </div>
        <!-- Product Reviews -->
        <div class="mt-8">
            <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Customer Reviews</h2>
            @if ($product->reviews->count() > 0)
                <div class="space-y-4">
                    @foreach ($product->reviews as $review)
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center mb-2">
                                <span
                                    class="font-bold text-gray-800 dark:text-gray-100 mr-2">{{ $review->user->name }}</span>
                                <span class="text-xs text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center mb-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star text-yellow-400"></i>
                                @endfor
                                <span class="ml-2 text-xs text-gray-500">({{ $review->rating }}/5)</span>
                            </div>
                            <div class="text-gray-700 dark:text-gray-200 text-sm">{{ $review->comment }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-gray-500 dark:text-gray-400">No reviews yet for this product.</div>
            @endif
        </div>
    </div>
@endsection
