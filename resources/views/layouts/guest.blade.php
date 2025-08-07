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
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="z-50 w-full bg-white">
        @include('layouts.partials.header')
    </div>
    @yield('content')
    @include('layouts.partials.footer')
    @livewireScripts
    @yield('jsscript')
    <script>
        // Load cart count on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadCartCount();
            initializeLanguageCountrySelectors();
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

        function initializeLanguageCountrySelectors() {
            // Language and Country selectors are completely independent
            // No automatic associations between country and language selection

            const countrySelector = document.getElementById('country-selector');
            const localeSelector = document.getElementById('locale-selector');

            // Country selector - only changes country, never affects language
            if (countrySelector) {
                countrySelector.addEventListener('change', function() {
                    const selectedCountry = this.value;
                    if (selectedCountry) {
                        // Show loading state
                        this.disabled = true;
                        // Store country preference independently
                        localStorage.setItem('preferred_country', selectedCountry);
                        window.location.href = '/change-country/' + selectedCountry;
                    }
                });
            }

            // Language selector - only changes language, never affects country
            if (localeSelector) {
                localeSelector.addEventListener('change', function() {
                    const selectedLocale = this.value;
                    if (selectedLocale) {
                        // Show loading state
                        this.disabled = true;
                        // Store language preference independently
                        localStorage.setItem('preferred_locale', selectedLocale);
                        window.location.href = '/change-locale/' + selectedLocale;
                    }
                });
            }

            // Restore preferences independently - no cross-dependencies
            // Language restoration
            const preferredLocale = localStorage.getItem('preferred_locale');
            const currentLocale = '{{ App::getLocale() }}';

            // Only restore language if it differs from current and we have a selector
            if (preferredLocale && preferredLocale !== currentLocale && localeSelector &&
                !document.querySelector('meta[name="locale-changed"]')) {
                // Add meta tag to prevent loop
                const meta = document.createElement('meta');
                meta.name = 'locale-changed';
                meta.content = 'true';
                document.head.appendChild(meta);
                window.location.href = '/change-locale/' + preferredLocale;
            }

            // Country restoration (independent of language)
            const preferredCountry = localStorage.getItem('preferred_country');
            const currentCountry = '{{ Session::get('country', 'WW') }}';

            // Only restore country if it differs from current and we have a selector
            if (preferredCountry && preferredCountry !== currentCountry && countrySelector &&
                !document.querySelector('meta[name="country-changed"]')) {
                // Add meta tag to prevent loop
                const meta = document.createElement('meta');
                meta.name = 'country-changed';
                meta.content = 'true';
                document.head.appendChild(meta);
                window.location.href = '/change-country/' + preferredCountry;
            }
        }

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

        // add class when scroll on screen is more then 20%
        window.addEventListener('scroll', function() {
            var header = document.querySelector('#header');
            if (header) {
                header.classList.toggle('sticky', window.scrollY > 50);
            }
        });
    </script>
</body>

</html>
