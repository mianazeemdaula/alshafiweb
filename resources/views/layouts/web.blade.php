<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
   
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Alshaafi Online </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('head')
  </head>
  <body>
    <div class="flex md:block-hidden h-screen bg-gray-100">
      <div class="h-full bg-gray-800 text-white w-64 ">
        <div class="p-4 font-bold text-lg">Admin Panel</div>
        <ul class="space-y-2">
          <li class="p-2 hover:bg-gray-700">
            <FaHome class="inline-block mr-2 hover:animate-pulse" /> Dashboard
          </li>
          <li class="p-2 hover:bg-gray-700 @if(request()->routeIs('admin.categories.*')) bg-green-500 @endif">
            <a href="{{ route('admin.categories.index') }}"><FaBox class="inline-block mr-2" /> Categories</a>
          </li>
          <li class="p-2 hover:bg-gray-700 @if(request()->routeIs('admin.products.*')) bg-green-500 @endif">
            <a href="{{ route('admin.products.index') }}"><FaBox class="inline-block mr-2" /> Products</a>
          </li>
          <li class="p-2 hover:bg-gray-700 @if(request()->routeIs('admin.users.*')) bg-green-500 @endif">
            <a href="{{ route('admin.users.index') }}"><FaUsers class="inline-block mr-2" /> Users</a>
          </li>
          <li class="p-2 hover:bg-gray-700 @if(request()->routeIs('admin.levels.*')) bg-green-500 @endif">
            <a href="{{ route('admin.levels.index') }}"><FaUsers class="inline-block mr-2" /> Levels</a>
          </li>
          <li class="p-2 hover:bg-gray-700 @if(request()->routeIs('admin.orders.*')) bg-green-500 @endif">
            <a href="{{ route('admin.orders.index') }}"><FaUsers class="inline-block mr-2" /> Orders</a>
          </li>

          <li class="p-2 hover:bg-gray-700 @if(request()->routeIs('admin.news.*')) bg-green-500 @endif">
            <a href="{{ route('admin.news.index') }}"><FaUsers class="inline-block mr-2" /> News</a>
          </li>

          <li class="p-2 hover:bg-gray-700 @if(request()->routeIs('admin.suggestions.*')) bg-green-500 @endif">
            <a href="{{ route('admin.suggestions.index') }}"><FaUsers class="inline-block mr-2" /> Suggestions</a>
          </li>

          <li class="p-2 hover:bg-gray-700 @if(request()->routeIs('admin.posts.*')) bg-green-500 @endif">
            <a href="{{ route('admin.posts.index') }}"><FaUsers class="inline-block mr-2" /> Posts</a>
          </li>
        </ul>
      </div>
      <div class="flex-1 flex flex-col ">
        <header class="bg-white shadow-md p-4 flex flex-col sm:flex-row sm:justify-between items-center">
          <h1 class="text-xl font-bold mb-2 sm:mb-0">Dashboard</h1>
          <div class="flex flex-wrap sm:flex-nowrap space-x-2 sm:space-x-4">
            <button class="py-1 px-3 bg-blue-600 text-white rounded-md">
              Login
            </button>
            <button class="py-1 px-3 bg-red-600 text-white rounded-md">
              Logout
            </button>
          </div>
        </header>
        <main class="flex-1 p-6 bg-gray-100 overflow-y-auto">
          @yield('content')
        </main>
      </div>
    </div>
  </body>
</html>
