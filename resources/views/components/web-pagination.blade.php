<div class="px-4 py-4 flex items-center justify-between border-t border-[#e2dcce] dark:border-[#1e332a] sm:px-6 bg-transparent">
    <div class="flex-1 flex justify-between sm:hidden">
        {{ $paginator->links('components.paginate') }}
    </div>
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-emerald-850/80 dark:text-emerald-350">
                Showing
                <span class="font-semibold text-emerald-950 dark:text-emerald-100">{{ $paginator->firstItem() ?? 0 }}</span>
                to
                <span class="font-semibold text-emerald-950 dark:text-emerald-100">{{ $paginator->lastItem() ?? 0 }}</span>
                of
                <span class="font-semibold text-emerald-950 dark:text-emerald-100">{{ $paginator->total() }}</span>
                results
            </p>
        </div>
        <div>
            {{ $paginator->links('components.paginate') }}
        </div>
    </div>
</div>
