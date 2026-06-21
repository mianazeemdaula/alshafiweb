@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex justify-between items-center gap-2">
        <div class="flex items-center gap-1.5">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="cursor-not-allowed inline-flex items-center px-3 py-2 rounded-l-xl border border-emerald-900/10 dark:border-emerald-800/40 bg-[#f6f3eb]/20 dark:bg-emerald-950/10 text-emerald-850/40 dark:text-emerald-300/40 text-sm opacity-50" aria-disabled="true"
                    aria-label="{{ __('pagination.previous') }}">
                    <svg class="h-4.5 w-4.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span>{{ __('pagination.previous') }}</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                    class="cursor-pointer relative inline-flex items-center px-3 py-2 rounded-l-xl border border-emerald-900/10 dark:border-emerald-800/40 bg-[#f6f3eb]/40 dark:bg-emerald-950/20 text-sm font-semibold text-emerald-800 dark:text-emerald-300 hover:bg-[#e5e0d4]/65 dark:hover:bg-emerald-900/40 focus:z-10 focus:outline-none focus:ring-4 focus:ring-emerald-100 dark:focus:ring-emerald-950/30 transition duration-150"
                    aria-label="{{ __('pagination.previous') }}">
                    <svg class="h-4.5 w-4.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span>{{ __('pagination.previous') }}</span>
                </a>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                    class="cursor-pointer relative inline-flex items-center px-3 py-2 rounded-r-xl border border-emerald-900/10 dark:border-emerald-800/40 bg-[#f6f3eb]/40 dark:bg-emerald-950/20 text-sm font-semibold text-emerald-800 dark:text-emerald-300 hover:bg-[#e5e0d4]/65 dark:hover:bg-emerald-900/40 focus:z-10 focus:outline-none focus:ring-4 focus:ring-emerald-100 dark:focus:ring-emerald-950/30 transition duration-150"
                    aria-label="{{ __('pagination.next') }}">
                    <span>{{ __('pagination.next') }}</span>
                    <svg class="h-4.5 w-4.5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @else
                <span class="cursor-not-allowed inline-flex items-center px-3 py-2 rounded-r-xl border border-emerald-900/10 dark:border-emerald-800/40 bg-[#f6f3eb]/20 dark:bg-emerald-950/10 text-emerald-850/40 dark:text-emerald-300/40 text-sm opacity-50" aria-disabled="true"
                    aria-label="{{ __('pagination.next') }}">
                    <span>{{ __('pagination.next') }}</span>
                    <svg class="h-4.5 w-4.5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            @endif
        </div>
    </nav>
@endif
