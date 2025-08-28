<footer>
    <div class="bg-gray-200 dark:bg-gray-800 p-4 border-t border-gray-300 dark:border-gray-700">
        <div class="grid lg:grid-cols-4 grid-cols-2 gap-4">
            <div>
                <h1 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">{{ __('About Us') }}</h1>
                {{-- links --}}
                <ul class="text-sm space-y-2">
                    <li>
                        <a href="#"
                            class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ __('About Us') }}</a>
                    </li>
                    <li>
                        <a href="#"
                            class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ __('Contact Us') }}</a>
                    </li>
                    <li>
                        <a href="#"
                            class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ __('Privacy Policy') }}</a>
                    </li>
                    <li>
                        <a href="#"
                            class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ __('Terms & Conditions') }}</a>
                    </li>
                </ul>
            </div>
            <div>
                <h1 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">{{ __('Categories') }}</h1>
                {{-- links --}}
                <ul class="text-sm space-y-2">
                    @foreach (\App\Models\Category::take(4)->get() as $item)
                        <li>
                            <a href="{{ route('web.products', ['category' => $item->id]) }}"
                                class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ $item->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h1 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">{{ __('About Us') }}</h1>
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    {{ __('Your trusted online shopping destination for quality products and exceptional service.') }}
                </p>
            </div>
            <div>
                <h1 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">{{ __('Social Media') }}</h1>
                <ul class="text-sm space-y-2">
                    <li>
                        <a href="https://www.facebook.com/AlShaafiOnlineDotCom"
                            class="social-icon text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                            <i class="fa-brands fa-facebook"></i> Facebook
                        </a>
                    </li>
                    <li>
                        <a href="https://www.tiktok.com/@hakeemsarfraz786"
                            class="social-icon text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                            <i class="fa-brands fa-tiktok"></i> TikTok
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/alshaafionline/"
                            class="social-icon text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                            <i class="fa-brands fa-instagram"></i> Instagram
                        </a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/@HakeemSarfrazGlobal"
                            class="social-icon text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                            <i class="fa-brands fa-youtube"></i> Youtube
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
