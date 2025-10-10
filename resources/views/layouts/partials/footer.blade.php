<footer class="relative overflow-hidden">
    <!-- Gradient Background -->
    <div
        class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 dark:from-black dark:via-gray-900 dark:to-black">
    </div>

    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl"></div>

    <div class="relative z-10 p-8 lg:p-12">
        <div class="max-w-7xl mx-auto">
            <!-- Main Footer Content -->
            <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-8 mb-8">
                <!-- About Section -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2 mb-4">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fa fa-store text-white text-xl"></i>
                        </div>
                        <h1 class="text-xl font-bold text-white">{{ __('About Us') }}</h1>
                    </div>
                    <p class="text-sm text-gray-300 leading-relaxed">
                        {{ __('Your trusted online shopping destination for quality products and exceptional service.') }}
                    </p>
                    <div class="flex space-x-3 pt-2">
                        <a href="https://www.facebook.com/AlShaafiOnlineDotCom"
                            class="w-10 h-10 bg-white/10 hover:bg-blue-600 rounded-lg flex items-center justify-center text-white transition-all transform hover:scale-110">
                            <i class="fa-brands fa-facebook text-lg"></i>
                        </a>
                        <a href="https://www.instagram.com/alshaafionline/"
                            class="w-10 h-10 bg-white/10 hover:bg-pink-600 rounded-lg flex items-center justify-center text-white transition-all transform hover:scale-110">
                            <i class="fa-brands fa-instagram text-lg"></i>
                        </a>
                        <a href="https://www.tiktok.com/@hakeemsarfraz786"
                            class="w-10 h-10 bg-white/10 hover:bg-gray-900 rounded-lg flex items-center justify-center text-white transition-all transform hover:scale-110">
                            <i class="fa-brands fa-tiktok text-lg"></i>
                        </a>
                        <a href="https://www.youtube.com/@HakeemSarfrazGlobal"
                            class="w-10 h-10 bg-white/10 hover:bg-red-600 rounded-lg flex items-center justify-center text-white transition-all transform hover:scale-110">
                            <i class="fa-brands fa-youtube text-lg"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2 mb-4">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg flex items-center justify-center">
                            <i class="fa fa-link text-white text-xl"></i>
                        </div>
                        <h1 class="text-xl font-bold text-white">{{ __('Quick Links') }}</h1>
                    </div>
                    <ul class="space-y-3">
                        <li>
                            <a href="#"
                                class="text-sm text-gray-300 hover:text-white transition-colors flex items-center group">
                                <i
                                    class="fa fa-chevron-right text-xs mr-2 text-blue-500 group-hover:translate-x-1 transition-transform"></i>
                                {{ __('About Us') }}
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-sm text-gray-300 hover:text-white transition-colors flex items-center group">
                                <i
                                    class="fa fa-chevron-right text-xs mr-2 text-blue-500 group-hover:translate-x-1 transition-transform"></i>
                                {{ __('Contact Us') }}
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-sm text-gray-300 hover:text-white transition-colors flex items-center group">
                                <i
                                    class="fa fa-chevron-right text-xs mr-2 text-blue-500 group-hover:translate-x-1 transition-transform"></i>
                                {{ __('Privacy Policy') }}
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-sm text-gray-300 hover:text-white transition-colors flex items-center group">
                                <i
                                    class="fa fa-chevron-right text-xs mr-2 text-blue-500 group-hover:translate-x-1 transition-transform"></i>
                                {{ __('Terms & Conditions') }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Categories -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2 mb-4">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-pink-600 to-red-600 rounded-lg flex items-center justify-center">
                            <i class="fa fa-th-large text-white text-xl"></i>
                        </div>
                        <h1 class="text-xl font-bold text-white">{{ __('Categories') }}</h1>
                    </div>
                    <ul class="space-y-3">
                        @foreach (\App\Models\Category::take(4)->get() as $item)
                            <li>
                                <a href="{{ route('web.products', ['category' => $item->id]) }}"
                                    class="text-sm text-gray-300 hover:text-white transition-colors flex items-center group">
                                    <i
                                        class="fa fa-chevron-right text-xs mr-2 text-purple-500 group-hover:translate-x-1 transition-transform"></i>
                                    {{ $item->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2 mb-4">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-green-600 to-emerald-600 rounded-lg flex items-center justify-center">
                            <i class="fa fa-phone text-white text-xl"></i>
                        </div>
                        <h1 class="text-xl font-bold text-white">{{ __('Contact Info') }}</h1>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-start space-x-3">
                            <div
                                class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fa fa-envelope text-blue-400 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Email</p>
                                <a href="mailto:info@alshafionline.com"
                                    class="text-sm text-gray-300 hover:text-white transition-colors">
                                    info@alshafionline.com
                                </a>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div
                                class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fa fa-phone text-green-400 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Helpline</p>
                                <a href="tel:4534345656"
                                    class="text-sm text-gray-300 hover:text-white transition-colors">
                                    4534345656
                                </a>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div
                                class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fa fa-clock text-purple-400 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Working Hours</p>
                                <p class="text-sm text-gray-300">Mon - Sat: 9AM - 6PM</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Newsletter Section -->
            <div class="border-t border-gray-700 pt-8 pb-6">
                <div class="grid md:grid-cols-2 gap-6 items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-white mb-2">{{ __('Subscribe to Our Newsletter') }}</h3>
                        <p class="text-sm text-gray-400">
                            {{ __('Get the latest updates on new products and upcoming sales') }}</p>
                    </div>
                    <div class="flex gap-2">
                        <input type="email" placeholder="{{ __('Enter your email') }}"
                            class="flex-1 px-4 py-3 rounded-lg bg-white/10 border border-gray-600 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <button
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium rounded-lg transition-all transform hover:scale-105 shadow-lg whitespace-nowrap">
                            <i class="fa fa-paper-plane mr-2"></i>{{ __('Subscribe') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-700 pt-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-sm text-gray-400">
                        © {{ date('Y') }} <span class="text-white font-medium">Al Shaafi Online</span>.
                        {{ __('All rights reserved.') }}
                    </p>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-400">{{ __('Payment Methods:') }}</span>
                        <div class="flex space-x-2">
                            <div class="w-12 h-8 bg-white/10 rounded flex items-center justify-center">
                                <i class="fa-brands fa-cc-visa text-white text-lg"></i>
                            </div>
                            <div class="w-12 h-8 bg-white/10 rounded flex items-center justify-center">
                                <i class="fa-brands fa-cc-mastercard text-white text-lg"></i>
                            </div>
                            <div class="w-12 h-8 bg-white/10 rounded flex items-center justify-center">
                                <i class="fa-brands fa-cc-paypal text-white text-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
