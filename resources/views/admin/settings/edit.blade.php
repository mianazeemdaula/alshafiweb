@extends('layouts.web')

@section('content')
    <section class="mx-auto w-full h-screen max-w-7xl px-4 py-4">
        <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0 mb-6">
            <div>
                <h2 class="text-lg font-semibold capitalize">Edit {{ str_replace('_', ' ', $group) }} Settings</h2>
                <p class="mt-1 text-sm text-gray-700">Update your {{ $group }} configuration</p>
            </div>
            <a href="{{ route('admin.settings.index') }}"
                class="px-5 text-gray-700 bg-gray-200 py-2 rounded-lg hover:bg-gray-300">
                Back to Settings
            </a>
        </div>

        @if (session('success'))
            <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.settings.update', $group) }}" method="POST" class="mt-6">
            @csrf
            @method('PUT')

            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="divide-y divide-gray-200">
                    @foreach ($settings as $setting)
                        <div class="px-6 py-6">
                            <label for="{{ $setting->key }}" class="block text-sm font-semibold text-gray-900 mb-1">
                                {{ $setting->label }}
                            </label>
                            @if ($setting->description)
                                <p class="text-xs text-gray-500 mb-3">{{ $setting->description }}</p>
                            @endif

                            @if ($setting->type === 'text' || $setting->type === 'email' || $setting->type === 'url' || $setting->type === 'number')
                                <input type="{{ $setting->type }}" name="{{ $setting->key }}" id="{{ $setting->key }}"
                                    value="{{ old($setting->key, $setting->value) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @elseif($setting->type === 'textarea')
                                <textarea name="{{ $setting->key }}" id="{{ $setting->key }}" rows="4"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old($setting->key, $setting->value) }}</textarea>
                            @elseif($setting->type === 'code')
                                <textarea name="{{ $setting->key }}" id="{{ $setting->key }}" rows="10"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono text-sm"
                                    placeholder="<!-- Enter your code here -->">{{ old($setting->key, $setting->value) }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">You can paste HTML, CSS, or JavaScript code here</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.settings.index') }}"
                    class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Save Changes
                </button>
            </div>
        </form>
    </section>
@endsection
