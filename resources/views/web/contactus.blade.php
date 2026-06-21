@extends('layouts.guest')
@section('title', 'Contact Us')
@section('content')
    <div class="bg-transparent">
        <!-- Page Header -->
        <div class="border-b border-emerald-900/10 dark:border-emerald-800/20 bg-[#fdfcf9]/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
                <x-breadcrumb :links="[['name' => 'Home', 'link' => '/'], ['name' => 'Contact Us']]" />
                <div class="mt-6 max-w-2xl">
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-450">{{ __('Get In Touch') }}</span>
                    <h1 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-tight text-emerald-950 dark:text-emerald-100 font-playfair font-serif">
                        {{ __('contactus.title') ?? 'Love to hear from you' }}
                    </h1>
                    <p class="mt-3 text-sm text-emerald-850/70 dark:text-emerald-400">
                        {{ __('contactus.subtitle') ?? 'Feel free to contact us. We will get back to as soon as we can.' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- Form -->
                <div class="lg:col-span-2 bg-white/90 dark:bg-emerald-950/20 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/30 p-6 sm:p-8 shadow-sm">
                    <form action="" method="post" class="space-y-5">
                        <div>
                            <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-emerald-950/60 dark:text-emerald-350 mb-2">
                                {{ __('contactus.name') ?? 'Name' }}
                            </label>
                            <input type="text" name="name" id="name"
                                class="flex h-11 w-full rounded-xl border border-emerald-900/10 dark:border-emerald-800/40 bg-[#f6f3eb]/40 dark:bg-emerald-950/20 px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-100 dark:focus:ring-emerald-950/30 focus:border-emerald-600 dark:text-white transition-all placeholder-emerald-950/30 dark:placeholder-emerald-400/30"
                                placeholder="{{ __('contactus.name_placeholder') ?? 'Your name' }}">
                        </div>
                        <div>
                            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-emerald-950/60 dark:text-emerald-350 mb-2">
                                {{ __('contactus.email') ?? 'Email' }}
                            </label>
                            <input type="email" name="email" id="email"
                                class="flex h-11 w-full rounded-xl border border-emerald-900/10 dark:border-emerald-800/40 bg-[#f6f3eb]/40 dark:bg-emerald-950/20 px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-100 dark:focus:ring-emerald-950/30 focus:border-emerald-600 dark:text-white transition-all placeholder-emerald-950/30 dark:placeholder-emerald-400/30"
                                placeholder="{{ __('contactus.email_placeholder') ?? 'Your email' }}">
                        </div>
                        <div>
                            <label for="message" class="block text-xs font-semibold uppercase tracking-wider text-emerald-950/60 dark:text-emerald-350 mb-2">
                                {{ __('contactus.message') ?? 'Message' }}
                            </label>
                            <textarea name="message" id="message" rows="6"
                                class="w-full rounded-xl border border-emerald-900/10 dark:border-emerald-800/40 bg-[#f6f3eb]/40 dark:bg-emerald-950/20 px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-100 dark:focus:ring-emerald-950/30 focus:border-emerald-600 dark:text-white transition-all placeholder-emerald-950/30 dark:placeholder-emerald-400/30 resize-none"
                                placeholder="{{ __('contactus.message_placeholder') ?? 'Type your message...' }}"></textarea>
                        </div>
                        <div>
                            <button type="submit"
                                class="h-11 inline-flex items-center justify-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white px-5 rounded-xl text-sm font-bold transition-all shadow-sm hover:shadow-md shadow-emerald-700/10 cursor-pointer">
                                <i class="fa-solid fa-paper-plane text-xs"></i>
                                {{ __('contactus.submit') ?? 'Send Message' }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Info Sidebar -->
                <div class="space-y-6">
                    <div class="bg-white/90 dark:bg-emerald-950/20 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/30 p-6 sm:p-7 shadow-sm">
                        <h3 class="text-lg font-bold text-emerald-950 dark:text-emerald-100 font-serif mb-6">
                            {{ __('contactus.info') ?? 'Contact Information' }}
                        </h3>
                        <ul class="space-y-6">
                            <li class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/40 flex items-center justify-center flex-shrink-0 border border-emerald-900/10 dark:border-emerald-800/20">
                                    <i class="fa fa-phone text-emerald-700 dark:text-emerald-400"></i>
                                </div>
                                <div>
                                    <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-850/50 dark:text-emerald-400 mb-1">Helpline</div>
                                    <a href="tel:+923253255555" class="text-sm font-bold text-emerald-950 dark:text-emerald-100 hover:text-emerald-700 dark:hover:text-emerald-400">+92 325 325 55 55</a>
                                </div>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/40 flex items-center justify-center flex-shrink-0 border border-emerald-900/10 dark:border-emerald-800/20">
                                    <i class="fa fa-envelope text-emerald-700 dark:text-emerald-400"></i>
                                </div>
                                <div>
                                    <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-850/50 dark:text-emerald-400 mb-1">Email</div>
                                    <a href="mailto:info@alshaafionline.com" class="text-sm font-bold text-emerald-950 dark:text-emerald-100 hover:text-emerald-700 dark:hover:text-emerald-400 break-all">info@alshaafionline.com</a>
                                </div>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/40 flex items-center justify-center flex-shrink-0 border border-emerald-900/10 dark:border-emerald-800/20">
                                    <i class="fa fa-map-marker-alt text-emerald-700 dark:text-emerald-400"></i>
                                </div>
                                <div>
                                    <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-850/50 dark:text-emerald-400 mb-1">Address</div>
                                    <div class="text-sm font-semibold text-emerald-950 dark:text-emerald-100 leading-relaxed">Alshaafi Dawakhna, MI City, Okara Road, Depalpur</div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-white/90 dark:bg-emerald-950/20 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/30 overflow-hidden shadow-sm">
                        <div class="px-6 py-4 border-b border-emerald-900/10 dark:border-emerald-800/30">
                            <h3 class="text-base font-bold text-emerald-950 dark:text-emerald-100 font-serif">{{ __('Location') }}</h3>
                        </div>
                        <div class="aspect-[4/3]">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3431.515529108475!2d73.645788!3d30.6757681!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391805422bafa6d3%3A0xcd5a79457e9ba657!2zQUxTSEFBRkkgREFXQUtIQU5BIHwg2KfZhNi02KfZgduMINiv2YjYp9iu2KfZhtuB!5e0!3m2!1sen!2s!4v1761372606921!5m2!1sen!2s"
                                class="w-full h-full grayscale dark:invert-[0.9] dark:hue-rotate-180" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
