<div>
    <select
        id="{{ $id ?? $name }}"
        name="{{ $name }}"
        class="flex h-11 w-full rounded-xl border border-emerald-900/10 dark:border-emerald-800/40 bg-[#f6f3eb]/40 dark:bg-emerald-950/20 px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-100 dark:focus:ring-emerald-950/30 focus:border-emerald-600 dark:text-white transition-all disabled:cursor-not-allowed disabled:opacity-50"
    >
        {{ $slot }}
    </select>
    @error($name) <span class="text-[#c94a4a] text-xs mt-1.5 font-medium">{{ $message }}</span> @enderror
</div>