<footer class="relative overflow-hidden border-t border-emerald-900/30">
    <!-- Gradient Background -->
    <div
        class="absolute inset-0 bg-gradient-to-br from-emerald-950 via-gray-950 to-emerald-950 dark:from-black dark:via-emerald-950/40 dark:to-black">
    </div>

    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-emerald-500/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-amber-500/5 rounded-full blur-3xl"></div>

    <div class="relative z-10 py-12 px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Main Footer Content -->
            <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-10 mb-12">
                <!-- About Section -->
                <div class="space-y-6">
                    <div class="flex items-center gap-2.5 mb-4 group">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-700/20">
                            <i class="fa-solid fa-leaf text-white text-lg"></i>
                        </div>
                        <span class="leading-none">
                            <span class="block text-xl font-extrabold tracking-tight text-white" style="font-family: 'Playfair Display', serif;">
                                alshaafi<span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-emerald-200">online</span>
                            </span>
                            <span class="block text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-400/60">{{ __('Health & Wellness') }}</span>
                        </span>
                    </div>
                    <p class="text-sm text-emerald-100/70 leading-relaxed font-sans">
                        {{ __('Your trusted online shopping destination for premium natural, organic remedies and wellness products.') }}
                    </p>
                    <div class="flex space-x-3 pt-2">
                        <a href="https://www.facebook.com/AlShaafiOnlineDotCom" target="_blank" rel="noopener noreferrer"
                            class="w-10 h-10 bg-white/5 hover:bg-emerald-600/30 hover:text-emerald-400 rounded-xl flex items-center justify-center text-white transition-all transform hover:-translate-y-1 duration-300 border border-white/5 hover:border-emerald-500/30">
                            <i class="fa-brands fa-facebook text-lg"></i>
                        </a>
                        <a href="https://www.instagram.com/alshaafionline/" target="_blank" rel="noopener noreferrer"
                            class="w-10 h-10 bg-white/5 hover:bg-emerald-600/30 hover:text-emerald-400 rounded-xl flex items-center justify-center text-white transition-all transform hover:-translate-y-1 duration-300 border border-white/5 hover:border-emerald-500/30">
                            <i class="fa-brands fa-instagram text-lg"></i>
                        </a>
                        <a href="https://www.tiktok.com/@hakeemsarfraz786" target="_blank" rel="noopener noreferrer"
                            class="w-10 h-10 bg-white/5 hover:bg-emerald-600/30 hover:text-emerald-400 rounded-xl flex items-center justify-center text-white transition-all transform hover:-translate-y-1 duration-300 border border-white/5 hover:border-emerald-500/30">
                            <i class="fa-brands fa-tiktok text-lg"></i>
                        </a>
                        <a href="https://www.youtube.com/@HakeemSarfrazGlobal" target="_blank" rel="noopener noreferrer"
                            class="w-10 h-10 bg-white/5 hover:bg-emerald-600/30 hover:text-emerald-400 rounded-xl flex items-center justify-center text-white transition-all transform hover:-translate-y-1 duration-300 border border-white/5 hover:border-emerald-500/30">
                            <i class="fa-brands fa-youtube text-lg"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="space-y-4">
                    <h2 class="text-lg font-bold text-white tracking-wide" style="font-family: 'Playfair Display', serif;">{{ __('Quick Links') }}</h2>
                    <div class="w-12 h-1 bg-gradient-to-r from-emerald-500 to-emerald-800 rounded mb-6"></div>
                    <ul class="space-y-3 font-sans">
                        <li>
                            <a href="{{ url('/') }}"
                                class="text-sm text-emerald-100/70 hover:text-white transition-colors flex items-center group">
                                <i class="fa fa-chevron-right text-[10px] mr-2.5 text-emerald-500 group-hover:translate-x-1 transition-transform"></i>
                                {{ __('Home') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/products') }}"
                                class="text-sm text-emerald-100/70 hover:text-white transition-colors flex items-center group">
                                <i class="fa fa-chevron-right text-[10px] mr-2.5 text-emerald-500 group-hover:translate-x-1 transition-transform"></i>
                                {{ __('Products') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/contact-us') }}"
                                class="text-sm text-emerald-100/70 hover:text-white transition-colors flex items-center group">
                                <i class="fa fa-chevron-right text-[10px] mr-2.5 text-emerald-500 group-hover:translate-x-1 transition-transform"></i>
                                {{ __('Contact Us') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('services') }}"
                                class="text-sm text-emerald-100/70 hover:text-white transition-colors flex items-center group">
                                <i class="fa fa-chevron-right text-[10px] mr-2.5 text-emerald-500 group-hover:translate-x-1 transition-transform"></i>
                                {{ __('Services') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('news') }}"
                                class="text-sm text-emerald-100/70 hover:text-white transition-colors flex items-center group">
                                <i class="fa fa-chevron-right text-[10px] mr-2.5 text-emerald-500 group-hover:translate-x-1 transition-transform"></i>
                                {{ __('News') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('track.order') }}"
                                class="text-sm text-emerald-100/70 hover:text-white transition-colors flex items-center group">
                                <i class="fa fa-chevron-right text-[10px] mr-2.5 text-emerald-500 group-hover:translate-x-1 transition-transform"></i>
                                {{ __('Track Order') }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Categories -->
                <div class="space-y-4">
                    <h2 class="text-lg font-bold text-white tracking-wide" style="font-family: 'Playfair Display', serif;">{{ __('Categories') }}</h2>
                    <div class="w-12 h-1 bg-gradient-to-r from-emerald-500 to-emerald-800 rounded mb-6"></div>
                    <ul class="space-y-3 font-sans">
                        @foreach (\App\Models\Category::take(5)->get() as $item)
                            <li>
                                <a href="{{ route('web.products', ['category' => $item->id]) }}"
                                    class="text-sm text-emerald-100/70 hover:text-white transition-colors flex items-center group">
                                    <i class="fa fa-chevron-right text-[10px] mr-2.5 text-emerald-500 group-hover:translate-x-1 transition-transform"></i>
                                    {{ $item->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Contact Info & Legal Links -->
                <div class="space-y-4">
                    <h2 class="text-lg font-bold text-white tracking-wide" style="font-family: 'Playfair Display', serif;">{{ __('Contact Info') }}</h2>
                    <div class="w-12 h-1 bg-gradient-to-r from-emerald-500 to-emerald-800 rounded mb-6"></div>
                    <ul class="space-y-4 font-sans text-sm">
                        <li class="flex items-start space-x-3 text-emerald-100/70">
                            <i class="fa fa-envelope text-emerald-400 mt-1 text-base"></i>
                            <div>
                                <p class="text-xs text-emerald-300/60 uppercase tracking-wider font-semibold">Email</p>
                                <a href="mailto:info@alshafionline.com"
                                    class="text-emerald-100 hover:text-white transition-colors font-medium">
                                    info@alshafionline.com
                                </a>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3 text-emerald-100/70">
                            <i class="fa fa-phone text-emerald-400 mt-1 text-base"></i>
                            <div>
                                <p class="text-xs text-emerald-300/60 uppercase tracking-wider font-semibold">Helpline</p>
                                <a href="tel:+923253255555"
                                    class="text-emerald-100 hover:text-white transition-colors font-medium">
                                    +92 325 325 55 55
                                </a>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3 text-emerald-100/70">
                            <i class="fa fa-clock text-emerald-400 mt-1 text-base"></i>
                            <div>
                                <p class="text-xs text-emerald-300/60 uppercase tracking-wider font-semibold">Working Hours</p>
                                <p class="text-emerald-100 font-medium">Mon - Sat: 9AM - 6PM</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Newsletter Section -->
            <div class="border-t border-emerald-900/40 py-8">
                <div class="grid md:grid-cols-2 gap-8 items-center">
                    <div>
                        <h3 class="text-xl font-bold text-white mb-2" style="font-family: 'Playfair Display', serif;">{{ __('Subscribe to Our Newsletter') }}</h3>
                        <p class="text-sm text-emerald-100/70">
                            {{ __('Get the latest updates on new organic products, health tips and upcoming sales.') }}
                        </p>
                    </div>
                    <div class="flex gap-2 w-full max-w-md md:ml-auto">
                        <input type="email" placeholder="{{ __('Enter your email') }}"
                            class="flex-1 px-4 py-3 rounded-xl bg-emerald-950/50 border border-emerald-900/60 text-white placeholder-emerald-400/50 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all outline-none text-sm">
                        <button
                            class="px-6 py-3 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-xl transition-all shadow-md hover:shadow-emerald-600/20 whitespace-nowrap text-sm flex items-center justify-center gap-2">
                            <i class="fa fa-paper-plane text-xs"></i>{{ __('Subscribe') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Copyright and Legal Links Footer -->
            <div class="border-t border-emerald-900/40 pt-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="space-y-2 text-center md:text-left">
                    <p class="text-sm text-emerald-100/60">
                        © {{ date('Y') }} <span class="text-white font-medium">Al Shaafi Online</span>.
                        {{ __('All rights reserved.') }}
                    </p>
                    <div class="flex flex-wrap justify-center md:justify-start gap-4 text-xs font-medium">
                        <a href="{{ url('/privacy-policy') }}" class="text-emerald-100/60 hover:text-white transition-colors">
                            {{ __('Privacy Policy') }}
                        </a>
                        <span class="text-emerald-900">|</span>
                        <a href="{{ url('/terms-and-conditions') }}" class="text-emerald-100/60 hover:text-white transition-colors">
                            {{ __('Terms & Conditions') }}
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4 bg-emerald-950/40 py-2.5 px-4 rounded-xl border border-emerald-900/30">
                    <span class="text-xs text-emerald-100/60 font-medium">{{ __('Payment:') }}</span>
                    <div class="flex space-x-3 text-emerald-400/90 text-lg">
                        <i class="fa-brands fa-cc-visa" title="Visa"></i>
                        <i class="fa-brands fa-cc-mastercard" title="Mastercard"></i>
                        <i class="fa-brands fa-cc-paypal" title="Paypal"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
