@extends('layouts.guest')
@section('content')
    <div class="py-12 bg-transparent min-h-screen">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-center mb-4 text-emerald-950 dark:text-emerald-100 font-serif font-playfair">Customer Reviews</h1>
            <p class="text-center text-emerald-850/70 dark:text-emerald-400 mb-10 max-w-md mx-auto text-sm sm:text-base">See what our customers are saying about Al Shaafi products and service.</p>

            @if ($reviews->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach ($reviews as $review)
                        <div
                            class="bg-white/90 dark:bg-emerald-950/20 rounded-2xl shadow-sm p-6 border border-emerald-900/10 dark:border-emerald-800/30 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center mb-4">
                                    <div
                                        class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-600 to-emerald-850 flex items-center justify-center text-white font-extrabold text-base mr-3.5 shadow-sm">
                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-emerald-950 dark:text-emerald-100 text-sm sm:text-base">{{ $review->user->name }}</div>
                                        <div class="text-[10px] font-semibold uppercase tracking-wider text-emerald-850/50 dark:text-emerald-400 mt-0.5">
                                            {{ $review->created_at->format('M d, Y') }}</div>
                                    </div>
                                </div>
                                <div class="mb-3.5">
                                    <span class="text-[10px] uppercase tracking-wider font-extrabold text-emerald-700 dark:text-emerald-350 bg-emerald-50 dark:bg-emerald-900/30 px-2.5 py-1.5 rounded-lg border border-emerald-900/10 dark:border-emerald-800/20">{{ $review->product->name ?? 'Product' }}</span>
                                </div>
                                <div class="flex items-center mb-3">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star text-amber-500 text-sm"></i>
                                    @endfor
                                    <span class="ml-2 text-xs font-bold text-emerald-850/50 dark:text-emerald-400">({{ $review->rating }}/5)</span>
                                </div>
                                <p class="text-emerald-850/80 dark:text-emerald-300 text-sm leading-relaxed mb-4 italic">"{{ $review->comment }}"</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8 bg-transparent">
                    {{ $reviews->links() }}
                </div>
            @else
                <div class="text-center py-16 bg-white/60 dark:bg-emerald-950/10 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/20 backdrop-blur-sm">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-50 dark:bg-emerald-900/30 rounded-2xl text-emerald-600 dark:text-emerald-400 text-3xl mb-6">
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <h3 class="text-xl font-bold text-emerald-950 dark:text-white mb-2 font-serif">No Reviews Yet</h3>
                    <p class="text-emerald-850/60 dark:text-emerald-450 text-sm">Be the first to leave a review for our products!</p>
                </div>
            @endif
        </div>
    </div>
@endsection
