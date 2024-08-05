<div>
    <select
        id="{{ $id ?? $name }}"
        name="{{ $name }}"
        class="flex h-10 w-full rounded-md border border-gray-300 bg-transparent px-3 py-2 text-sm placeholder:text-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400 focus:ring-offset-1 disabled:cursor-not-allowed disabled:opacity-50"
    >
        {{ $slot }}
    </select>
    @error($name) <span class="text-red-500">{{ $message }}</span> @enderror
</div>