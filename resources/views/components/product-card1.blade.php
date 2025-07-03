<div class="relative overflow-hidden group transition-transform duration-300 hover:scale-105 hover:shadow-lg">
    <div class="relative bg-gray-200 h-64 flex items-center justify-center ">
        <img src="https://cdn.ishop.cholobangla.com/uploads/product-6-1.webp" alt="" class=" object-cover h-full">
    </div>
    @if ($product->featured)
        <div class="absolute top-0 left-0 w-16 h-16">
            <div
                class="absolute w-24 py-1 text-xs font-normal text-center text-gray-800 transform -rotate-45 bg-primary -left-7 top-2">
                Discount
            </div>
        </div>
    @endif
    <div class="p-4">
        <div class="text-sm font-light mt-2">{{ $product->name }}</div>
        <div class="text-sm font-light mb-3">Price: {{ $product->currency }} {{ $product->price }}</div>

        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <button type="button"
                    class="quantity-btn bg-gray-200 hover:bg-gray-300 text-gray-700 w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold"
                    data-action="minus" data-product-card="{{ $product->id }}">
                    -
                </button>
                <input type="number"
                    class="quantity-input w-12 text-center border border-gray-300 rounded px-1 py-1 text-sm"
                    value="1" min="1" max="10" data-product-card="{{ $product->id }}">
                <button type="button"
                    class="quantity-btn bg-gray-200 hover:bg-gray-300 text-gray-700 w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold"
                    data-action="plus" data-product-card="{{ $product->id }}">
                    +
                </button>
            </div>

            <button type="button"
                class="add-to-cart-btn {{ $product->stock <= 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700' }} text-white w-10 h-10 rounded-full flex items-center justify-center transition-colors duration-200"
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
            <div class="text-red-500 text-xs mt-2">Out of Stock</div>
        @elseif($product->stock <= 5)
            <div class="text-orange-500 text-xs mt-2">Only {{ $product->stock }} left in stock</div>
        @endif
    </div>
</div>
