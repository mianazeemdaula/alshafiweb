<div
    class="group relative overflow-hidden transition-all duration-300 bg-[#fdfcf9] dark:bg-[#141f1a] rounded-2xl border border-emerald-900/5 dark:border-emerald-800/20 hover:border-emerald-300 dark:hover:border-emerald-700 shadow-sm hover:shadow-md">

    <!-- Product Image with Overlay -->
    <div class="relative aspect-square overflow-hidden bg-[#f6f3eb] dark:bg-emerald-950/20">
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
                    class="bg-[#fdfcf9]/95 dark:bg-[#0c120f]/95 border border-emerald-900/10 dark:border-emerald-800/25 text-emerald-900 dark:text-emerald-250 px-4 py-2 rounded-xl text-sm font-semibold shadow-lg">
                    <i class="fa fa-eye mr-2 text-emerald-600"></i>Quick View
                </span>
            </div>
        </a>

        <!-- Discount Badge -->
        @if (isset($product->discount) && $product->discount > 0)
            @php
                $originalPrice = $product->price + $product->discount;
                $discountPercent = round(($product->discount / $originalPrice) * 100);
            @endphp
            <div class="absolute top-3 right-3">
                <div
                    class="bg-[#c94a4a] text-white px-2.5 py-1 rounded-lg text-xs font-bold shadow-sm">
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
                    class="bg-[#c5a059] text-white px-2 py-1 rounded-lg text-xs font-bold shadow-sm flex items-center gap-1">
                    <i class="fa fa-tags text-[10px]"></i>
                    <span>
                        @if ($bestOffer->discount_type === 'percentage')
                            {{ $bestOffer->discount_value }}% Off ({{ $bestOffer->min_quantity }}+)
                        @else
                            Rs {{ $bestOffer->discount_value }} Off ({{ $bestOffer->min_quantity }}+)
                        @endif
                    </span>
                </div>
            </div>
        @endif

        <!-- Stock Status Badge -->
        @if ($product->stock <= 0)
            <div class="absolute bottom-3 left-3 right-3">
                <div
                    class="bg-emerald-950/80 backdrop-blur-sm text-white px-3 py-2 rounded-xl text-xs font-bold text-center border border-emerald-900/30">
                    <i class="fa fa-ban mr-1.5 text-red-400"></i>OUT OF STOCK
                </div>
            </div>
        @elseif($product->stock <= 5)
            <div class="absolute bottom-3 left-3">
                <div
                    class="bg-amber-600/90 backdrop-blur-sm text-white px-2.5 py-1 rounded-lg text-xs font-bold animate-pulse">
                    <i class="fa fa-fire mr-1 text-amber-300"></i>Only {{ $product->stock }} left!
                </div>
            </div>
        @endif
    </div>

    <!-- Product Info -->
    <div class="p-4 space-y-3">

        <!-- Product Name -->
        <a href="{{ url("/product/$product->sku") }}" class="block">
            <h3
                class="text-sm font-bold text-gray-900 dark:text-gray-100 line-clamp-2 leading-tight group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors duration-300 min-h-[2.5rem] font-serif">
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
                        <i class="fa-solid fa-star text-amber-500 text-[10px]"></i>
                    @elseif ($i == $fullStars + 1 && $hasHalfStar)
                        <i class="fa-solid fa-star-half-stroke text-amber-500 text-[10px]"></i>
                    @else
                        <i class="fa-regular fa-star text-gray-300 dark:text-gray-600 text-[10px]"></i>
                    @endif
                @endfor
            </div>
            <span class="text-xs font-medium text-gray-600 dark:text-gray-400">({{ number_format($rating, 1) }})</span>
        </div>

        <!-- Price Section -->
        <div class="flex items-center gap-2 flex-wrap">
            @if (isset($product->discount) && $product->discount > 0)
                <div class="flex items-baseline gap-2">
                    <span class="text-xl font-bold text-emerald-750 dark:text-emerald-400 font-serif">
                        {{ $product->currency }} {{ number_format($product->price, 2) }}
                    </span>
                    <span class="text-xs text-[#8d9a94] dark:text-[#72847b] line-through font-serif">
                        {{ $product->currency }} {{ number_format($originalPrice, 2) }}
                    </span>
                </div>
            @else
                <span class="text-xl font-bold text-emerald-800 dark:text-white font-serif">
                    {{ $product->currency }} {{ number_format($product->price, 2) }}
                </span>
            @endif
        </div>

        <!-- Quantity & Add to Cart -->
        <div class="flex items-center justify-between gap-2 pt-2 border-t border-emerald-900/5 dark:border-emerald-800/10">

            <!-- Quantity Selector -->
            <div class="flex items-center bg-[#f6f3eb] dark:bg-[#1b2c24] rounded-xl p-1 border border-emerald-900/5 dark:border-emerald-800/10">
                <button type="button"
                    class="quantity-btn bg-white dark:bg-emerald-950 text-emerald-800 dark:text-emerald-100 hover:bg-emerald-700 hover:text-white dark:hover:bg-emerald-600 w-7 h-7 rounded-lg flex items-center justify-center transition-colors border border-emerald-900/5 dark:border-emerald-800/10"
                    data-action="minus" data-product-card="{{ $product->id }}">
                    <i class="fa-solid fa-minus text-[10px]"></i>
                </button>
                <input type="number"
                    class="quantity-input w-9 text-center bg-transparent text-gray-900 dark:text-gray-100 font-bold text-sm focus:outline-none"
                    value="1" min="1" max="10" data-product-card="{{ $product->id }}" readonly>
                <button type="button"
                    class="quantity-btn bg-white dark:bg-emerald-950 text-emerald-800 dark:text-emerald-100 hover:bg-emerald-700 hover:text-white dark:hover:bg-emerald-600 w-7 h-7 rounded-lg flex items-center justify-center transition-colors border border-emerald-900/5 dark:border-emerald-800/10"
                    data-action="plus" data-product-card="{{ $product->id }}">
                    <i class="fa-solid fa-plus text-[10px]"></i>
                </button>
            </div>

            <!-- Add to Cart Button -->
            <button type="button"
                class="add-to-cart-btn flex-1 {{ $product->stock <= 0
                    ? 'bg-gray-300 dark:bg-gray-600 cursor-not-allowed'
                    : 'bg-emerald-700 hover:bg-emerald-800 dark:bg-emerald-600 dark:hover:bg-emerald-500 shadow-sm shadow-emerald-700/5' }} 
                    text-white px-4 py-2.5 rounded-xl font-bold transition-colors flex items-center justify-center gap-2"
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
            class="w-full bg-[#25d366] hover:bg-[#20ba5a] text-white py-2 rounded-xl font-bold transition-all duration-300 flex items-center justify-center gap-2 text-sm shadow-sm">
            <i class="fa-brands fa-whatsapp text-base"></i>
            <span>WhatsApp Order</span>
        </a>
    </div>
</div>
