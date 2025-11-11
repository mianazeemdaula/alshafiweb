<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @hasSection('title')
            @yield('title')
        @else
            {{ config('app.name', 'eCommerce') }}
        @endif
    </title>
    @hasSection('meta_description')
        <meta name="description" content="@yield('meta_description')">
    @else
        <meta name="description" content="{{ config('global.description_' . App::getLocale(), 'eCommerce') }}">
    @endif

    @hasSection('meta_keywords')
        <meta name="keywords" content="@yield('meta_keywords')">
    @else
        <meta name="keywords" content="{{ config('global.keywords_' . App::getLocale(), 'eCommerce') }}">
    @endif
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

    <!-- Quick Checkout Modal -->
    <div id="quickCheckoutModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 z-[60] items-center justify-center p-4">
        <div
            class="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto transform transition-all">
            <div
                class="sticky top-0 bg-gradient-to-r from-blue-600 to-purple-600 text-white p-4 rounded-t-2xl flex justify-between items-center">
                <h3 class="text-xl font-bold">Quick Checkout</h3>
                <button onclick="closeQuickCheckout()" class="text-white hover:text-gray-200 text-2xl leading-none">
                    &times;
                </button>
            </div>

            <div class="p-6">
                <form id="quickCheckoutForm" onsubmit="submitQuickCheckout(event)">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                        <input type="text" name="customer_name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter your name">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone *</label>
                        <input type="tel" name="customer_phone" required pattern="03[0-9]{9}" maxlength="11"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="03123456789">
                        <p class="text-xs text-gray-500 mt-1">Format: 03xxxxxxxxx</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                        <input type="text" name="city" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter your city">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                        <textarea name="address" required rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter your complete address"></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="continueToFullCheckout()"
                            class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-3 rounded-lg font-medium transition-colors">
                            Full Checkout
                        </button>
                        <button type="submit"
                            class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white py-3 rounded-lg font-medium transition-all">
                            Place Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showQuickCheckout() {
            const modal = document.getElementById('quickCheckoutModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeQuickCheckout() {
            const modal = document.getElementById('quickCheckoutModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        function continueToFullCheckout() {
            window.location.href = '/checkout';
        }

        function submitQuickCheckout(event) {
            event.preventDefault();
            const form = event.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';

            const formData = new FormData(form);
            const data = {
                customer_name: formData.get('customer_name'),
                customer_phone: formData.get('customer_phone'),
                shipping: {
                    city: formData.get('city'),
                    address: formData.get('address')
                }
            };

            fetch('/checkout/place-order', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '/order-confirmation/' + data.order_id;
                    } else {
                        alert(data.message || 'Failed to place order');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error placing order. Please try again.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
        }

        // Close modal when clicking outside
        document.getElementById('quickCheckoutModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeQuickCheckout();
            }
        });
    </script>

    <!-- WhatsApp Floating Button -->
    <div id="whatsapp-button" class="fixed bottom-24 right-6 z-50">
        <a href="https://wa.me/923253255555?text={{ urlencode(__('Hello! I need help with your products.')) }}"
            target="_blank"
            class="whatsapp-btn bg-green-500 hover:bg-green-600 text-white rounded-full p-4 shadow-lg transition-all duration-300 flex items-center justify-center group">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488" />
            </svg>
        </a>
    </div>

    <style>
        .whatsapp-btn {
            animation: pulse-whatsapp 2s infinite;
            box-shadow: 0 4px 20px rgba(34, 197, 94, 0.4);
        }

        .whatsapp-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 25px rgba(34, 197, 94, 0.6);
        }

        @keyframes pulse-whatsapp {
            0% {
                box-shadow: 0 4px 20px rgba(34, 197, 94, 0.4), 0 0 0 0 rgba(34, 197, 94, 0.7);
            }

            70% {
                box-shadow: 0 4px 20px rgba(34, 197, 94, 0.4), 0 0 0 10px rgba(34, 197, 94, 0);
            }

            100% {
                box-shadow: 0 4px 20px rgba(34, 197, 94, 0.4), 0 0 0 0 rgba(34, 197, 94, 0);
            }
        }

        /* RTL Support */
        html[dir="rtl"] #whatsapp-button {
            right: auto;
            left: 1.5rem;
        }

        /* Mobile responsive */
        @media (max-width: 640px) {
            #whatsapp-button {
                bottom: 4rem;
                right: 1rem;
            }

            html[dir="rtl"] #whatsapp-button {
                right: auto;
                left: 1rem;
            }

            .whatsapp-btn {
                padding: 0.75rem;
            }

            .whatsapp-btn svg {
                width: 1.5rem;
                height: 1.5rem;
            }
        }
    </style>
</body>

</html>
