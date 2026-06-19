@extends('layouts.guest')
@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-emerald-50 via-white to-teal-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 py-12 px-4 sm:px-6 lg:px-8">
        <div
            class="max-w-md w-full space-y-8 bg-white dark:bg-gray-800 rounded-2xl shadow-xl shadow-emerald-900/5 p-8 border border-gray-100 dark:border-gray-700">
            <div>
                <div class="flex justify-center">
                    <span class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <i class="fa-solid fa-leaf text-white text-2xl"></i>
                    </span>
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-gray-100">
                    {{ __('register.title') }}
                </h2>
                <p class="mt-2 text-center text-sm text-gray-500 dark:text-gray-400">alshaafi<span class="text-emerald-600 dark:text-emerald-400 font-semibold">online</span></p>
            </div>
            <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
                @csrf
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <input type="text" name="name" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="{{ __('register.name_placeholder') }}" value="{{ old('name') }}">
                    </div>
                    <div>
                        <input type="email" name="email" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="{{ __('register.email_placeholder') }}" value="{{ old('email') }}">
                    </div>
                    <div>
                        <input type="tel" name="mobile" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="{{ __('register.mobile_placeholder') }}" value="{{ old('mobile') }}">
                    </div>
                    <div>
                        <input type="password" name="password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="{{ __('register.password_placeholder') }}">
                    </div>
                    <div>
                        <input type="password" name="password_confirmation" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="{{ __('register.password_confirmation_placeholder') }}">
                    </div>
                    <div>
                        <input type="text" name="ref_code" id="ref_code"
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Referral code (optional)" value="{{ old('ref_code', request('ref')) }}">
                    </div>
                </div>

                @if ($errors->any())
                    <div class="text-red-600 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('register.create_account') }}
                    </button>
                </div>

                <div class="text-center">
                    <a href="/login"
                        class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                        {{ __('register.already_account') }} {{ __('register.signin') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
