<div>
    <select
        id="{{ $id ?? $name }}"
        name="{{ $name }}"
        class="outline-none bg-gray-100 border-gray-700 px-4 py-2 rounded-md w-full"
    >
        {{ $slot }}
    </select>
    @error($name) <span class="text-red-500">{{ $message }}</span> @enderror
</div>