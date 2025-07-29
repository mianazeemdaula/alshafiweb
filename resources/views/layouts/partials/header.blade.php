<div
    class="border-b p-2 flex items-center justify-between text-sm flex-col sm:flex-row bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-700">
    <div class="flex space-x-2 items-center mb-2 sm:mb-0">
        <div class="flex items-center text-gray-700 dark:text-gray-300">
            <i class="fa-regular fa-envelope mx-1"></i>
            <div class="hidden sm:block">info@alshafionline.com</div>
        </div>
        <div class="border border-slate-100 dark:border-gray-700 h-4 hidden sm:block"></div>
        <div class="flex items-center text-gray-700 dark:text-gray-300">
            <i class="fa fa-phone mx-1"></i>
            <div class="hidden sm:block">Helpline 4534345656</div>
        </div>
    </div>
    <div class="flex space-x-2 items-center">
        <!-- Country/Language Selector and Theme Toggle -->
        <div class="flex items-center space-x-2">
            <select id="country-selector"
                class="text-xs border rounded px-2 py-1 bg-white dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                @foreach ($availableCountries as $code => $country)
                    <option value="{{ $code }}" {{ $currentCountry == $code ? 'selected' : '' }}>
                        {{ $country['name'] }}
                    </option>
                @endforeach
            </select>
            <select id="locale-selector"
                class="text-xs border rounded px-2 py-1 bg-white dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                @foreach ($availableLocales as $code => $locale)
                    <option value="{{ $code }}" {{ $currentLocale == $code ? 'selected' : '' }}>
                        {{ $locale['flag'] }} {{ $locale['name'] }}
                    </option>
                @endforeach
            </select>
            @if (isset($currentCurrency))
                <span
                    class="text-xs bg-gray-100 dark:bg-gray-700 dark:text-gray-300 px-2 py-1 rounded">{{ $currentCurrency }}</span>
            @endif
            <!-- Theme Toggle Button -->
            <button class="theme-toggle" title="{{ __('Toggle Theme') }}" aria-label="{{ __('Toggle Theme') }}">
                <i class="fa-solid fa-moon text-sm"></i>
            </button>
        </div>
        <div class="border border-slate-100 dark:border-gray-700 h-4 hidden sm:block"></div>

        @auth
            <!-- Authenticated User Menu -->
            <div class="relative group">
                <button
                    class="flex items-center text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                    <i class="fa fa-user mx-1"></i>
                    <div class="hidden sm:block">{{ auth()->user()->name }}</div>
                    <i class="fa fa-chevron-down ml-1 text-xs"></i>
                </button>

                <!-- Dropdown Menu -->
                <div
                    class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                    @if (auth()->user()->hasRole('admin'))
                        <a href="{{ route('dashboard') }}"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fa fa-tachometer-alt mr-2"></i>Admin Dashboard
                        </a>
                    @endif

                    @if (auth()->user()->hasRole('user'))
                        <a href="{{ route('user.dashboard') }}"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fa fa-tachometer-alt mr-2"></i>My Dashboard
                        </a>
                        <a href="{{ route('user.profile.show') }}"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fa fa-user mr-2"></i>My Profile
                        </a>
                        <a href="{{ route('user.orders.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fa fa-shopping-bag mr-2"></i>My Orders
                        </a>
                        <a href="{{ route('user.reviews.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fa fa-star mr-2"></i>My Reviews
                        </a>
                    @endif

                    <div class="border-t border-gray-200 dark:border-gray-600 my-1"></div>
                    <form action="/logout" method="POST" class="block">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fa fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        @else
            <!-- Guest User Links -->
            <a href="{{ url('/login') }}"
                class="flex items-center text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                <i class="fa fa-user-lock mx-1"></i>
                <div class="hidden sm:block">{{ __('login.title') }}</div>
            </a>
            {{-- <div class="border border-slate-100 dark:border-gray-700 h-4 hidden sm:block"></div>
            <a href="{{ url('/register') }}"
                class="flex items-center text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                <i class="fa fa-user-plus mx-1"></i>
                <div class="hidden sm:block">{{ __('register.title') }}</div>
            </a> --}}
        @endauth
    </div>
