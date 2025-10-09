<ul class="space-y-2 text-sm">
    <li class="p-2 hover:bg-gray-700  hover:animate-pulse">
        <a href="{{ route('dashboard') }}" class="block"><i class="fa-solid fa-home mr-2"></i>
            Dashboard</a>
    </li>

    {{-- Admin Only Menu Items --}}
    @if (auth()->user()->hasRole('admin'))
        <li class="p-2 hover:bg-gray-700 hover:animate-pulse @if (request()->routeIs('admin.categories.*')) bg-green-500 @endif">
            <a href="{{ route('admin.categories.index') }}" class="block"><i class="fa-solid fa-share-alt mr-2"></i>
                Categories</a>
        </li>
        <li class="p-2 hover:bg-gray-700 hover:animate-pulse @if (request()->routeIs('admin.products.*')) bg-green-500 @endif">
            <a href="{{ route('admin.products.index') }}" class="block"><i class="fa-solid fa-tag mr-2"></i>
                Products</a>
        </li>
        <li class="p-2 hover:bg-gray-700 hover:animate-pulse @if (request()->routeIs('admin.users.*')) bg-green-500 @endif">
            <a href="{{ route('admin.users.index') }}" class="block"><i class="fa-solid fa-users mr-2"></i>
                Users</a>
        </li>
        <li class="p-2 hover:bg-gray-700 hover:animate-pulse @if (request()->routeIs('admin.levels.*')) bg-green-500 @endif">
            <a href="{{ route('admin.levels.index') }}" class="block"><i class="fa-solid fa-chart-line mr-2"></i>
                Levels</a>
        </li>
    @endif

    {{-- Admin & Order Taker Menu Items --}}
    @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('order_taker'))
        <li class="p-2 hover:bg-gray-700 hover:animate-pulse @if (request()->routeIs('admin.orders.*')) bg-green-500 @endif">
            <a href="{{ route('admin.orders.index') }}" class="block"><i class="fa-solid fa-cart-shopping mr-2"></i>
                Orders</a>
        </li>
    @endif

    {{-- Admin Only Menu Items --}}
    @if (auth()->user()->hasRole('admin'))
        <li class="p-2 hover:bg-gray-700 hover:animate-pulse @if (request()->routeIs('admin.news.*')) bg-green-500 @endif">
            <a href="{{ route('admin.news.index') }}" class="block"><i class="fa-solid fa-newspaper mr-2"></i>
                News</a>
        </li>
        <li class="p-2 hover:bg-gray-700 hover:animate-pulse @if (request()->routeIs('admin.suggestions.*')) bg-green-500 @endif">
            <a href="{{ route('admin.suggestions.index') }}" class="block"><i
                    class="fa-solid fa-handshake-angle mr-2"></i> Suggestions</a>
        </li>
        <li class="p-2 hover:bg-gray-700  hover:animate-pulse @if (request()->routeIs('admin.blog-categories.*')) bg-green-500 @endif">
            <a href="{{ route('admin.blog-categories.index') }}" class="block"><i class="fa-solid fa-folder mr-2"></i>
                Blog Categories</a>
        </li>
        <li class="p-2 hover:bg-gray-700  hover:animate-pulse @if (request()->routeIs('admin.posts.*')) bg-green-500 @endif">
            <a href="{{ route('admin.posts.index') }}" class="block"><i class="fa-solid fa-blog mr-2"></i>
                Blog</a>
        </li>
        <li class="p-2 hover:bg-gray-700  hover:animate-pulse @if (request()->routeIs('admin.banners.*')) bg-green-500 @endif">
            <a href="{{ route('admin.banners.index') }}" class="block"><i class="fa-solid fa-image mr-2"></i>
                Banners</a>
        </li>
        <li class="p-2 hover:bg-gray-700  hover:animate-pulse @if (request()->routeIs('admin.couriers.*')) bg-green-500 @endif">
            <a href="{{ route('admin.courier-services.index') }}" class="block"><i class="fa-solid fa-truck mr-2"></i>
                Courier Services</a>
        </li>
    @endif

    {{-- Admin & Order Taker Menu Items --}}
    @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('order_taker'))
        <li class="p-2 hover:bg-gray-700  hover:animate-pulse @if (request()->routeIs('admin.shipments.*')) bg-green-500 @endif">
            <a href="{{ route('admin.shipments.index') }}" class="block"><i
                    class="fa-solid fa-shipping-fast mr-2"></i>
                Shipments</a>
        </li>
        <li class="p-2 hover:bg-gray-700  hover:animate-pulse @if (request()->routeIs('admin.dashboard.shipments')) bg-green-500 @endif">
            <a href="{{ route('admin.dashboard.shipments') }}" class="block"><i
                    class="fa-solid fa-chart-pie mr-2"></i>
                Shipment Dashboard</a>
        </li>
    @endif

    <li class="p-2 hover:bg-gray-700  hover:animate-pulse">
        <form action="{{ url('logout') }}" method="post">
            @csrf
            <button type="submit"><i class="fa-solid fa-sign-out mr-2"></i> Logout</button>
        </form>
    </li>
</ul>
