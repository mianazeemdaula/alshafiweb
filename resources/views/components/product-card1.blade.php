<div
    class="group relative overflow-hidden transition-all duration-500 hover:scale-105 bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-2xl border border-gray-100 dark:border-gray-700">

    <!-- Product Image with Overlay -->
    <div class="relative aspect-square overflow-hidden bg-gray-100 dark:bg-gray-700">
        <a href="{{ url("/product/$product->sku") }}" class="block">
            @if ($product->media->isNotEmpty())
                <img src="{{ asset($product->media->first()->file_path) }}" alt="{{ $product->name }}"
                    class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-110">
            @else
                <img src="https://cdn.ishop.cholobangla.com/uploads/product-6-1.webp" alt="{{ $product->name }}"
                    class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-110">
            @endif

            <!-- Gradient Overlay on Hover -->
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
            </div>

            <!-- Quick View Badge (appears on hover) -->
            <div
                class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-y-4 group-hover:translate-y-0">
                <span
                    class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm text-gray-900 dark:text-white px-4 py-2 rounded-xl text-sm font-medium shadow-lg">
                    <i class="fa fa-eye mr-2"></i>Quick View
                </span>
            </div>
        </a>

        <!-- Featured Badge -->
        {{-- @if ($product->featured) --}}
        {{-- <div class="absolute top-3 left-3">
            <div
                class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow-lg flex items-center gap-1">
                <i class="fa fa-star"></i>
                <span>Featured</span>
            </div>
        </div> --}}
        {{-- @endif --}}

        <!-- Discount Badge -->
        @if (isset($product->discount) && $product->discount > 0)
            @php
                $originalPrice = $product->price + $product->discount;
                $discountPercent = round(($product->discount / $originalPrice) * 100);
            @endphp
            <div class="absolute top-3 right-3">
                <div
                    class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow-lg opacity-20">
                    -{{ $discountPercent }}% OFF
                </div>
            </div>
        @endif

        <!-- Bulk Offer Badge -->
        @if ($product->activeOffers->count() > 0)
            @php
                $bestOffer = $product->activeOffers->sortByDesc('priority')->first();
            @endphp
            <div class="absolute top-14 right-3">
                <div
                    class="bg-gradient-to-r from-orange-500 to-yellow-500 text-white px-2 py-1 rounded-lg text-xs font-bold shadow-lg flex items-center gap-1">
                    <i class="fa fa-tags"></i>
                    <span>
                        @if ($bestOffer->discount_type === 'percentage')
                            {{ $bestOffer->discount_value }}% Off on {{ $bestOffer->min_quantity }}+
                        @else
                            Rs {{ $bestOffer->discount_value }} Off on {{ $bestOffer->min_quantity }}+
                        @endif
                    </span>
                </div>
            </div>
        @endif

        <!-- Stock Status Badge -->
        @if ($product->stock <= 0)
            <div class="absolute bottom-3 left-3 right-3">
                <div
                    class="bg-gray-900/80 dark:bg-gray-800/80 backdrop-blur-sm text-white px-3 py-2 rounded-lg text-xs font-bold text-center">
                    <i class="fa fa-ban mr-1"></i>OUT OF STOCK
                </div>
            </div>
        @elseif($product->stock <= 5)
            <div class="absolute bottom-3 left-3">
                <div
                    class="bg-orange-500/90 backdrop-blur-sm text-white px-2 py-1 rounded-lg text-xs font-bold animate-pulse">
                    <i class="fa fa-fire mr-1"></i>Only {{ $product->stock }} left!
                </div>
            </div>
        @endif
    </div>

    <!-- Product Info -->
    <div class="p-4 space-y-3">

        <!-- Product Name -->
        <a href="{{ url("/product/$product->sku") }}" class="block">
            <h3
                class="text-sm font-semibold text-gray-900 dark:text-gray-100 line-clamp-2 leading-tight group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300 min-h-[2.5rem]">
                {{ $product->name }}
            </h3>
        </a>

        <!-- Rating -->
        <div class="flex items-center gap-2">
            <div class="flex items-center">
                @php
                    $rating = $product->average_rating ?? 0;
                    $fullStars = floor($rating);
                    $hasHalfStar = $rating - $fullStars >= 0.5;
                @endphp
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $fullStars)
                        <i class="fa-solid fa-star text-yellow-400 text-xs"></i>
                    @elseif ($i == $fullStars + 1 && $hasHalfStar)
                        <i class="fa-solid fa-star-half-stroke text-yellow-400 text-xs"></i>
                    @else
                        <i class="fa-regular fa-star text-gray-300 dark:text-gray-600 text-xs"></i>
                    @endif
                @endfor
            </div>
            <span class="text-xs font-medium text-gray-600 dark:text-gray-400">({{ number_format($rating, 1) }})</span>
        </div>

        <!-- Price Section -->
        <div class="flex items-center gap-2 flex-wrap">
            @if (isset($product->discount) && $product->discount > 0)
                <div class="flex items-baseline gap-2">
                    <span
                        class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                        {{ $product->currency }} {{ number_format($product->price, 2) }}
                    </span>
                    <span class="text-xs text-gray-400 dark:text-gray-500 line-through">
                        {{ $product->currency }} {{ number_format($originalPrice, 2) }}
                    </span>
                </div>
            @else
                <span class="text-xl font-bold text-gray-900 dark:text-white">
                    {{ $product->currency }} {{ number_format($product->price, 2) }}
                </span>
            @endif
        </div>

        <!-- Quantity & Add to Cart -->
        <div class="flex items-center justify-between gap-2 pt-2 border-t border-gray-100 dark:border-gray-700">

            <!-- Quantity Selector -->
            <div class="flex items-center bg-gray-100 dark:bg-gray-700 rounded-xl p-1">
                <button type="button"
                    class="quantity-btn bg-white dark:bg-gray-600 hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-500 hover:text-white text-gray-700 dark:text-gray-200 w-7 h-7 rounded-lg flex items-center justify-center transition-all duration-300 shadow-sm"
                    data-action="minus" data-product-card="{{ $product->id }}">
                    <i class="fa-solid fa-minus text-xs"></i>
                </button>
                <input type="number"
                    class="quantity-input w-10 text-center bg-transparent text-gray-900 dark:text-gray-100 font-semibold text-sm focus:outline-none"
                    value="1" min="1" max="10" data-product-card="{{ $product->id }}" readonly>
                <button type="button"
                    class="quantity-btn bg-white dark:bg-gray-600 hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-500 hover:text-white text-gray-700 dark:text-gray-200 w-7 h-7 rounded-lg flex items-center justify-center transition-all duration-300 shadow-sm"
                    data-action="plus" data-product-card="{{ $product->id }}">
                    <i class="fa-solid fa-plus text-xs"></i>
                </button>
            </div>

            <!-- Add to Cart Button -->
            <button type="button"
                class="add-to-cart-btn flex-1 {{ $product->stock <= 0
                    ? 'bg-gray-400 dark:bg-gray-600 cursor-not-allowed'
                    : 'bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 shadow-lg hover:shadow-xl' }} 
                    text-white px-4 py-2.5 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2"
                data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}"
                data-product-price="{{ $product->price }}" {{ $product->stock <= 0 ? 'disabled' : '' }}
                title="{{ $product->stock <= 0 ? 'Out of Stock' : 'Add to Cart' }}">
                @if ($product->stock <= 0)
                    <i class="fa-solid fa-ban text-sm"></i>
                    <span class="text-xs font-bold hidden sm:inline">Unavailable</span>
                @else
                    <i class="fa-solid fa-cart-plus text-sm"></i>
                @endif
            </button>
        </div>

        <!-- Order on WhatsApp -->
        @php
            $whatsapp = $product->whatsapp_contact ?? '923253255555';
        @endphp
        <a href="https://wa.me/{{ $whatsapp }}?text={{ urlencode('I want to order: ' . $product->name) }}"
            target="_blank"
            class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-xl font-medium transition-all duration-300 flex items-center justify-center gap-2 text-sm shadow-md hover:shadow-lg">
            {{-- <i class="fa-brands fa-whatsapp text-base"></i> --}}
            <span>Chat with us</span>
        </a>
    </div>
</div>
