<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Alshaafi Online</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js', 'resources/js/admin.js'])
    @yield('head')
    <!-- TikTok Pixel Code Start -->
    <script>
        ! function(w, d, t) {
            w.TiktokAnalyticsObject = t;
            var ttq = w[t] = w[t] || [];
            ttq.methods = ["page", "track", "identify", "instances", "debug", "on", "off", "once", "ready", "alias",
                "group", "enableCookie", "disableCookie", "holdConsent", "revokeConsent", "grantConsent"
            ], ttq.setAndDefer = function(t, e) {
                t[e] = function() {
                    t.push([e].concat(Array.prototype.slice.call(arguments, 0)))
                }
            };
            for (var i = 0; i < ttq.methods.length; i++) ttq.setAndDefer(ttq, ttq.methods[i]);
            ttq.instance = function(t) {
                for (
                    var e = ttq._i[t] || [], n = 0; n < ttq.methods.length; n++) ttq.setAndDefer(e, ttq.methods[n]);
                return e
            }, ttq.load = function(e, n) {
                var r = "https://analytics.tiktok.com/i18n/pixel/events.js",
                    o = n && n.partner;
                ttq._i = ttq._i || {}, ttq._i[e] = [], ttq._i[e]._u = r, ttq._t = ttq._t || {}, ttq._t[e] = +new Date,
                    ttq._o = ttq._o || {}, ttq._o[e] = n || {};
                n = document.createElement("script");
                n.type = "text/javascript", n.async = !0, n.src = r + "?sdkid=" + e + "&lib=" + t;
                e = document.getElementsByTagName("script")[0];
                e.parentNode.insertBefore(n, e)
            };


            ttq.load('D4GPE2RC77UEBGICS5O0');
            ttq.page();
        }(window, document, 'ttq');
    </script>
    <!-- TikTok Pixel Code End -->
</head>

