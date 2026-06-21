<!-- Top Bar -->
<div
    class="bg-emerald-950 dark:bg-black py-2 px-4 flex items-center justify-between text-xs flex-col sm:flex-row gap-2 border-b border-emerald-900/40">
    <div class="flex space-x-4 items-center">
        <div class="flex items-center text-emerald-100/80 hover:text-white transition-colors">
            <i class="fa-regular fa-envelope mx-1"></i>
            <div class="hidden sm:block">info@alshafionline.com</div>
        </div>
        <div class="border-l border-white/10 h-4 hidden sm:block"></div>
        <div class="flex items-center text-emerald-100/80 hover:text-white transition-colors">
            <i class="fa fa-phone mx-1"></i>
            <div class="hidden sm:block">Helpline +92 325 325 55 55</div>
        </div>
    </div>
    <div class="flex space-x-3 items-center">
        <!-- Theme Toggle and Account Menu -->
        <div class="flex items-center space-x-2">
            <!-- Theme Toggle Button -->
            <button
                class="theme-toggle w-9 h-9 flex items-center justify-center rounded-xl bg-white/10 hover:bg-white/20 text-white border-0 transition-all cursor-pointer p-0"
                title="{{ __('Toggle Theme') }}" aria-label="{{ __('Toggle Theme') }}">
                <i class="fa-solid fa-moon text-sm"></i>
            </button>
        </div>
        <div class="border-l border-white/10 h-4 hidden sm:block"></div>

        @auth
            <!-- Authenticated User Menu -->
            <div class="relative group">
                <button
                    class="flex items-center text-white hover:text-gray-100 transition-colors bg-white/10 px-3 py-1.5 rounded-lg hover:bg-white/20">
                    <i class="fa fa-user mx-1"></i>
                    <div class="hidden sm:block font-medium">{{ auth()->user()->name }}</div>
                    <i class="fa fa-chevron-down ml-1 text-xs"></i>
                </button>

                <!-- Dropdown Menu -->
                <div
                    class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-2xl py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform group-hover:translate-y-0 -translate-y-2">
                    @if (auth()->user()->hasRole('admin'))
                        <a href="{{ route('dashboard') }}"
                            class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-emerald-50 dark:hover:bg-gray-700 transition-all">
                            <i class="fa fa-tachometer-alt mr-2 text-emerald-600"></i>Admin Dashboard
                        </a>
                    @endif

                    @if (auth()->user()->hasRole('user'))
                        <a href="{{ route('user.dashboard') }}"
                            class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-emerald-50 dark:hover:bg-gray-700 transition-all">
                            <i class="fa fa-tachometer-alt mr-2 text-emerald-600"></i>My Dashboard
                        </a>
                        <a href="{{ route('user.profile.show') }}"
                            class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-emerald-50 dark:hover:bg-gray-700 transition-all">
                            <i class="fa fa-user mr-2 text-emerald-600"></i>My Profile
                        </a>
                        <a href="{{ route('user.orders.index') }}"
                            class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-emerald-50 dark:hover:bg-gray-700 transition-all">
                            <i class="fa fa-shopping-bag mr-2 text-emerald-600"></i>My Orders
                        </a>
                        <a href="{{ route('user.reviews.index') }}"
                            class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-emerald-50 dark:hover:bg-gray-700 transition-all">
                            <i class="fa fa-star mr-2 text-amber-500"></i>My Reviews
                        </a>
                    @endif

                    <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                    <form action="/logout" method="POST" class="block">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-gray-700 transition-all font-medium">
                            <i class="fa fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        @else
            <!-- Guest User Links -->
            <a href="{{ url('/login') }}"
                class="flex items-center text-white hover:text-gray-100 transition-colors bg-white/10 px-3 py-1.5 rounded-lg hover:bg-white/20">
                <i class="fa fa-user-lock mx-1"></i>
                <div class="hidden sm:block font-medium">{{ __('login.title') }}</div>
            </a>
        @endauth
    </div>
