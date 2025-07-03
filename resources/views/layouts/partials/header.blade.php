<div class="border-b p-2 flex items-center justify-between text-sm flex-col md:flex-row">
    <div class="flex  space-x-2 items-center">
        <div class="flex items-center ">
            <i class="fa-regular fa-envelope mx-1"></i>
            <div>info@alshafionline.com</div>
        </div>
        <div class="border border-slate-100 h-4"></div>
        <div class="flex items-center ">
            <i class="fa fa-phone mx-1"></i>
            <div>Helpline 4534345656</div>
        </div>
    </div>
    <div class="flex space-x-2 items-center">
        <!-- Country/Language Selector -->
        <div class="flex items-center space-x-2">
            <select id="country-selector" class="text-xs border rounded px-2 py-1">
                @foreach ($availableCountries as $code => $country)
                    <option value="{{ $code }}" {{ $currentCountry == $code ? 'selected' : '' }}>
                        {{ $country['name'] }}
                    </option>
                @endforeach
            </select>
            <select id="locale-selector" class="text-xs border rounded px-2 py-1">
                @foreach ($availableLocales as $code => $locale)
                    <option value="{{ $code }}" {{ $currentLocale == $code ? 'selected' : '' }}>
                        {{ $locale['flag'] }} {{ $locale['name'] }}
                    </option>
                @endforeach
            </select>
            @if (isset($currentCurrency))
                <span class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $currentCurrency }}</span>
            @endif
        </div>
        <div class="border border-slate-100 h-4"></div>
        <a href="{{ url('/login') }}" class="flex items-center ">
            <i class="fa fa-user-lock mx-1"></i>
            <div>{{ __('login') }}</div>
        </a>
        <div class="border border-slate-100 h-4"></div>
        <a href="{{ url('/register') }}" class="flex items-center ">
            <i class="fa fa-user-plus mx-1"></i>
            <div>{{ __('register') }}</div>
        </a>
    </div>
</div>
<div class="bg-white w-full z-50" id="header">
    <div class="p-2 border-b">
        <div class="flex flex-col md:flex-row items-center gap-2">
            <div class="w-2/12">
                <img src="{{ asset('images/logo/logo.svg') }}" alt="logo">
            </div>
            <div class="md:flex-1 w-full">
                <form action="/products" method="get" class="flex items-center gap-2">
                    <input type="text" name="search" class="w-full border py-2 rounded-lg bg-gray-100 px-4 text-sm"
                        placeholder="{{ __('search_placeholder') }}" value="{{ request('search') }}">
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg ml-2 text-sm">{{ __('search_placeholder') }}</button>
                </form>
            </div>
            <div class="md:w-2/12 w-full flex items-center justify-center space-x-2">
                <div class="text-sm">
                    <a href="#">{{ __('my_account') }}</a>
                </div>
                <div class="border border-slate-100 h-4"></div>
                <a href="{{ url('/cart') }}" class="relative">
                    <i class="fa-solid fa-basket-shopping text-xl text-gray-500"></i>
                    <div class="cart-count absolute top-0 left-3 border p-2 rounded-full bg-primary text-white text-[10px] size-4 flex items-center justify-center"
                        style="display: none;">
                        0
                    </div>
                </a>
                <div class="border border-slate-100 h-4"></div>
                <a href="{{ url('/checkout') }}"
                    class="text-sm bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                    {{ __('checkout') }}
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white border-b flex md:flex-row flex-col items-center justify-between px-4">
        <div class="flex justify-center space-x-4 uppercase ">
            <a href="{{ url('/products') }}" class="text-sm text-gray-500 hover:bg-hover p-2">{{ __('products') }}</a>
            <a href="{{ route('categories') }}"
                class="text-sm text-gray-500 hover:bg-hover p-2">{{ __('categories') }}</a>
            <a href="{{ route('services') }}"
                class="text-sm text-gray-500 hover:bg-hover p-2">{{ __('services') }}</a>
            <a href="{{ route('blog.index') }}"
                class="text-sm text-gray-500 hover:bg-hover p-2">{{ __('Blog') }}</a>
            <a href="{{ url('/contact-us') }}"
                class="text-sm text-gray-500 hover:bg-hover p-2">{{ __('contact') }}</a>
            <a href="{{ route('track.order') }}"
                class="text-sm text-gray-500 hover:bg-hover p-2">{{ __('track_order') }}</a>
            <a href="{{ route('news') }}" class="text-sm text-gray-500 hover:bg-hover p-2">{{ __('news') }}</a>
        </div>
        <div class="md:hidden border-b h-2 w-full"></div>
    </div>
</div>
