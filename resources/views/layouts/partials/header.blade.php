<!-- Top Bar with Gradient -->
<div
    class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 p-2 flex items-center justify-between text-sm flex-col sm:flex-row">
    <div class="flex space-x-4 items-center mb-2 sm:mb-0">
        <div class="flex items-center text-white hover:text-gray-100 transition-colors">
            <i class="fa-regular fa-envelope mx-1 animate-pulse"></i>
            <div class="hidden sm:block font-medium">info@alshafionline.com</div>
        </div>
        <div class="border border-white/30 h-4 hidden sm:block"></div>
        <div class="flex items-center text-white hover:text-gray-100 transition-colors">
            <i class="fa fa-phone mx-1 animate-pulse"></i>
            <div class="hidden sm:block font-medium">Helpline +92 325 325 55 55</div>
        </div>
    </div>
    <div class="flex space-x-3 items-center">
        <!-- Country/Language Selector and Theme Toggle -->
        <div class="flex items-center space-x-2">
            <select id="country-selector"
                class="text-xs border-0 rounded-lg px-3 py-1.5 bg-white/20 backdrop-blur-sm text-white font-medium focus:ring-2 focus:ring-white/50 transition-all">
                @foreach ($availableCountries as $code => $country)
                    <option value="{{ $code }}" {{ $currentCountry == $code ? 'selected' : '' }}
                        class="text-gray-900">
                        {{ $country['name'] }}
                    </option>
                @endforeach
            </select>
            <select id="locale-selector"
                class="text-xs border-0 rounded-lg px-3 py-1.5 bg-white/20 backdrop-blur-sm text-white font-medium focus:ring-2 focus:ring-white/50 transition-all">
                @foreach ($availableLocales as $code => $locale)
                    <option value="{{ $code }}" {{ $currentLocale == $code ? 'selected' : '' }}
                        class="text-gray-900">
                        {{ $locale['flag'] }} {{ $locale['name'] }}
                    </option>
                @endforeach
            </select>
            @if (isset($currentCurrency))
                <span
                    class="text-xs bg-white/20 backdrop-blur-sm text-white font-bold px-3 py-1.5 rounded-lg">{{ $currentCurrency }}</span>
            @endif
            <!-- Theme Toggle Button -->
            <button
                class="theme-toggle bg-white/20 backdrop-blur-sm px-3 py-1.5 rounded-lg hover:bg-white/30 transition-all"
                title="{{ __('Toggle Theme') }}" aria-label="{{ __('Toggle Theme') }}">
                <i class="fa-solid fa-moon text-sm text-white"></i>
            </button>
        </div>
        <div class="border border-white/30 h-4 hidden sm:block"></div>

        @auth
            <!-- Authenticated User Menu -->
            <div class="relative group">
                <button
                    class="flex items-center text-white hover:text-gray-100 transition-colors bg-white/20 backdrop-blur-sm px-3 py-1.5 rounded-lg hover:bg-white/30">
                    <i class="fa fa-user mx-1"></i>
                    <div class="hidden sm:block font-medium">{{ auth()->user()->name }}</div>
                    <i class="fa fa-chevron-down ml-1 text-xs"></i>
                </button>

                <!-- Dropdown Menu -->
                <div
                    class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-2xl py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform group-hover:translate-y-0 -translate-y-2">
                    @if (auth()->user()->hasRole('admin'))
                        <a href="{{ route('dashboard') }}"
                            class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-700 dark:hover:to-gray-600 transition-all">
                            <i class="fa fa-tachometer-alt mr-2 text-blue-600"></i>Admin Dashboard
                        </a>
                    @endif

                    @if (auth()->user()->hasRole('user'))
                        <a href="{{ route('user.dashboard') }}"
                            class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-700 dark:hover:to-gray-600 transition-all">
                            <i class="fa fa-tachometer-alt mr-2 text-blue-600"></i>My Dashboard
                        </a>
                        <a href="{{ route('user.profile.show') }}"
                            class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-700 dark:hover:to-gray-600 transition-all">
                            <i class="fa fa-user mr-2 text-purple-600"></i>My Profile
                        </a>
                        <a href="{{ route('user.orders.index') }}"
                            class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-700 dark:hover:to-gray-600 transition-all">
                            <i class="fa fa-shopping-bag mr-2 text-green-600"></i>My Orders
                        </a>
                        <a href="{{ route('user.reviews.index') }}"
                            class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-700 dark:hover:to-gray-600 transition-all">
                            <i class="fa fa-star mr-2 text-yellow-600"></i>My Reviews
                        </a>
                    @endif

                    <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                    <form action="/logout" method="POST" class="block">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 dark:hover:from-gray-700 dark:hover:to-gray-600 transition-all font-medium">
                            <i class="fa fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        @else
            <!-- Guest User Links -->
            <a href="{{ url('/login') }}"
                class="flex items-center text-white hover:text-gray-100 transition-colors bg-white/20 backdrop-blur-sm px-3 py-1.5 rounded-lg hover:bg-white/30">
                <i class="fa fa-user-lock mx-1"></i>
                <div class="hidden sm:block font-medium">{{ __('login.title') }}</div>
            </a>
        @endauth
    </div>
