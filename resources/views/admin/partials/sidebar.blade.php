<ul class="space-y-2 text-sm">
    <li class="p-2 hover:bg-gray-700  hover:animate-pulse">
        <a href="{{ route('dashboard') }}" class="block"><i class="fa-solid fa-home mr-2"></i>
            Dashboard</a>
    </li>

    {{-- Admin Only Menu Items --}}
    @role('admin')
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

        {{-- Team Management Section --}}
        <li class="p-2 hover:bg-gray-700 @if (request()->routeIs('admin.teams.*') || request()->routeIs('admin.bonuses.*')) bg-green-500 @endif">
            <button onclick="toggleTeamMenu()" class="w-full text-left flex items-center justify-between">
                <span><i class="fa-solid fa-users-cog mr-2"></i> Team Management</span>
                <i class="fa-solid fa-chevron-down transition-transform" id="team-menu-icon"></i>
            </button>
            <ul class="ml-4 mt-2 space-y-1 @if (!request()->routeIs('admin.teams.*') && !request()->routeIs('admin.bonuses.*')) hidden @endif" id="team-submenu">
                <li class="p-2 hover:bg-gray-600 rounded @if (request()->routeIs('admin.teams.index')) bg-gray-600 @endif">
                    <a href="{{ route('admin.teams.index') }}" class="block text-sm">
                        <i class="fa-solid fa-sitemap mr-2"></i>Team Structure
                    </a>
                </li>
                <li class="p-2 hover:bg-gray-600 rounded @if (request()->routeIs('admin.teams.assign')) bg-gray-600 @endif">
                    <a href="{{ route('admin.teams.assign') }}" class="block text-sm">
                        <i class="fa-solid fa-user-plus mr-2"></i>Assign Members
                    </a>
                </li>
                <li class="p-2 hover:bg-gray-600 rounded @if (request()->routeIs('admin.bonuses.*')) bg-gray-600 @endif">
                    <a href="{{ route('admin.bonuses.index') }}" class="block text-sm">
                        <i class="fa-solid fa-dollar-sign mr-2"></i>Bonuses
                    </a>
                </li>
            </ul>
        </li>

        <li class="p-2 hover:bg-gray-700 hover:animate-pulse @if (request()->routeIs('admin.levels.*')) bg-green-500 @endif">
            <a href="{{ route('admin.levels.index') }}" class="block"><i class="fa-solid fa-chart-line mr-2"></i>
                Levels</a>
        </li>
    @endrole

    {{-- Admin, Order Taker & Team Leader Menu Items --}}
    @hasanyrole('admin|order_taker|team_leader')
        <li class="p-2 hover:bg-gray-700 hover:animate-pulse @if (request()->routeIs('admin.orders.*')) bg-green-500 @endif">
            <a href="{{ route('admin.orders.index') }}" class="block"><i class="fa-solid fa-cart-shopping mr-2"></i>
                Orders</a>
        </li>
        @role('team_leader')
            <li class="p-2 hover:bg-gray-700 hover:animate-pulse @if (request()->routeIs('admin.teams.my')) bg-green-500 @endif">
                <a href="{{ route('admin.teams.my') }}" class="block"><i class="fa-solid fa-users mr-2"></i>
                    My Team</a>
            </li>
        @endrole
    @endhasanyrole

    {{-- Admin Only Menu Items --}}
    @role('admin')
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
    @endrole

    {{-- Admin, Order Taker & Team Leader Menu Items --}}
    @hasanyrole('admin|order_taker|team_leader')
        <li class="p-2 hover:bg-gray-700  hover:animate-pulse @if (request()->routeIs('admin.shipments.*')) bg-green-500 @endif">
            <a href="{{ route('admin.shipments.index') }}" class="block"><i class="fa-solid fa-shipping-fast mr-2"></i>
                Shipments</a>
        </li>
        <li class="p-2 hover:bg-gray-700  hover:animate-pulse @if (request()->routeIs('admin.dashboard.shipments')) bg-green-500 @endif">
            <a href="{{ route('admin.dashboard.shipments') }}" class="block"><i class="fa-solid fa-chart-pie mr-2"></i>
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
