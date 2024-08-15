<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/svg+xml" href="/vite.svg" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Alshaafi Online</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @yield('head')
</head>
<body>
  <div class="flex bg-gray-100">
    <!-- Sidebar -->
    <div id="sidebar" class="lg:flex flex-col lg:relative fixed  top-0 left-0 h-screen bg-gray-800 text-white w-64 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
      <div class="flex justify-between">
        <div class="p-4 font-bold text-lg">Admin Panel</div>
        <button class="p-4 lg:hidden" id="close-sidebar">✕</button>
      </div>
      <ul class="space-y-2">
        <li class="p-2 hover:bg-gray-700  hover:animate-pulse">
          <a href="{{ route('dashboard') }}" class="block" ><i class="fa-solid fa-home mr-2"></i> Dashboard</a>
        </li>
        <li class="p-2 hover:bg-gray-700 hover:animate-pulse @if(request()->routeIs('admin.categories.*')) bg-green-500 @endif">
          <a href="{{ route('admin.categories.index') }}" class="block"><i class="fa-solid fa-share-alt mr-2"></i> Categories</a>
        </li>
        <li class="p-2 hover:bg-gray-700 hover:animate-pulse @if(request()->routeIs('admin.products.*')) bg-green-500 @endif">
          <a href="{{ route('admin.products.index') }}" class="block"><i class="fa-solid fa-tag mr-2"></i> Products</a>
        </li>
        <li class="p-2 hover:bg-gray-700 hover:animate-pulse @if(request()->routeIs('admin.users.*')) bg-green-500 @endif">
          <a href="{{ route('admin.users.index') }}" class="block"><i class="fa-solid fa-users mr-2"></i> Users</a>
        </li>
        <li class="p-2 hover:bg-gray-700 hover:animate-pulse @if(request()->routeIs('admin.levels.*')) bg-green-500 @endif">
          <a href="{{ route('admin.levels.index') }}" class="block"><i class="fa-solid fa-chart-line mr-2"></i> Levels</a>
        </li>
        <li class="p-2 hover:bg-gray-700 hover:animate-pulse @if(request()->routeIs('admin.orders.*')) bg-green-500 @endif">
          <a href="{{ route('admin.orders.index') }}" class="block"><i class="fa-solid fa-cart-shopping mr-2"></i> Orders</a>
        </li>
        <li class="p-2 hover:bg-gray-700 hover:animate-pulse @if(request()->routeIs('admin.news.*')) bg-green-500 @endif">
          <a href="{{ route('admin.news.index') }}" class="block"><i class="fa-solid fa-newspaper mr-2"></i> News</a>
        </li>
        <li class="p-2 hover:bg-gray-700 hover:animate-pulse @if(request()->routeIs('admin.suggestions.*')) bg-green-500 @endif">
          <a href="{{ route('admin.suggestions.index') }}" class="block"><i class="fa-solid fa-handshake-angle mr-2"></i> Suggestions</a>
        </li>
        <li class="p-2 hover:bg-gray-700  hover:animate-pulse @if(request()->routeIs('admin.posts.*')) bg-green-500 @endif">
          <a href="{{ route('admin.posts.index') }}" class="block"><i class="fa-solid fa-blog mr-2"></i> Posts</a>
        </li>
        <li class="p-2 hover:bg-gray-700  hover:animate-pulse">
          <form action="{{ url('logout') }}" method="post">
            @csrf
            <button type="submit"><i class="fa-solid fa-sign-out mr-2"></i> Logout</button>
          </form>
        </li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
      <header class="bg-white shadow-md p-4 flex flex-row items-center justify-between">
        <button id="menu-button" class="text-xl font-bold lg:hidden">☰</button>
        <h1 class="text-xl font-bold mb-2 sm:mb-0 hidden lg:block">Dashboard</h1>
        <div class="flex flex-wrap sm:flex-nowrap space-x-2 sm:space-x-4">
          <button class="py-1 px-3 bg-blue-600 text-white rounded-md">
            Login
          </button>
          <button class="py-1 px-3 bg-red-600 text-white rounded-md">
            Logout
          </button>
        </div>
      </header>

      <main class="flex-1 p-4 bg-gray-100">
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
  </script>
</body>
</html>
