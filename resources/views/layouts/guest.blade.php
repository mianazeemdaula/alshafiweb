<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ in_array(App::getLocale(), ['ar', 'ur']) ? 'rtl' : 'ltr' }}" class="">

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

    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Theme initialization script (must be in head to prevent flash) -->
    <script>
        (function() {
            const theme = localStorage.getItem('theme') ||
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="{{ in_array(App::getLocale(), ['ar', 'ur']) ? 'arabic-text' : '' }} bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <div class="z-50 w-full bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
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

        // Country and Language Selector JavaScript
        document.getElementById('country-selector').addEventListener('change', function() {
            const selectedCountry = this.value;
            window.location.href = window.location.pathname + '?country=' + selectedCountry;
        });

        document.getElementById('locale-selector').addEventListener('change', function() {
            const selectedLocale = this.value;
            const currentUrl = new URL(window.location);
            currentUrl.searchParams.set('locale', selectedLocale);
            window.location.href = currentUrl.toString();
        });

        // Mobile Menu Toggle
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                const icon = this.querySelector('i');
                if (mobileMenu.classList.contains('hidden')) {
                    icon.className = 'fa fa-bars text-xl';
                } else {
                    icon.className = 'fa fa-times text-xl';
                }
            });
        }
    </script>
</body>

</html>