<body class="{{ App::isLocale('ar') ? 'arabic-text' : '' }}">
    <div class="flex bg-gray-100 min-h-screen">
        <!-- Sidebar -->
        <div id="sidebar"
            class="lg:flex flex-col lg:relative fixed top-0 left-0 min-h-full bg-gray-800 text-white w-64 lg:w-56 xl:w-64 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-50">
            <div class="flex justify-between">
                <div class="p-4 font-bold text-lg">Admin Panel</div>
                <button class="p-4 lg:hidden" id="close-sidebar">✕</button>
            </div>
            <ul class="space-y-2 text-sm">
                <li class="p-2 hover:bg-gray-700  hover:animate-pulse">
                    <a href="{{ route('dashboard') }}" class="block"><i class="fa-solid fa-home mr-2"></i>
                        Dashboard</a>
                </li>

                @if (auth()->user()->hasRole('admin'))
                    <li
                        class="p-2 hover:bg-gray-700 hover:animate-pulse @if (request()->routeIs('admin.categories.*')) bg-green-500 @endif">
                        <a href="{{ route('admin.categories.index') }}" class="block"><i
                                class="fa-solid fa-share-alt mr-2"></i> Categories</a>
                    </li>
                    <li
                        class="p-2 hover:bg-gray-700 hover:animate-pulse @if (request()->routeIs('admin.products.*')) bg-green-500 @endif">
                        <a href="{{ route('admin.products.index') }}" class="block"><i
                                class="fa-solid fa-tag mr-2"></i>
                            Products</a>
                    </li>
                    <li
                        class="p-2 hover:bg-gray-700 hover:animate-pulse @if (request()->routeIs('admin.users.*')) bg-green-500 @endif">
                        <a href="{{ route('admin.users.index') }}" class="block"><i class="fa-solid fa-users mr-2"></i>
                            Users</a>
                    </li>
                    <li
                        class="p-2 hover:bg-gray-700 hover:animate-pulse @if (request()->routeIs('admin.teams.*')) bg-green-500 @endif">
                        <a href="{{ route('admin.teams.index') }}" class="block text-sm">
                            <i class="fa-solid fa-sitemap mr-2"></i>Team Structure
                        </a>
                    </li>
                    <li
                        class="p-2 hover:bg-gray-700 hover:animate-pulse @if (request()->routeIs('admin.levels.*')) bg-green-500 @endif">
                        <a href="{{ route('admin.levels.index') }}" class="block"><i
                                class="fa-solid fa-chart-line mr-2"></i> Levels</a>
                    </li>
                @endif

                {{-- @hasanyrole('admin|label_printer|order_taker|web_order_taker') --}}
                <li
                    class="p-2 hover:bg-gray-700 hover:animate-pulse @if (request()->routeIs('admin.orders.*')) bg-green-500 @endif">
                    <a href="{{ route('admin.orders.index') }}" class="block"><i
                            class="fa-solid fa-cart-shopping mr-2"></i> Orders</a>
                </li>
                {{-- @endhasanyrole --}}

                @if (auth()->user()->hasRole('admin'))
                    <li
                        class="p-2 hover:bg-gray-700 hover:animate-pulse @if (request()->routeIs('admin.news.*')) bg-green-500 @endif">
                        <a href="{{ route('admin.news.index') }}" class="block"><i
                                class="fa-solid fa-newspaper mr-2"></i>
                            News</a>
                    </li>
                    <li
                        class="p-2 hover:bg-gray-700 hover:animate-pulse @if (request()->routeIs('admin.suggestions.*')) bg-green-500 @endif">
                        <a href="{{ route('admin.suggestions.index') }}" class="block"><i
                                class="fa-solid fa-handshake-angle mr-2"></i> Suggestions</a>
                    </li>
                    <li
                        class="p-2 hover:bg-gray-700  hover:animate-pulse @if (request()->routeIs('admin.blog-categories.*')) bg-green-500 @endif">
                        <a href="{{ route('admin.blog-categories.index') }}" class="block"><i
                                class="fa-solid fa-folder mr-2"></i>
                            Blog Categories</a>
                    </li>
                    <li
                        class="p-2 hover:bg-gray-700  hover:animate-pulse @if (request()->routeIs('admin.posts.*')) bg-green-500 @endif">
                        <a href="{{ route('admin.posts.index') }}" class="block"><i class="fa-solid fa-blog mr-2"></i>
                            Blog</a>
                    </li>
                    <li
                        class="p-2 hover:bg-gray-700  hover:animate-pulse @if (request()->routeIs('admin.banners.*')) bg-green-500 @endif">
                        <a href="{{ route('admin.banners.index') }}" class="block"><i
                                class="fa-solid fa-image mr-2"></i>
                            Banners</a>
                    </li>
                    <li
                        class="p-2 hover:bg-gray-700  hover:animate-pulse @if (request()->routeIs('admin.couriers.*')) bg-green-500 @endif">
                        <a href="{{ route('admin.courier-services.index') }}" class="block"><i
                                class="fa-solid fa-truck mr-2"></i>
                            Courier Services</a>
                    </li>
                @endif

                @hasanyrole('admin|label_printer|order_taker|web_order_taker')
                    <li
                        class="p-2 hover:bg-gray-700  hover:animate-pulse @if (request()->routeIs('admin.shipments.*')) bg-green-500 @endif">
                        <a href="{{ route('admin.shipments.index') }}" class="block"><i
                                class="fa-solid fa-shipping-fast mr-2"></i>
                            Shipments</a>
                    </li>
                    <li
                        class="p-2 hover:bg-gray-700  hover:animate-pulse @if (request()->routeIs('admin.dashboard.shipments')) bg-green-500 @endif">
                        <a href="{{ route('admin.dashboard.shipments') }}" class="block"><i
                                class="fa-solid fa-chart-pie mr-2"></i>
                            Shipment Dashboard</a>
                    </li>
                @endhasanyrole

                <li class="p-2 hover:bg-gray-700  hover:animate-pulse">
                    <form action="{{ url('logout') }}" method="post">
                        @csrf
                        <button type="submit"><i class="fa-solid fa-sign-out mr-2"></i> Logout</button>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-0 min-w-0">
            <header class="bg-white shadow-md p-4 flex flex-row items-center justify-between print:hidden">
                <button id="menu-button" class="text-xl font-bold lg:hidden">☰</button>
                <h1 class="text-xl font-bold mb-2 sm:mb-0 hidden lg:block">Dashboard</h1>
                <div class="flex flex-wrap sm:flex-nowrap space-x-2 sm:space-x-4 items-center">
                    <div class="text-xs">
                        {{ auth()->user()->name }}
                    </div>
                    <div class="">
                        <img src="https://via.placeholder.com/640x480.png/002244?text=enim" alt=""
                            class="w-8 h-8 rounded-full">
                    </div>
                </div>
            </header>

            <main class="flex-1 p-2 sm:p-4 bg-gray-100 min-w-0 overflow-x-auto">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-2"
                        role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2"
                        role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.getElementById('menu-button').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
            } else {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
            }
        });
        // Close sidebar on mobile
        document.getElementById('close-sidebar').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
        });

        // Toggle Team Management submenu
        function toggleTeamMenu() {
            const submenu = document.getElementById('team-submenu');
            const icon = document.getElementById('team-menu-icon');
            if (submenu.classList.contains('hidden')) {
                submenu.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                submenu.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
    </script>
    @yield('js')
    @stack('scripts')
</body>

</html>
