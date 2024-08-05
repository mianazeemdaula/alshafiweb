<div>
    <input
    class="flex h-10 w-full rounded-md border border-gray-300 bg-transparent px-3 py-2 text-sm placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400 focus:ring-offset-1 disabled:cursor-not-allowed disabled:opacity-50"
    type="{{ $type ?? 'text' }}"
    placeholder="{{ $placeholder ?? '' }}"
    id="{{ $name }}"
    name="{{ $name }}"
    value="{{ $value ?? '' }}"
    required="{{ $required ?? false }}"
    />
    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
    @enderror
</div>