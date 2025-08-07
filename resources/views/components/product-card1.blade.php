<div
    class="relative overflow-hidden transition-transform duration-300 hover:scale-105 hover:shadow-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
    <div class="relative aspect-square overflow-hidden">
        <a href="{{ url("/product/$product->sku") }}" class="block group">
            @if ($product->media->isNotEmpty())
                <img src="{{ asset($product->media->first()->file_path) }}" alt=""
                    class="object-cover w-full h-full">
            @else
                <img src="https://cdn.ishop.cholobangla.com/uploads/product-6-1.webp" alt=""
                    class="object-cover w-full h-full">
            @endif
    </div>
    @if ($product->featured)
        <div class="absolute top-0 left-0 w-12 h-12 sm:w-16 sm:h-16">
            <div
                class="absolute w-16 sm:w-24 py-1 text-xs font-normal text-center text-gray-800 dark:text-gray-200 transform -rotate-45 bg-primary -left-5 sm:-left-7 top-1 sm:top-2">
                Discount
            </div>
        </div>
    @endif

    </a>
    <div class="p-3">
        <div class="text-sm font-medium text-gray-900 dark:text-gray-100 line-clamp-2 mb-2">
            {{ $product->name }}</div>
        <div class="flex items-center mb-2">
            @php
                $rating = $product->average_rating ?? 0;
                $fullStars = floor($rating);
                $hasHalfStar = $rating - $fullStars >= 0.5;
            @endphp
            @for ($i = 1; $i <= 5; $i++)
                @if ($i <= $fullStars)
                    <i class="fa-solid fa-star text-yellow-400 text-xs mr-0.5"></i>
                @elseif ($i == $fullStars + 1 && $hasHalfStar)
                    <i class="fa-solid fa-star-half-stroke text-yellow-400 text-xs mr-0.5"></i>
                @else
                    <i class="fa-regular fa-star text-gray-300 dark:text-gray-500 text-xs mr-0.5"></i>
                @endif
            @endfor
            <span class="ml-1 text-xs text-gray-500 dark:text-gray-400">({{ number_format($rating, 1) }})</span>
        </div>
        <div class="flex items-center mb-3 flex-wrap">
            @if (isset($product->discount) && $product->discount > 0)
                @php
                    $originalPrice = $product->price + $product->discount;
                @endphp
                <span class="text-gray-400 dark:text-gray-500 text-xs line-through mr-2">{{ $product->currency }}
                    {{ number_format($originalPrice, 2) }}</span>
                <span class="text-red-500 dark:text-red-400 text-sm font-semibold mr-2">{{ $product->currency }}
                    {{ number_format($product->price, 2) }}</span>
                <span
                    class="bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-200 text-xs px-2 py-0.5 rounded-full font-bold">-{{ round(($product->discount / $originalPrice) * 100) }}%</span>
            @else
                <span class="text-gray-800 dark:text-gray-200 text-sm font-semibold">{{ $product->currency }}
                    {{ number_format($product->price, 2) }}</span>
            @endif
        </div>

        <div class="flex items-center justify-between gap-2">
            <div class="flex items-center space-x-2">
                <button type="button"
                    class="quantity-btn bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 w-7 h-7 rounded-full flex items-center justify-center text-sm font-bold transition-colors"
                    data-action="minus" data-product-card="{{ $product->id }}">
                    <i class="fa-solid fa-minus text-xs"></i>
                </button>
                <input type="number"
                    class="quantity-input w-10 text-center border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded px-1 py-1 text-xs"
                    value="1" min="1" max="10" data-product-card="{{ $product->id }}">
                <button type="button"
                    class="quantity-btn bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 w-7 h-7 rounded-full flex items-center justify-center text-sm font-bold transition-colors"
                    data-action="plus" data-product-card="{{ $product->id }}">
                    <i class="fa-solid fa-plus text-xs"></i>
                </button>
            </div>

            <button type="button"
                class="add-to-cart-btn {{ $product->stock <= 0 ? 'bg-gray-400 dark:bg-gray-600 cursor-not-allowed' : 'bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600' }} text-white w-9 h-9 rounded-full flex items-center justify-center transition-colors duration-200"
                data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}"
                data-product-price="{{ $product->price }}" {{ $product->stock <= 0 ? 'disabled' : '' }}
                title="{{ $product->stock <= 0 ? 'Out of Stock' : 'Add to Cart' }}">
                @if ($product->stock <= 0)
                    <i class="fa-solid fa-ban text-sm"></i>
                @else
                    <i class="fa-solid fa-cart-plus text-sm"></i>
                @endif
            </button>
        </div>

        @if ($product->stock <= 0)
            <div class="text-red-500 dark:text-red-400 text-xs mt-2">Out of Stock</div>
        @elseif($product->stock <= 5)
            <div class="text-orange-500 dark:text-orange-400 text-xs mt-2">Only {{ $product->stock }} left in stock
            </div>
        @endif
    </div>
</div>
