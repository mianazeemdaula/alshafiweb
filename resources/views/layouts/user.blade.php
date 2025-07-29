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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('head')
</head>

<body class="{{ App::isLocale('ar') ? 'arabic-text' : '' }}">
    <div style="background-color: var(--bg-secondary); min-height: 100vh; display: flex;">
        <!-- Sidebar -->
        <div id="sidebar"
            class="fixed z-30 top-0 left-0 min-h-screen h-full w-64 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col"
            style="background-color: var(--bg-primary); border-right: 1px solid var(--border-color);">
            <div class="font-bold text-lg mb-6 p-4 flex items-center justify-between"
                style="color: var(--accent-blue); border-bottom: 1px solid var(--border-color);">
                User Dashboard
                <button class="lg:hidden text-gray-500 hover:text-gray-800" id="close-sidebar">✕</button>
                <button class="lg:hidden" id="close-sidebar" style="color: var(--text-secondary);">✕</button>
            </div>
            <ul class="space-y-1 flex-1 px-2 py-4">
                <li>
                    <a href="{{ route('user.dashboard') }}"
                        class="flex px-4 py-2 rounded items-center gap-2 transition-colors"
                        style="{{ request()->routeIs('user.dashboard') ? 'background-color: var(--accent-blue); color: #fff;' : 'color: var(--text-primary);' }}"
                        onmouseover="this.style.backgroundColor='var(--accent-blue-hover)'; this.style.color='#fff';"
                        onmouseout="if({{ request()->routeIs('user.dashboard') ? 'true' : 'false' }}){this.style.backgroundColor='var(--accent-blue)'; this.style.color='#fff';}else{this.style.backgroundColor=''; this.style.color='var(--text-primary)';}">
                        <i class="fa-solid fa-gauge"></i>
                        <span>Overview</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.referrals') }}"
                        class="flex px-4 py-2 rounded items-center gap-2 transition-colors"
                        style="{{ request()->routeIs('user.referrals') ? 'background-color: var(--accent-blue); color: #fff;' : 'color: var(--text-primary);' }}"
                        onmouseover="this.style.backgroundColor='var(--accent-blue-hover)'; this.style.color='#fff';"
                        onmouseout="if({{ request()->routeIs('user.referrals') ? 'true' : 'false' }}){this.style.backgroundColor='var(--accent-blue)'; this.style.color='#fff';}else{this.style.backgroundColor=''; this.style.color='var(--text-primary)';}">
                        <i class="fa-solid fa-user-group"></i>
                        <span>Referrals</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.profile.show') }}"
                        class="flex px-4 py-2 rounded items-center gap-2 transition-colors"
                        style="{{ request()->routeIs('user.profile.*') ? 'background-color: var(--accent-blue); color: #fff;' : 'color: var(--text-primary);' }}"
                        onmouseover="this.style.backgroundColor='var(--accent-blue-hover)'; this.style.color='#fff';"
                        onmouseout="if({{ request()->routeIs('user.profile.*') ? 'true' : 'false' }}){this.style.backgroundColor='var(--accent-blue)'; this.style.color='#fff';}else{this.style.backgroundColor=''; this.style.color='var(--text-primary)';}">
                        <i class="fa-solid fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.orders.index') }}"
                        class="flex px-4 py-2 rounded items-center gap-2 transition-colors"
                        style="{{ request()->routeIs('user.orders.*') ? 'background-color: var(--accent-blue); color: #fff;' : 'color: var(--text-primary);' }}"
                        onmouseover="this.style.backgroundColor='var(--accent-blue-hover)'; this.style.color='#fff';"
                        onmouseout="if({{ request()->routeIs('user.orders.*') ? 'true' : 'false' }}){this.style.backgroundColor='var(--accent-blue)'; this.style.color='#fff';}else{this.style.backgroundColor=''; this.style.color='var(--text-primary)';}">
                        <i class="fa-solid fa-box"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.reviews.index') }}"
                        class="flex px-4 py-2 rounded items-center gap-2 transition-colors"
                        style="{{ request()->routeIs('user.reviews.*') ? 'background-color: var(--accent-blue); color: #fff;' : 'color: var(--text-primary);' }}"
                        onmouseover="this.style.backgroundColor='var(--accent-blue-hover)'; this.style.color='#fff';"
                        onmouseout="if({{ request()->routeIs('user.reviews.*') ? 'true' : 'false' }}){this.style.backgroundColor='var(--accent-blue)'; this.style.color='#fff';}else{this.style.backgroundColor=''; this.style.color='var(--text-primary)';}">
                        <i class="fa-solid fa-star"></i>
                        <span>Reviews</span>
                    </a>
                </li>
            </ul>
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="submit"
                    class="w-full flex px-4 py-2 rounded items-center gap-2 transition-colors text-left"
                    style="color: var(--text-primary);"
                    onmouseover="this.style.backgroundColor='var(--accent-red)'; this.style.color='#fff';"
                    onmouseout="this.style.backgroundColor=''; this.style.color='var(--text-primary)';">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>

        <!-- Overlay for mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 z-20 hidden lg:hidden" style="background: rgba(0,0,0,0.4);">
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-64">
            <header class="shadow-md p-4 flex flex-row items-center justify-between print:hidden"
                style="background-color: var(--bg-primary);">
                <button id="menu-button" class="text-xl font-bold lg:hidden">☰</button>
                <h1 class="text-xl font-bold mb-2 sm:mb-0 hidden lg:block">Dashboard</h1>
                <div class="flex flex-wrap sm:flex-nowrap space-x-2 sm:space-x-4 items-center">
                    <div class="text-xs" style="color: var(--text-secondary);">
                        {{ auth()->user()->name }}
                    </div>
                    <div class="">
                        <img src="https://via.placeholder.com/640x480.png/002244?text=enim" alt=""
                            class="w-8 h-8 rounded-full">
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 bg-gray-100">
                @if (session('success'))
                    <div class="px-4 py-3 rounded relative mb-2" role="alert"
                        style="background-color: var(--accent-green); color: #fff; border: 1px solid var(--accent-green-hover);">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="px-4 py-3 rounded relative mb-2" role="alert"
                        style="background-color: var(--accent-red); color: #fff; border: 1px solid var(--accent-red);">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                @yield('main')
            </main>
        </div>
    </div>

    <script>
        const menuBtn = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');
        const closeBtn = document.getElementById('close-sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            overlay.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            overlay.classList.add('hidden');
        }

        if (menuBtn) menuBtn.addEventListener('click', openSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (overlay) overlay.addEventListener('click', closeSidebar);
    </script>
    @yield('js')
</body>

</html>
