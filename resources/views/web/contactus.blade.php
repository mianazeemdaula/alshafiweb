@extends('layouts.guest')
@section('title', 'Contact Us')
@section('content')
    <div class="bg-white dark:bg-gray-900">
        <!-- Page Header -->
        <div class="border-b border-gray-100 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
                <x-breadcrumb :links="[['name' => 'Home', 'link' => '/'], ['name' => 'Contact Us']]" />
                <div class="mt-6 max-w-2xl">
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-400">{{ __('Get In Touch') }}</span>
                    <h1 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                        {{ __('contactus.title') ?? 'Love to hear from you' }}
                    </h1>
                    <p class="mt-3 text-base text-gray-500 dark:text-gray-400">
                        {{ __('contactus.subtitle') ?? 'Feel free to contact us. We will get back to as soon as we can.' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- Form -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 sm:p-8">
                    <form action="" method="post" class="space-y-5">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('contactus.name') ?? 'Name' }}
                            </label>
                            <input type="text" name="name" id="name"
                                class="w-full border border-gray-200 dark:border-gray-700 px-4 py-3 rounded-xl bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                placeholder="{{ __('contactus.name_placeholder') ?? 'Your name' }}">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('contactus.email') ?? 'Email' }}
                            </label>
                            <input type="email" name="email" id="email"
                                class="w-full border border-gray-200 dark:border-gray-700 px-4 py-3 rounded-xl bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                placeholder="{{ __('contactus.email_placeholder') ?? 'Your email' }}">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('contactus.message') ?? 'Message' }}
                            </label>
                            <textarea name="message" id="message" rows="6"
                                class="w-full border border-gray-200 dark:border-gray-700 px-4 py-3 rounded-xl bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent resize-none"
                                placeholder="{{ __('contactus.message_placeholder') ?? 'Type your message...' }}"></textarea>
                        </div>
                        <div>
                            <button type="submit"
                                class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl text-sm font-semibold transition-colors">
                                <i class="fa-solid fa-paper-plane"></i>
                                {{ __('contactus.submit') ?? 'Send Message' }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Info Sidebar -->
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 sm:p-7">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-5">
                            {{ __('contactus.info') ?? 'Contact Information' }}
                        </h3>
                        <ul class="space-y-5">
                            <li class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-900/40 flex items-center justify-center flex-shrink-0">
                                    <i class="fa fa-phone text-sm text-emerald-600 dark:text-emerald-400"></i>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">Helpline</div>
                                    <a href="tel:+923253255555" class="text-sm text-gray-900 dark:text-gray-100 hover:text-emerald-600 dark:hover:text-emerald-400">+92 325 325 55 55</a>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-900/40 flex items-center justify-center flex-shrink-0">
                                    <i class="fa fa-envelope text-sm text-emerald-600 dark:text-emerald-400"></i>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">Email</div>
                                    <a href="mailto:info@alshaafionline.com" class="text-sm text-gray-900 dark:text-gray-100 hover:text-emerald-600 dark:hover:text-emerald-400 break-all">info@alshaafionline.com</a>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-900/40 flex items-center justify-center flex-shrink-0">
                                    <i class="fa fa-map-marker-alt text-sm text-emerald-600 dark:text-emerald-400"></i>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">Address</div>
                                    <div class="text-sm text-gray-900 dark:text-gray-100 leading-relaxed">Alshaafi Dawakhna, MI City, Okara Road, Depalpur</div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ __('Location') }}</h3>
                        </div>
                        <div class="aspect-[4/3]">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3431.515529108475!2d73.645788!3d30.6757681!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391805422bafa6d3%3A0xcd5a79457e9ba657!2zQUxTSEFBRkkgREFXQUtIQU5BIHwg2KfZhNi02KfZgduMINiv2YjYp9iu2KfZhtuB!5e0!3m2!1sen!2s!4v1761372606921!5m2!1sen!2s"
                                class="w-full h-full" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

