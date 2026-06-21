<div class="flex items-center flex-wrap gap-2 text-[10px] sm:text-xs uppercase tracking-wider font-semibold text-emerald-950/40 dark:text-emerald-300/40">
    @foreach ($links ?? [] as $item)
        @if ($loop->last)
            <span class="text-emerald-850 dark:text-emerald-250 truncate max-w-[200px]">{{ $item['name'] }}</span>
        @else
            <a href="{{ $item['link'] ?? '#' }}" class="hover:text-emerald-700 dark:hover:text-emerald-250 transition-colors">{{ $item['name'] }}</a>
            <i class="fa-solid fa-chevron-right text-[10px] opacity-60"></i>
        @endif
    @endforeach
</div>
