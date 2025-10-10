@extends('layouts.guest')
@section('content')
    <!-- Breadcrumb with Gradient -->
    <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center text-white text-sm">
                <a href="{{ route('/') }}" class="hover:text-gray-200 transition-colors">
                    <i class="fa-solid fa-home mr-2"></i>Home
                </a>
                <span class="mx-2">/</span>
                <a href="{{ route('/products') }}" class="hover:text-gray-200 transition-colors">Products</a>
                <span class="mx-2">/</span>
                <span class="text-gray-200">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in">
        <!-- Main Product Card -->
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden mb-8 transform hover:scale-[1.01] transition-transform duration-300">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6 lg:p-10">
                <!-- Product Images Section -->
                <div class="space-y-4">
                    @if ($product->media->count() > 0)
                        <!-- Main Image with Gradient Overlay on Hover -->
                        <div
                            class="relative group rounded-2xl overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600">
                            <img src="{{ asset($product->media->first()->file_path) }}" alt="{{ $product->name }}"
                                class="main-product-image w-full h-96 object-cover transition-transform duration-500 group-hover:scale-110">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>

                        <!-- Thumbnail Gallery -->
                        <div
                            class="flex gap-3 overflow-x-auto pb-2 scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600">
                            @foreach ($product->media as $index => $media)
                                <button type="button"
                                    class="thumbnail-btn flex-shrink-0 rounded-lg overflow-hidden border-2 {{ $index === 0 ? 'border-blue-500 dark:border-blue-400' : 'border-gray-300 dark:border-gray-600' }} hover:border-blue-500 dark:hover:border-blue-400 transition-all duration-200 transform hover:scale-105"
                                    data-image="{{ asset($media->file_path) }}">
                                    <img src="{{ asset($media->file_path) }}" alt="{{ $product->name }}"
                                        class="w-20 h-20 object-cover">
                                </button>
                            @endforeach
                        </div>
                    @else
                        <div
                            class="w-full h-96 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600 rounded-2xl flex items-center justify-center">
                            <div class="text-center">
                                <i class="fa-solid fa-image text-6xl text-gray-400 dark:text-gray-500 mb-3"></i>
                                <p class="text-gray-500 dark:text-gray-400">No image available</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Product Info Section -->
                <div class="flex flex-col space-y-6">
                    <!-- Product Title -->
                    <div>
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-3 leading-tight">
                            {{ $product->name }}
                        </h1>
                        <div class="flex items-center gap-3 flex-wrap">
                            @if ($product->category)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-blue-500 to-purple-500 text-white">
                                    <i class="fa-solid fa-tag mr-1.5"></i>{{ $product->category->name }}
                                </span>
                            @endif
                            @if ($product->brand)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-purple-500 to-pink-500 text-white">
                                    <i class="fa-solid fa-certificate mr-1.5"></i>{{ $product->brand->name }}
                                </span>
                            @endif
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                SKU: {{ $product->sku }}
                            </span>
                        </div>
                    </div>

                    <!-- Price Section -->
                    <div
                        class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl p-5 border border-green-200 dark:border-green-800">
                        <div class="flex items-baseline gap-3">
                            <span
                                class="text-4xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                                RS. {{ number_format($product->price, 2) }}
                            </span>
                            @if ($product->old_price)
                                <span class="text-xl line-through text-gray-500 dark:text-gray-400">
                                    RS. {{ number_format($product->old_price, 2) }}
                                </span>
                                <span class="ml-auto px-3 py-1 rounded-full text-sm font-bold bg-red-500 text-white">
                                    -{{ round((($product->old_price - $product->price) / $product->old_price) * 100) }}%
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Stock Status -->
                    <div class="flex items-center gap-2">
                        <span class="text-gray-700 dark:text-gray-300 font-medium">Availability:</span>
                        @if ($product->stock > 0)
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 font-semibold">
                                <i class="fa-solid fa-circle-check mr-2"></i>In Stock ({{ $product->stock }} units)
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 font-semibold">
                                <i class="fa-solid fa-circle-xmark mr-2"></i>Out of Stock
                            </span>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="prose dark:prose-invert max-w-none">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 flex items-center">
                            <i class="fa-solid fa-align-left mr-2 text-blue-500"></i>Product Description
                        </h3>
                        <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            {!! $product->description !!}
                        </div>
                    </div>

                    <!-- Add to Cart Section -->
                    <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-4 flex-wrap">
                            <!-- Quantity Selector -->
                            <div class="flex items-center gap-3">
                                <label class="text-gray-700 dark:text-gray-300 font-medium">Quantity:</label>
                                <div class="flex items-center bg-gray-100 dark:bg-gray-700 rounded-lg p-1">
                                    <button type="button"
                                        class="quantity-btn bg-white dark:bg-gray-600 hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-500 hover:text-white text-gray-700 dark:text-gray-200 w-10 h-10 rounded-lg flex items-center justify-center font-bold transition-all duration-300 transform hover:scale-110"
                                        data-action="minus" data-product-card="{{ $product->id }}">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                    <input type="number"
                                        class="quantity-input w-16 text-center border-0 bg-transparent text-gray-900 dark:text-gray-100 font-semibold text-lg focus:outline-none"
                                        value="1" min="1" max="10"
                                        data-product-card="{{ $product->id }}">
                                    <button type="button"
                                        class="quantity-btn bg-white dark:bg-gray-600 hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-500 hover:text-white text-gray-700 dark:text-gray-200 w-10 h-10 rounded-lg flex items-center justify-center font-bold transition-all duration-300 transform hover:scale-110"
                                        data-action="plus" data-product-card="{{ $product->id }}">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Add to Cart Button -->
                            <button type="button"
                                class="add-to-cart-btn flex-1 {{ $product->stock <= 0 ? 'bg-gray-400 dark:bg-gray-600 cursor-not-allowed' : 'bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 hover:from-blue-700 hover:via-purple-700 hover:to-pink-700 transform hover:scale-105 hover:shadow-xl' }} text-white px-8 py-4 rounded-lg font-bold text-lg transition-all duration-300 flex items-center justify-center gap-3"
                                data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}"
                                data-product-price="{{ $product->price }}" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                @if ($product->stock <= 0)
                                    <i class="fa-solid fa-ban text-xl"></i>
                                    <span>Out of Stock</span>
                                @else
                                    <i class="fa-solid fa-cart-plus text-xl"></i>
                                    <span>Add to Cart</span>
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Reviews Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-6 lg:p-10 animate-slide-up">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                    <i class="fa-solid fa-star text-yellow-400 mr-3"></i>
                    Customer Reviews
                </h2>
                @if ($product->reviews->count() > 0)
                    <div
                        class="flex items-center gap-2 bg-gradient-to-r from-yellow-400 to-orange-400 text-white px-4 py-2 rounded-lg">
                        <i class="fa-solid fa-star"></i>
                        <span class="font-bold">
                            {{ number_format($product->reviews->avg('rating'), 1) }} / 5
                        </span>
                        <span class="text-sm opacity-90">({{ $product->reviews->count() }} reviews)</span>
                    </div>
                @endif
            </div>

            @if ($product->reviews->count() > 0)
                <div class="space-y-4">
                    @foreach ($product->reviews as $review)
                        <div
                            class="bg-gradient-to-r from-gray-50 to-white dark:from-gray-700 dark:to-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-600 hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02]">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-lg">
                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 dark:text-white">{{ $review->user->name }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            <i class="fa-regular fa-calendar mr-1"></i>
                                            {{ $review->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i
                                            class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star text-yellow-400 text-lg"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed pl-15">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fa-regular fa-comments text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                    <p class="text-gray-500 dark:text-gray-400 text-lg">No reviews yet for this product.</p>
                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Be the first to share your thoughts!</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('jsscript')
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }

        .animate-slide-up {
            animation: slide-up 0.8s ease-out 0.2s both;
        }

        .scrollbar-thin {
            scrollbar-width: thin;
        }

        .scrollbar-thin::-webkit-scrollbar {
            height: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .dark .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #4b5563;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image gallery functionality
            const thumbnails = document.querySelectorAll('.thumbnail-btn');
            const mainImage = document.querySelector('.main-product-image');

            thumbnails.forEach((thumb, index) => {
                thumb.addEventListener('click', function() {
                    const imageSrc = this.dataset.image;
                    mainImage.src = imageSrc;

                    // Update active state
                    thumbnails.forEach(t => {
                        t.classList.remove('border-blue-500', 'dark:border-blue-400');
                        t.classList.add('border-gray-300', 'dark:border-gray-600');
                    });
                    this.classList.remove('border-gray-300', 'dark:border-gray-600');
                    this.classList.add('border-blue-500', 'dark:border-blue-400');
                });
            });
        });
    </script>
@endsection
