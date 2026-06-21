<button
    type="{{ $type ?? 'button' }}"
    class="inline-flex w-full h-11 items-center justify-center rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white px-5 font-bold text-sm transition-all shadow-sm hover:shadow-md shadow-emerald-700/10"
>
    {{ $slot }}
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="16"
      height="16"
      viewBox="0 0 24 24"
      fill="none"
      stroke="currentColor"
      stroke-width="2"
      stroke-linecap="round"
      stroke-linejoin="round"
      class="ml-2"
    >
      <line x1="5" y1="12" x2="19" y2="12"></line>
      <polyline points="12 5 19 12 12 19"></polyline>
    </svg>
</button>