<div class="border-b p-2 flex items-center justify-between text-sm flex-col md:flex-row">
    <div class="flex  space-x-2 items-center">
        <div class="flex items-center ">
            <i class="fa-regular fa-envelope mx-1"></i>
            <div>info@alshafionline.com</div>
        </div>
        <div class="border border-slate-100 h-4"></div>
        <div class="flex items-center ">
            <i class="fa fa-phone mx-1"></i>
            <div>Helpline 4534345656</div>
        </div>
    </div>
    <div class="flex space-x-2 items-center">
        <a href="{{ url('/login') }}" class="flex items-center ">
            <i class="fa fa-user-lock mx-1"></i>
            <div>Login</div>
        </a>
        <div class="border border-slate-100 h-4"></div>
        <a href="{{ url('/register') }}" class="flex items-center ">
            <i class="fa fa-user-plus mx-1"></i>
            <div>Register</div>
        </a>
    </div>
</div>
<div class="bg-white w-full z-50" id="header">
    <div class="p-2 border-b">
        <div class="flex flex-col md:flex-row items-center gap-2">
            <div class="w-2/12">
                <img src="{{ asset('images/logo/logo.svg') }}" alt="logo">
            </div>
            <div class="md:flex-1 w-full">
                <form action="/products" method="get" class="flex items-center gap-2">
                    <input type="text" name="search" class="w-full border py-2 rounded-lg bg-gray-100 px-4 text-sm"
                        placeholder="Search here" value="{{ request('search') }}">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg ml-2">Search</button>
                </form>
            </div>
            <div class="md:w-2/12 w-full flex items-center justify-center space-x-2">
                <div class="text-sm">
                    <a href="#">My Account</a>
                </div>
                <div class="border border-slate-100 h-4"></div>
                <a href="{{ url('/cart') }}" class="relative">
                    <i class="fa-solid fa-basket-shopping text-xl text-gray-500"></i>
                    <div class="cart-count absolute top-0 left-3 border p-2 rounded-full bg-primary text-white text-[10px] size-4 flex items-center justify-center"
                        style="display: none;">
                        0
                    </div>
                </a>
                <div class="border border-slate-100 h-4"></div>
                <a href="{{ url('/checkout') }}"
                    class="text-sm bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                    Checkout
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white border-b flex md:flex-row flex-col items-center justify-between px-4">
        <div class="flex justify-center space-x-4 uppercase ">
            <a href="{{ url('/products') }}" class="text-sm text-gray-500 hover:bg-hover p-2">Products</a>
            <a href="{{ route('categories') }}" class="text-sm text-gray-500 hover:bg-hover p-2">Categories</a>
            <a href="{{ route('services') }}" class="text-sm text-gray-500 hover:bg-hover p-2">Services</a>
            <a href="{{ url('/contact-us') }}" class="text-sm text-gray-500 hover:bg-hover p-2">Contact Us</a>
            <a href="{{ route('track.order') }}" class="text-sm text-gray-500 hover:bg-hover p-2">Track Order</a>
            <a href="{{ route('news') }}" class="text-sm text-gray-500 hover:bg-hover p-2">News</a>
        </div>
        <div class="md:hidden border-b h-2 w-full"></div>
    </div>
</div>
