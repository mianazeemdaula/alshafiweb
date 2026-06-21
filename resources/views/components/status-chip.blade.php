<div>
    @php
        $class = 'bg-slate-100 text-slate-800 border border-slate-200 dark:bg-slate-900/40 dark:text-slate-300 dark:border-slate-800/50';
        switch (strtolower($status)) {
            case 1:
            case 'active':
            case 'completed':
                $class = 'bg-emerald-100 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-900/50';
                break;
            case 'inactive':
            case 'cancelled':
                $class = 'bg-rose-100 text-rose-800 border border-rose-200 dark:bg-rose-950/40 dark:text-rose-300 dark:border-rose-900/50';
                break;
            case 'pending':
                $class = 'bg-amber-100 text-amber-800 border border-amber-200 dark:bg-amber-950/40 dark:text-amber-300 dark:border-amber-900/50';
                break;
        }
    @endphp
    <span class="px-2.5 py-0.5 inline-flex items-center text-xs font-semibold rounded-full {{ $class }}">
        {{ ucFirst($status) }}
    </span>
</div>
