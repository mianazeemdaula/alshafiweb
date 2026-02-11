@extends('layouts.web')

@section('content')
    <section class="mx-auto w-full h-screen max-w-7xl px-4 py-4">
        <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
            <div class="flex items-center justify-between min-w-full">
                <div>
                    <h2 class="text-lg font-semibold">Site Settings</h2>
                    <p class="mt-1 text-sm text-gray-700">Manage your site configuration and theme settings</p>
                </div>
                <div class="flex items-center space-x-2">
                    <form action="{{ route('admin.settings.clear-cache') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 text-white bg-yellow-600 py-2 rounded-lg hover:bg-yellow-700">
                            Clear Cache
                        </button>
                    </form>
                    <a href="{{ route('admin.settings.create') }}"
                        class="px-5 text-white bg-black py-2 rounded-lg hover:bg-gray-800">
                        Add New Setting
                    </a>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-6 space-y-6">
            @foreach ($settings as $group => $groupSettings)
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-semibold capitalize">{{ str_replace('_', ' ', $group) }} Settings</h3>
                        <a href="{{ route('admin.settings.edit', $group) }}"
                            class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 text-sm">
                            Edit Group
                        </a>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach ($groupSettings as $setting)
                            <div class="px-6 py-4 flex justify-between items-start">
                                <div class="flex-1">
                                    <h4 class="text-sm font-semibold text-gray-900">{{ $setting->label }}</h4>
                                    @if ($setting->description)
                                        <p class="text-xs text-gray-500 mt-1">{{ $setting->description }}</p>
                                    @endif
                                    <p class="text-xs text-gray-400 mt-1">Key: <code
                                            class="bg-gray-100 px-1 rounded">{{ $setting->key }}</code></p>
                                    @if ($setting->value && $setting->type !== 'code')
                                        <p class="text-sm text-gray-700 mt-2">
                                            {{ Str::limit($setting->value, 100) }}
                                        </p>
                                    @elseif ($setting->value && $setting->type === 'code')
                                        <p class="text-xs text-green-600 mt-2">✓ Code is set</p>
                                    @else
                                        <p class="text-xs text-gray-400 mt-2 italic">Not set</p>
                                    @endif
                                </div>
                                <div class="flex items-center space-x-2 ml-4">
                                    <a href="{{ route('admin.settings.edit-single', $setting->id) }}"
                                        class="px-3 py-1 text-xs text-blue-600 border border-blue-600 rounded hover:bg-blue-50">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.settings.destroy', $setting->id) }}" method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this setting?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 text-xs text-red-600 border border-red-600 rounded hover:bg-red-50">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
