<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        {{ config('app.name', 'eCommerce') }} - @yield('title')
    </title>
    <meta name="description" content="{{ config('global.description_' . App::getLocale(), 'eCommerce') }}">
    <meta name="keywords" content="{{ config('global.keywords_' . App::getLocale(), 'eCommerce') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="z-50 w-full bg-white">
        @include('layouts.partials.header')
    </div>
    @yield('content')
    @include('layouts.partials.footer')
    @yield('jsscript')
    <script>
        // add class when scroll on screen is more then 20%
        window.addEventListener('scroll', function() {
            var header = document.querySelector('#header');
            header.classList.toggle('sticky', window.scrollY > 50);
        });

        // Load cart count on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadCartCount();
        });

        function loadCartCount() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                fetch('/cart/contents', {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        updateCartCount(data.count);
                    })
                    .catch(error => {
                        console.log('Cart count load error:', error);
                    });
            }
        }

        function updateCartCount(count) {
            const cartCountElements = document.querySelectorAll('.cart-count');
            cartCountElements.forEach(element => {
                element.textContent = count;
                element.style.display = count > 0 ? 'flex' : 'none';
            });
        }
    </script>
</body>

</html>