</div>
<!-- Main Header with Glass Effect -->
<div class="bg-white/95 dark:bg-gray-900/95 backdrop-blur-md w-full z-50 sticky top-0 shadow-lg" id="header">
    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-col lg:flex-row items-center gap-4">
            <div class="w-full lg:w-2/12 flex justify-center lg:justify-start">
                {{-- <img src="{{ asset('images/logo/logo.svg') }}" alt="logo"
                    class="h-10 dark:filter dark:brightness-0 dark:invert transition-transform hover:scale-105"> --}}
                <span class="text-lg font-semibold">Alshaafi</span>
            </div>
            <div class="w-full lg:flex-1">
                <form action="/products" method="get" class="flex items-center gap-2">
                    <div class="relative w-full">
                        <input type="text" name="search"
                            class="w-full border-2 border-gray-200 dark:border-gray-600 py-3 rounded-xl bg-gray-50 dark:bg-gray-800 dark:text-white px-5 text-sm focus:ring-4 focus:ring-blue-100 dark:focus:ring-blue-900 focus:border-blue-500 transition-all"
                            placeholder="{{ __('search_placeholder') }}" value="{{ request('search') }}">
                        <i class="fa fa-search absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl whitespace-nowrap text-sm transition-all transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <i class="fa fa-search lg:hidden"></i>
                        <span class="hidden lg:inline font-medium">{{ __('search_placeholder') }}</span>
                    </button>
                </form>
            </div>
            <div class="w-full lg:w-auto flex items-center justify-center space-x-3">
                <div class="border border-slate-200 dark:border-gray-700 h-8 hidden lg:block"></div>
                <a href="{{ url('/cart') }}" class="relative group">
                    <div
                        class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-gray-800 dark:to-gray-700 p-3 rounded-xl hover:shadow-lg transition-all transform hover:scale-110">
                        <i class="fa-solid fa-basket-shopping text-xl text-blue-600 dark:text-blue-400"></i>
                        <div class="cart-count absolute -top-2 -right-2 border-2 border-white dark:border-gray-900 p-2 rounded-full bg-gradient-to-r from-red-500 to-pink-500 text-white text-[10px] size-5 flex items-center justify-center font-bold shadow-lg"
                            style="display: none;">
                            0
                        </div>
                    </div>
                </a>
                <div class="border border-slate-200 dark:border-gray-700 h-8"></div>
                <a href="{{ url('/checkout') }}"
                    class="text-sm bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-5 py-3 rounded-xl transition-all transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <i class="fa fa-shopping-cart lg:hidden"></i>
                    <span class="hidden lg:inline font-medium">{{ __('checkout') }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation Menu with Gradient Underline -->
    <div class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
        <div class="px-4">
            <!-- Mobile Menu Button -->
            <div class="lg:hidden flex items-center justify-between py-3">
                <span
                    class="text-sm font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">{{ __('Menu') }}</span>
                <button id="mobile-menu-toggle"
                    class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    <i class="fa fa-bars text-2xl"></i>
                </button>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex justify-center space-x-1 py-3">
                <a href="{{ url('/') }}"
                    class="relative text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-4 py-2 rounded-lg transition-all font-medium group">
                    {{ __('Home') }}
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="{{ url('/products') }}"
                    class="relative text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-4 py-2 rounded-lg transition-all font-medium group">
                    {{ __('products') }}
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="{{ route('categories') }}"
                    class="relative text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-4 py-2 rounded-lg transition-all font-medium group">
                    {{ __('categories') }}
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="{{ route('services') }}"
                    class="relative text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-4 py-2 rounded-lg transition-all font-medium group">
                    {{ __('services') }}
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="{{ route('blog.index') }}"
                    class="relative text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-4 py-2 rounded-lg transition-all font-medium group">
                    {{ __('Blog') }}
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="{{ url('/contact-us') }}"
                    class="relative text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-4 py-2 rounded-lg transition-all font-medium group">
                    {{ __('contact') }}
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="{{ route('track.order') }}"
                    class="relative text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-4 py-2 rounded-lg transition-all font-medium group">
                    {{ __('track_order') }}
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="{{ route('news') }}"
                    class="relative text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-4 py-2 rounded-lg transition-all font-medium group">
                    {{ __('news') }}
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu"
                class="lg:hidden hidden bg-gradient-to-b from-white to-gray-50 dark:from-gray-900 dark:to-gray-800 rounded-b-2xl shadow-xl">
                <div class="py-3 space-y-1">
                    <a href="{{ url('/') }}"
                        class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-800 dark:hover:to-gray-700 px-4 py-3 rounded-lg transition-all font-medium mx-2">
                        <i class="fa fa-home mr-2 text-blue-600"></i>{{ __('Home') }}
                    </a>
                    <a href="{{ url('/products') }}"
                        class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-800 dark:hover:to-gray-700 px-4 py-3 rounded-lg transition-all font-medium mx-2">
                        <i class="fa fa-box mr-2 text-purple-600"></i>{{ __('products') }}
                    </a>
                    <a href="{{ route('categories') }}"
                        class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-800 dark:hover:to-gray-700 px-4 py-3 rounded-lg transition-all font-medium mx-2">
                        <i class="fa fa-th-large mr-2 text-pink-600"></i>{{ __('categories') }}
                    </a>
                    <a href="{{ route('services') }}"
                        class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-800 dark:hover:to-gray-700 px-4 py-3 rounded-lg transition-all font-medium mx-2">
                        <i class="fa fa-concierge-bell mr-2 text-green-600"></i>{{ __('services') }}
                    </a>
                    <a href="{{ route('blog.index') }}"
                        class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-800 dark:hover:to-gray-700 px-4 py-3 rounded-lg transition-all font-medium mx-2">
                        <i class="fa fa-newspaper mr-2 text-yellow-600"></i>{{ __('Blog') }}
                    </a>
                    <a href="{{ url('/contact-us') }}"
                        class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-800 dark:hover:to-gray-700 px-4 py-3 rounded-lg transition-all font-medium mx-2">
                        <i class="fa fa-envelope mr-2 text-red-600"></i>{{ __('contact') }}
                    </a>
                    <a href="{{ route('track.order') }}"
                        class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-800 dark:hover:to-gray-700 px-4 py-3 rounded-lg transition-all font-medium mx-2">
                        <i class="fa fa-map-marker-alt mr-2 text-indigo-600"></i>{{ __('track_order') }}
                    </a>
                    <a href="{{ route('news') }}"
                        class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-800 dark:hover:to-gray-700 px-4 py-3 rounded-lg transition-all font-medium mx-2">
                        <i class="fa fa-bullhorn mr-2 text-orange-600"></i>{{ __('news') }}
                    </a>

                    <!-- Mobile-only links -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-3 mt-3 mx-2">
                        @auth
                            <!-- Authenticated User Mobile Menu -->
                            <div
                                class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-gray-800 dark:to-gray-700 rounded-lg p-3 mb-3">
                                <span class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Logged in
                                    as</span>
                                <span
                                    class="block text-sm font-bold text-gray-900 dark:text-white">{{ auth()->user()->name }}</span>
                            </div>

                            @if (auth()->user()->hasRole('admin'))
                                <a href="{{ route('dashboard') }}"
                                    class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-800 dark:hover:to-gray-700 px-4 py-3 rounded-lg transition-all font-medium">
                                    <i class="fa fa-tachometer-alt mr-2 text-blue-600"></i>Admin Dashboard
                                </a>
                            @endif

                            @if (auth()->user()->hasRole('user'))
                                <a href="{{ route('user.dashboard') }}"
                                    class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-800 dark:hover:to-gray-700 px-4 py-3 rounded-lg transition-all font-medium">
                                    <i class="fa fa-tachometer-alt mr-2 text-blue-600"></i>My Dashboard
                                </a>
                                <a href="{{ route('user.profile.show') }}"
                                    class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-800 dark:hover:to-gray-700 px-4 py-3 rounded-lg transition-all font-medium">
                                    <i class="fa fa-user mr-2 text-purple-600"></i>My Profile
                                </a>
                                <a href="{{ route('user.orders.index') }}"
                                    class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-800 dark:hover:to-gray-700 px-4 py-3 rounded-lg transition-all font-medium">
                                    <i class="fa fa-shopping-bag mr-2 text-green-600"></i>My Orders
                                </a>
                                <a href="{{ route('user.reviews.index') }}"
                                    class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-800 dark:hover:to-gray-700 px-4 py-3 rounded-lg transition-all font-medium">
                                    <i class="fa fa-star mr-2 text-yellow-600"></i>My Reviews
                                </a>
                            @endif

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-3 mt-3">
                                <form action="/logout" method="POST" class="block">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left text-sm text-red-600 dark:text-red-400 hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 dark:hover:from-gray-800 dark:hover:to-gray-700 px-4 py-3 rounded-lg transition-all font-bold">
                                        <i class="fa fa-sign-out-alt mr-2"></i>{{ __('Logout') }}
                                    </button>
                                </form>
                            </div>
                        @else
                            <!-- Guest User Mobile Menu -->
                            <a href="#"
                                class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-800 dark:hover:to-gray-700 px-4 py-3 rounded-lg transition-all font-medium">
                                <i class="fa fa-user mr-2 text-blue-600"></i>{{ __('my_account') }}
                            </a>
                            <a href="{{ url('/login') }}"
                                class="block text-sm text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 px-4 py-3 rounded-lg transition-all font-bold shadow-lg">
                                <i class="fa fa-user-lock mr-2"></i>{{ __('login.title') }}
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