</div>
<div class="bg-white dark:bg-gray-900 w-full z-50" id="header">
    <div class="p-2 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-col lg:flex-row items-center gap-4">
            <div class="w-full lg:w-2/12 flex justify-center lg:justify-start">
                <img src="{{ asset('images/logo/logo.svg') }}" alt="logo"
                    class="h-8 dark:filter dark:brightness-0 dark:invert">
            </div>
            <div class="w-full lg:flex-1">
                <form action="/products" method="get" class="flex items-center gap-2">
                    <input type="text" name="search"
                        class="w-full border py-2 rounded-lg bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-white px-4 text-sm"
                        placeholder="{{ __('search_placeholder') }}" value="{{ request('search') }}">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-4 py-2 rounded-lg whitespace-nowrap text-sm transition-colors">
                        <i class="fa fa-search lg:hidden"></i>
                        <span class="hidden lg:inline">{{ __('search_placeholder') }}</span>
                    </button>
                </form>
            </div>
            <div class="w-full lg:w-2/12 flex items-center justify-center space-x-2">

                <div class="border border-slate-100 dark:border-gray-700 h-4 hidden lg:block"></div>
                <a href="{{ url('/cart') }}" class="relative">
                    <i
                        class="fa-solid fa-basket-shopping text-xl text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"></i>
                    <div class="cart-count absolute -top-2 -right-2 border p-2 rounded-full bg-primary text-white text-[10px] size-4 flex items-center justify-center"
                        style="display: none;">
                        0
                    </div>
                </a>
                <div class="border border-slate-100 dark:border-gray-700 h-4"></div>
                <a href="{{ url('/checkout') }}"
                    class="text-sm bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 text-white px-3 py-2 rounded transition-colors">
                    <i class="fa fa-shopping-cart lg:hidden"></i>
                    <span class="hidden lg:inline">{{ __('checkout') }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
        <div class="px-4">
            <!-- Mobile Menu Button -->
            <div class="lg:hidden flex items-center justify-between py-2">
                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Menu') }}</span>
                <button id="mobile-menu-toggle"
                    class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                    <i class="fa fa-bars text-xl"></i>
                </button>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex justify-center space-x-4 py-2">
                <a href="{{ url('/') }}"
                    class="text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors uppercase">{{ __('Home') }}</a>
                <a href="{{ url('/products') }}"
                    class="text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors uppercase">{{ __('products') }}</a>
                <a href="{{ route('categories') }}"
                    class="text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors uppercase">{{ __('categories') }}</a>
                <a href="{{ route('services') }}"
                    class="text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors uppercase">{{ __('services') }}</a>
                <a href="{{ route('blog.index') }}"
                    class="text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors uppercase">{{ __('Blog') }}</a>
                <a href="{{ url('/contact-us') }}"
                    class="text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors uppercase">{{ __('contact') }}</a>
                <a href="{{ route('track.order') }}"
                    class="text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors uppercase">{{ __('track_order') }}</a>
                <a href="{{ route('news') }}"
                    class="text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors uppercase">{{ __('news') }}</a>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="lg:hidden hidden">
                <div class="py-2 space-y-1">
                    <a href="{{ url('/') }}"
                        class="block text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors uppercase">{{ __('Home') }}</a>
                    <a href="{{ url('/products') }}"
                        class="block text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors uppercase">{{ __('products') }}</a>
                    <a href="{{ route('categories') }}"
                        class="block text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors uppercase">{{ __('categories') }}</a>
                    <a href="{{ route('services') }}"
                        class="block text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors uppercase">{{ __('services') }}</a>
                    <a href="{{ route('blog.index') }}"
                        class="block text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors uppercase">{{ __('Blog') }}</a>
                    <a href="{{ url('/contact-us') }}"
                        class="block text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors uppercase">{{ __('contact') }}</a>
                    <a href="{{ route('track.order') }}"
                        class="block text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors uppercase">{{ __('track_order') }}</a>
                    <a href="{{ route('news') }}"
                        class="block text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors uppercase">{{ __('news') }}</a>

                    <!-- Mobile-only links -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-2 mt-2">
                        @auth
                            <!-- Authenticated User Mobile Menu -->
                            @if (auth()->user()->hasRole('admin'))
                                <a href="{{ route('dashboard') }}"
                                    class="block text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors">
                                    <i class="fa fa-tachometer-alt mr-2"></i>Admin Dashboard
                                </a>
                            @endif

                            @if (auth()->user()->hasRole('user'))
                                <a href="{{ route('user.dashboard') }}"
                                    class="block text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors">
                                    <i class="fa fa-tachometer-alt mr-2"></i>My Dashboard
                                </a>
                                <a href="{{ route('user.profile.show') }}"
                                    class="block text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors">
                                    <i class="fa fa-user mr-2"></i>My Profile
                                </a>
                                <a href="{{ route('user.orders.index') }}"
                                    class="block text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors">
                                    <i class="fa fa-shopping-bag mr-2"></i>My Orders
                                </a>
                                <a href="{{ route('user.reviews.index') }}"
                                    class="block text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors">
                                    <i class="fa fa-star mr-2"></i>My Reviews
                                </a>
                            @endif

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-2 mt-2">
                                <span class="block text-xs text-gray-400 px-3 py-1">{{ auth()->user()->name }}</span>
                                <form action="/logout" method="POST" class="block">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors">
                                        <i class="fa fa-sign-out-alt mr-2"></i>{{ __('Logout') }}
                                    </button>
                                </form>
                            </div>
                        @else
                            <!-- Guest User Mobile Menu -->
                            <a href="#"
                                class="block text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors">
                                <i class="fa fa-user mr-2"></i>{{ __('my_account') }}
                            </a>
                            <a href="{{ url('/login') }}"
                                class="block text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors">
                                <i class="fa fa-user-lock mr-2"></i>{{ __('login.title') }}
                            </a>
                            {{-- <a href="{{ url('/register') }}"
                                class="block text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 px-3 py-2 rounded transition-colors">
                                <i class="fa fa-user-plus mr-2"></i>{{ __('register.title') }}
                            </a> --}}
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