</div>
<!-- Main Header with Glass Effect -->
<div class="bg-white/95 dark:bg-gray-900/95 backdrop-blur-md w-full z-30 sticky top-0 shadow-lg" id="header">
    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-col lg:flex-row items-center gap-4">
            <div class="w-full lg:w-auto flex justify-center lg:justify-start">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                    <span
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-600 to-teal-700 flex items-center justify-center shadow-lg shadow-emerald-700/20 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-leaf text-white text-lg"></i>
                    </span>
                    <span class="leading-none">
                        <span class="block text-xl font-extrabold tracking-tight text-gray-900 dark:text-white" style="font-family: 'Playfair Display', serif;">
                            alshaafi<span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-600">online</span>
                        </span>
                        <span
                            class="block text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-700/60 dark:text-emerald-500/60">{{ __('Health & Wellness') }}</span>
                    </span>
                </a>
            </div>
            <div class="w-full lg:flex-1">
                <form action="/products" method="get" class="flex items-center gap-2">
                    <div class="relative w-full">
                        <input type="text" name="search"
                            class="w-full h-10 border border-emerald-900/10 dark:border-emerald-800/40 bg-[#f6f3eb]/40 dark:bg-emerald-950/20 px-4 rounded-xl text-xs text-emerald-955 dark:text-gray-150 placeholder-emerald-955/30 dark:placeholder-emerald-400/30 focus:outline-none focus:ring-4 focus:ring-emerald-100 dark:focus:ring-emerald-950/30 focus:border-emerald-600 transition-all"
                            placeholder="{{ __('search_placeholder') }}" value="{{ request('search') }}">
                        <i class="fa fa-search absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    </div>
                    <button type="submit"
                        class="h-10 bg-emerald-700 hover:bg-emerald-800 dark:bg-emerald-600 dark:hover:bg-emerald-500 text-white px-5 rounded-xl whitespace-nowrap text-xs font-bold transition-all shadow-sm flex items-center justify-center cursor-pointer">
                        <i class="fa fa-search lg:hidden"></i>
                        <span class="hidden lg:inline">{{ __('search_placeholder') }}</span>
                    </button>
                </form>
            </div>
            <div class="w-full lg:w-auto flex items-center justify-center space-x-3">
                <div class="border border-slate-200 dark:border-gray-700 h-8 hidden lg:block"></div>
                <a href="{{ url('/cart') }}" class="relative group">
                    <div
                        class="h-10 w-10 flex items-center justify-center rounded-xl bg-[#f6f3eb]/45 hover:bg-[#e5e0d4]/65 dark:bg-emerald-950/20 dark:hover:bg-emerald-900/40 border border-emerald-900/10 dark:border-emerald-800/40 text-emerald-700 dark:text-emerald-400 transition-all">
                        <i class="fa-solid fa-basket-shopping text-base"></i>
                        <div class="cart-count absolute -top-2 -right-2 border-2 border-white dark:border-gray-900 w-5 h-5 p-0 flex items-center justify-center rounded-full bg-red-500 text-white text-[10px] font-bold"
                            style="display: none;">
                            0
                        </div>
                    </div>
                </a>
                <div class="border border-slate-200 dark:border-gray-700 h-8"></div>
                <a href="{{ url('/checkout') }}"
                    class="h-10 px-4 text-xs font-bold flex items-center justify-center rounded-xl bg-emerald-700 hover:bg-emerald-800 dark:bg-emerald-600 dark:hover:bg-emerald-500 transition-all text-white shadow-sm cursor-pointer">
                    <i class="fa fa-shopping-cart lg:hidden"></i>
                    <span class="hidden lg:inline">{{ __('checkout') }}</span>
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
                    class="text-sm font-bold text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-600">{{ __('Menu') }}</span>
                <button id="mobile-menu-toggle"
                    class="text-gray-500 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                    <i class="fa fa-bars text-2xl"></i>
                </button>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex justify-center space-x-1 py-3">
                <a href="{{ url('/') }}"
                    class="relative text-sm text-gray-700 dark:text-gray-300 hover:text-emerald-700 dark:hover:text-emerald-400 px-4 py-2 rounded-lg transition-all font-semibold group">
                    {{ __('Home') }}
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-emerald-600 to-teal-500 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="{{ url('/products') }}"
                    class="relative text-sm text-gray-700 dark:text-gray-300 hover:text-emerald-700 dark:hover:text-emerald-400 px-4 py-2 rounded-lg transition-all font-semibold group">
                    {{ __('products') }}
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-emerald-600 to-teal-500 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="{{ route('categories') }}"
                    class="relative text-sm text-gray-700 dark:text-gray-300 hover:text-emerald-700 dark:hover:text-emerald-400 px-4 py-2 rounded-lg transition-all font-semibold group">
                    {{ __('categories') }}
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-emerald-600 to-teal-500 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="{{ route('blog.index') }}"
                    class="relative text-sm text-gray-700 dark:text-gray-300 hover:text-emerald-700 dark:hover:text-emerald-400 px-4 py-2 rounded-lg transition-all font-semibold group">
                    {{ __('Blog') }}
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-emerald-600 to-teal-500 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="{{ url('/contact-us') }}"
                    class="relative text-sm text-gray-700 dark:text-gray-300 hover:text-emerald-700 dark:hover:text-emerald-400 px-4 py-2 rounded-lg transition-all font-semibold group">
                    {{ __('contact') }}
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-emerald-600 to-teal-500 group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu"
                class="lg:hidden hidden bg-gradient-to-b from-white to-gray-50 dark:from-gray-900 dark:to-gray-800 rounded-b-2xl shadow-xl border-t border-gray-100 dark:border-gray-800">
                <div class="py-3 space-y-1">
                    <a href="{{ url('/') }}"
                        class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 px-4 py-3 rounded-lg transition-all font-semibold mx-2">
                        <i class="fa fa-home mr-2 text-emerald-600"></i>{{ __('Home') }}
                    </a>
                    <a href="{{ url('/products') }}"
                        class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 px-4 py-3 rounded-lg transition-all font-semibold mx-2">
                        <i class="fa fa-box mr-2 text-emerald-600"></i>{{ __('products') }}
                    </a>
                    <a href="{{ route('categories') }}"
                        class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 px-4 py-3 rounded-lg transition-all font-semibold mx-2">
                        <i class="fa fa-th-large mr-2 text-emerald-600"></i>{{ __('categories') }}
                    </a>
                    <a href="{{ route('blog.index') }}"
                        class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 px-4 py-3 rounded-lg transition-all font-semibold mx-2">
                        <i class="fa fa-newspaper mr-2 text-emerald-600"></i>{{ __('Blog') }}
                    </a>
                    <a href="{{ url('/contact-us') }}"
                        class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 px-4 py-3 rounded-lg transition-all font-semibold mx-2">
                        <i class="fa fa-envelope mr-2 text-emerald-600"></i>{{ __('contact') }}
                    </a>

                    <!-- Mobile-only links -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-3 mt-3 mx-2">
                        @auth
                            <!-- Authenticated User Mobile Menu -->
                            <div
                                class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-950/20 dark:to-teal-950/20 rounded-lg p-3 mb-3">
                                <span class="block text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Logged in
                                    as</span>
                                <span
                                    class="block text-sm font-bold text-gray-900 dark:text-white">{{ auth()->user()->name }}</span>
                            </div>

                            @if (auth()->user()->hasRole('admin'))
                                <a href="{{ route('dashboard') }}"
                                    class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 px-4 py-3 rounded-lg transition-all font-semibold">
                                    <i class="fa fa-tachometer-alt mr-2 text-emerald-600"></i>Admin Dashboard
                                </a>
                            @endif

                            @if (auth()->user()->hasRole('user'))
                                <a href="{{ route('user.dashboard') }}"
                                    class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 px-4 py-3 rounded-lg transition-all font-semibold">
                                    <i class="fa fa-tachometer-alt mr-2 text-emerald-600"></i>My Dashboard
                                </a>
                                <a href="{{ route('user.profile.show') }}"
                                    class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 px-4 py-3 rounded-lg transition-all font-semibold">
                                    <i class="fa fa-user mr-2 text-emerald-600"></i>My Profile
                                </a>
                                <a href="{{ route('user.orders.index') }}"
                                    class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 px-4 py-3 rounded-lg transition-all font-semibold">
                                    <i class="fa fa-shopping-bag mr-2 text-emerald-600"></i>My Orders
                                </a>
                                <a href="{{ route('user.reviews.index') }}"
                                    class="block text-sm text-gray-700 dark:text-gray-300 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 px-4 py-3 rounded-lg transition-all font-semibold">
                                    <i class="fa fa-star mr-2 text-amber-500"></i>My Reviews
                                </a>
                            @endif

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-3 mt-3">
                                <form action="/logout" method="POST" class="block">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-emerald-950/30 px-4 py-3 rounded-lg transition-all font-bold">
                                        <i class="fa fa-sign-out-alt mr-2"></i>{{ __('Logout') }}
                                    </button>
                                </form>
                            </div>
                        @else
                            <!-- Guest User Mobile Menu -->
                            <a href="{{ url('/login') }}"
                                class="block text-center text-sm text-white bg-gradient-to-r from-emerald-600 to-teal-700 hover:from-emerald-700 hover:to-teal-800 px-4 py-3 rounded-lg transition-all font-bold shadow-lg mx-2">
                                <i class="fa fa-user-lock mr-2"></i>{{ __('login.title') }}
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
