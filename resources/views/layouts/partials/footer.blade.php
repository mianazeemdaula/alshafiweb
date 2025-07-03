<footer>
    <div class="bg-gray-200 p-4">
        <div class="grid lg:grid-cols-4 grid-cols-2 gap-4">
            <div>
                <h1 class="text-lg font-bold mb-4">{{ __('About Us') }}</h1>
                {{-- links --}}
                <ul class="text-sm space-y-2">
                    <li>
                        <a href="#" class="hover:text-blue-600 transition-colors">{{ __('About Us') }}</a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-blue-600 transition-colors">{{ __('Contact Us') }}</a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-blue-600 transition-colors">{{ __('Privacy Policy') }}</a>
                    </li>
                    <li>
                        <a href="#"
                            class="hover:text-blue-600 transition-colors">{{ __('Terms & Conditions') }}</a>
                    </li>
                </ul>
            </div>
            <div>
                <h1 class="text-lg font-bold mb-4">{{ __('Categories') }}</h1>
                {{-- links --}}
                <ul class="text-sm space-y-2">
                    @foreach (\App\Models\Category::take(4)->get() as $item)
                        <li>
                            <a href="{{ route('web.products', ['category' => $item->id]) }}"
                                class="hover:text-blue-600 transition-colors">{{ $item->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h1 class="text-lg font-bold mb-4">{{ __('About Us') }}</h1>
                <p class="text-sm">
                    {{ __('Your trusted online shopping destination for quality products and exceptional service.') }}
                </p>
            </div>
            <div>
                <h1 class="text-lg font-bold mb-4">{{ __('Social Media') }}</h1>
                <ul class="text-sm space-y-2">
                    <li>
                        <a href="#" class="social-icon hover:text-blue-600 transition-colors">
                            <i class="fa-brands fa-facebook"></i> Facebook
                        </a>
                    </li>
                    <li>
                        <a href="#" class="social-icon hover:text-blue-600 transition-colors">
                            <i class="fa-brands fa-twitter"></i> Twitter
                        </a>
                    </li>
                    <li>
                        <a href="#" class="social-icon hover:text-blue-600 transition-colors">
                            <i class="fa-brands fa-instagram"></i> Instagram
                        </a>
                    </li>
                    <li>
                        <a href="#" class="social-icon hover:text-blue-600 transition-colors">
                            <i class="fa-brands fa-youtube"></i> Youtube
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
