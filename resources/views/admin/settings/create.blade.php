@extends('layouts.web')

@section('content')
    <section class="mx-auto w-full max-w-4xl px-4 py-4">
        <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0 mb-6">
            <div>
                <h2 class="text-lg font-semibold">Create New Setting</h2>
                <p class="mt-1 text-sm text-gray-700">Add a new configuration setting</p>
            </div>
            <a href="{{ route('admin.settings.index') }}"
                class="px-5 text-gray-700 bg-gray-200 py-2 rounded-lg hover:bg-gray-300">
                Back to Settings
            </a>
        </div>

        @if ($errors->any())
            <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.settings.store') }}" method="POST" class="mt-6">
            @csrf

            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden p-6 space-y-6">
                <div>
                    <label for="key" class="block text-sm font-semibold text-gray-900 mb-2">
                        Key <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="key" id="key" value="{{ old('key') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="e.g., custom_css">
                    <p class="text-xs text-gray-500 mt-1">Unique identifier for this setting (use lowercase with
                        underscores)</p>
                </div>

                <div>
                    <label for="label" class="block text-sm font-semibold text-gray-900 mb-2">
                        Label <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="label" id="label" value="{{ old('label') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="e.g., Custom CSS">
                    <p class="text-xs text-gray-500 mt-1">Display name for this setting</p>
                </div>

                <div>
                    <label for="type" class="block text-sm font-semibold text-gray-900 mb-2">
                        Type <span class="text-red-500">*</span>
                    </label>
                    <select name="type" id="type" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="text" {{ old('type') === 'text' ? 'selected' : '' }}>Text</option>
                        <option value="textarea" {{ old('type') === 'textarea' ? 'selected' : '' }}>Textarea</option>
                        <option value="code" {{ old('type') === 'code' ? 'selected' : '' }}>Code</option>
                        <option value="number" {{ old('type') === 'number' ? 'selected' : '' }}>Number</option>
                        <option value="email" {{ old('type') === 'email' ? 'selected' : '' }}>Email</option>
                        <option value="url" {{ old('type') === 'url' ? 'selected' : '' }}>URL</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Input type for this setting</p>
                </div>

                <div>
                    <label for="group" class="block text-sm font-semibold text-gray-900 mb-2">
                        Group <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="group" id="group" value="{{ old('group') }}" required
                        list="existing-groups"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="e.g., theme">
                    <datalist id="existing-groups">
                        @foreach ($groups as $existingGroup)
                            <option value="{{ $existingGroup }}">
                        @endforeach
                    </datalist>
                    <p class="text-xs text-gray-500 mt-1">Group name to organize settings (can be existing or new)</p>
                </div>

                <div>
                    <label for="value" class="block text-sm font-semibold text-gray-900 mb-2">
                        Default Value
                    </label>
                    <textarea name="value" id="value" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('value') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Initial value for this setting (optional)</p>
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-900 mb-2">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Help text to explain this setting (optional)</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.settings.index') }}"
                    class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Create Setting
                </button>
            </div>
        </form>
    </section>
@endsection
