@if (auth()->check() && auth()->user()->hasRole('user'))
    <!-- User Navigation Bar -->
    <div class="bg-blue-600 text-white shadow-md">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- User Info -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-blue-200">{{ __('User Dashboard') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden md:flex space-x-6">
                    <a href="{{ route('user.dashboard') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('user.dashboard') ? 'bg-blue-700' : 'hover:bg-blue-500' }} transition-colors">
                        <i class="fas fa-tachometer-alt mr-1"></i>
                        {{ __('Dashboard') }}
                    </a>
                    <a href="{{ route('user.profile.show') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('user.profile.*') ? 'bg-blue-700' : 'hover:bg-blue-500' }} transition-colors">
                        <i class="fas fa-user mr-1"></i>
                        {{ __('Profile') }}
                    </a>
                    <a href="{{ route('user.orders.index') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('user.orders.*') ? 'bg-blue-700' : 'hover:bg-blue-500' }} transition-colors">
                        <i class="fas fa-shopping-bag mr-1"></i>
                        {{ __('Orders') }}
                    </a>
                    <a href="{{ route('user.reviews.index') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('user.reviews.*') ? 'bg-blue-700' : 'hover:bg-blue-500' }} transition-colors">
                        <i class="fas fa-star mr-1"></i>
                        {{ __('Reviews') }}
                    </a>
                    <a href="{{ route('user.referrals') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('user.referrals') ? 'bg-blue-700' : 'hover:bg-blue-500' }} transition-colors">
                        <i class="fas fa-users mr-1"></i>
                        {{ __('Referrals') }}
                    </a>
                </nav>

                <!-- Mobile menu button and logout -->
                <div class="flex items-center space-x-2">
                    <form action="/logout" method="POST" class="hidden md:block">
                        @csrf
                        <button type="submit"
                            class="px-3 py-2 rounded-md text-sm font-medium hover:bg-blue-500 transition-colors">
                            <i class="fas fa-sign-out-alt mr-1"></i>
                            Logout
                        </button>
                    </form>

                    <!-- Mobile menu button -->
                    <button class="md:hidden p-2 rounded-md hover:bg-blue-500" id="mobile-menu-btn">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div class="md:hidden hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1 border-t border-blue-500">
                    <a href="{{ route('user.dashboard') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('user.dashboard') ? 'bg-blue-700' : 'hover:bg-blue-500' }} transition-colors">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('user.profile.show') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('user.profile.*') ? 'bg-blue-700' : 'hover:bg-blue-500' }} transition-colors">
                        <i class="fas fa-user mr-2"></i>
                        Profile
                    </a>
                    <a href="{{ route('user.orders.index') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('user.orders.*') ? 'bg-blue-700' : 'hover:bg-blue-500' }} transition-colors">
                        <i class="fas fa-shopping-bag mr-2"></i>
                        Orders
                    </a>
                    <a href="{{ route('user.reviews.index') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('user.reviews.*') ? 'bg-blue-700' : 'hover:bg-blue-500' }} transition-colors">
                        <i class="fas fa-star mr-2"></i>
                        Reviews
                    </a>
                    <a href="{{ route('user.referrals') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('user.referrals') ? 'bg-blue-700' : 'hover:bg-blue-500' }} transition-colors">
                        <i class="fas fa-users mr-2"></i>
                        Referrals
                    </a>
                    <form action="/logout" method="POST" class="mt-4">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-3 py-2 rounded-md text-base font-medium hover:bg-blue-500 transition-colors">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
@endif
