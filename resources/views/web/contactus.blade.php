@extends('layouts.guest')
@section('title', 'Contact Us')
@section('content')

    <div class="p-8 bg-white dark:bg-gray-900 min-h-screen">
        <x-breadcrumb :links="[['name' => 'Home', 'link' => '/'], ['name' => 'Contact Us']]" />
        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
            {{ __('contactus.title') ?? 'Love to hear from you' }}
        </div>
        <div class="text-gray-600 dark:text-gray-300 mb-6">
            {{ __('contactus.subtitle') ?? 'Feel free to contact us. We will get back to as soon as we can.' }}
        </div>
        <div class="flex flex-col md:flex-row gap-8">
            <div
                class="md:w-8/12 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                <form action="" method="post" class="p-6">
                    <div class="flex flex-col space-y-4">
                        <div>
                            <label for="name"
                                class="block text-gray-700 dark:text-gray-200 mb-1">{{ __('contactus.name') ?? 'Name' }}</label>
                            <input type="text" name="name" id="name"
                                class="w-full border border-gray-300 dark:border-gray-600 p-2 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500"
                                placeholder="{{ __('contactus.name_placeholder') ?? 'Your name' }}">
                        </div>
                        <div>
                            <label for="email"
                                class="block text-gray-700 dark:text-gray-200 mb-1">{{ __('contactus.email') ?? 'Email' }}</label>
                            <input type="email" name="email" id="email"
                                class="w-full border border-gray-300 dark:border-gray-600 p-2 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500"
                                placeholder="{{ __('contactus.email_placeholder') ?? 'Your email' }}">
                        </div>
                        <div>
                            <label for="message"
                                class="block text-gray-700 dark:text-gray-200 mb-1">{{ __('contactus.message') ?? 'Message' }}</label>
                            <textarea name="message" id="message"
                                class="w-full border border-gray-300 dark:border-gray-600 p-2 rounded bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500"
                                placeholder="{{ __('contactus.message_placeholder') ?? 'Type your message...' }}"></textarea>
                        </div>
                        <div>
                            <button type="submit"
                                class="bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 text-white p-2 rounded font-medium transition-colors">{{ __('contactus.submit') ?? 'Submit' }}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="flex-1">
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                    <div class="text-xl font-light text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('contactus.info') ?? 'Contact Information' }}</div>
                    <div class="flex items-center mb-2">
                        <i class="fa fa-phone mx-1 text-gray-500 dark:text-gray-400"></i>
                        <div class="text-gray-700 dark:text-gray-300">
                            {{ __('contactus.helpline') ?? 'Helpline +92-322-3232727' }}</div>
                    </div>
                    <div class="border border-slate-100 dark:border-gray-700 h-4 mb-2"></div>
                    <div class="flex items-center mb-2">
                        <i class="fa fa-envelope mx-1 text-gray-500 dark:text-gray-400"></i>
                        <div>
                            <a href="mailto:info@alshaafionline.com"
                                class="hover:text-blue-600 dark:hover:text-blue-400 text-gray-700 dark:text-gray-300">info@alshafi.com</a>
                        </div>
                    </div>
                    <div class="border border-slate-100 dark:border-gray-700 h-4 mb-2"></div>
                    <div class="flex items-center">
                        <i class="fa fa-map-marker-alt mx-1 text-gray-500 dark:text-gray-400"></i>
                        <div class="text-gray-700 dark:text-gray-300">
                            {{ __('contactus.address') ?? 'Address: Alshaafi Dawakhna, MI City, Okara Road, Depalpur' }}
                        </div>
                    </div>
                </div>
                <div
                    class="mt-4 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                    <div class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3">
                        {{ __('contactus.location') ?? 'Location' }}
                    </div>
                    <div class="w-full h-64 rounded overflow-hidden">
                        <iframe src="https://maps.app.goo.gl/ZcXfob6ugZLpMsdP8?g_st=ic&output=embed" width="100%"
                            height="100%" frameborder="0" style="border:0;" allowfullscreen loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade" title="Alshaafi location"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
