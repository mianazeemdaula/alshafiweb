@extends('layouts.guest')

@section('title', $post->title ?? 'Blog Post')
@section('meta_description', $post->meta_description)
@section('meta_keywords', $post->meta_keywords)

@section('content')
    <div class="bg-transparent min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
            <!-- Breadcrumb -->
            <nav class="mb-8">
                <ol class="flex items-center flex-wrap gap-2 text-[10px] sm:text-xs uppercase tracking-wider font-semibold text-emerald-950/40 dark:text-emerald-300/40">
                    <li><a href="{{ route('web.home') }}" class="hover:text-emerald-700 dark:hover:text-emerald-250 transition-colors">{{ __('Home') }}</a></li>
                    <li><i class="fa-solid fa-chevron-right text-[10px] opacity-60"></i></li>
                    <li><a href="{{ route('blog.index') }}" class="hover:text-emerald-700 dark:hover:text-emerald-250 transition-colors">{{ __('Blog') }}</a></li>
                    <li><i class="fa-solid fa-chevron-right text-[10px] opacity-60"></i></li>
                    <li class="text-emerald-850 dark:text-emerald-250 truncate max-w-xs">{{ $post->title }}</li>
                </ol>
            </nav>

            <!-- Main Article -->
            <article class="bg-white/90 dark:bg-emerald-950/20 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/30 overflow-hidden mb-10 shadow-sm">
                <!-- Header -->
                <div class="p-6 sm:p-10">
                    <div class="flex items-center gap-3 flex-wrap mb-5">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 border border-emerald-900/10">
                            {{ $post->category->name }}
                        </span>
                        <span class="text-xs font-semibold text-emerald-850/50 dark:text-emerald-400 flex items-center gap-1.5">
                            <i class="fa-solid fa-calendar-days text-emerald-600"></i>
                            {{ $post->created_at->format('F d, Y') }}
                        </span>
                        @if ($post->user)
                            <span class="text-xs font-semibold text-emerald-850/50 dark:text-emerald-400 flex items-center gap-1.5">
                                <i class="fa-solid fa-user text-emerald-600"></i>
                                {{ $post->user->name }}
                            </span>
                        @endif
                    </div>

                    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-emerald-955 dark:text-white leading-tight mb-4 font-serif font-playfair">
                        {{ $post->title }}
                    </h1>

                    @if ($post->meta_description)
                        <p class="text-base sm:text-lg text-emerald-850/70 dark:text-emerald-400 leading-relaxed font-medium">
                            {{ $post->meta_description }}
                        </p>
                    @endif
                </div>

                <!-- Featured Image -->
                @if ($post->image)
                    <div class="aspect-[16/9] overflow-hidden bg-emerald-50 dark:bg-emerald-950/40">
                        <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="aspect-[16/9] bg-emerald-50 dark:bg-emerald-950/40 flex items-center justify-center text-emerald-700/20">
                        <i class="fa-solid fa-newspaper text-5xl"></i>
                    </div>
                @endif

                <!-- Content -->
                <div class="p-6 sm:p-10">
                    <div class="prose prose-lg dark:prose-invert max-w-none prose-headings:text-emerald-955 dark:prose-headings:text-white prose-a:text-emerald-750 dark:prose-a:text-emerald-405">
                        {!! $post->content !!}
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 sm:px-10 py-6 border-t border-emerald-900/10 dark:border-emerald-800/30 bg-emerald-50/10 dark:bg-[#0c120f]/30">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-850/50 dark:text-emerald-400">{{ __('Share:') }}</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank"
                                class="w-9 h-9 rounded-xl bg-white dark:bg-emerald-955/40 border border-emerald-900/10 dark:border-emerald-800/40 text-emerald-800 dark:text-emerald-350 hover:text-emerald-600 hover:border-emerald-405 flex items-center justify-center transition-all shadow-sm">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" target="_blank"
                                class="w-9 h-9 rounded-xl bg-white dark:bg-emerald-955/40 border border-emerald-900/10 dark:border-emerald-800/40 text-emerald-800 dark:text-emerald-350 hover:text-emerald-600 hover:border-emerald-405 flex items-center justify-center transition-all shadow-sm">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($post->title) }}" target="_blank"
                                class="w-9 h-9 rounded-xl bg-white dark:bg-emerald-955/40 border border-emerald-900/10 dark:border-emerald-800/40 text-emerald-800 dark:text-emerald-350 hover:text-emerald-600 hover:border-emerald-405 flex items-center justify-center transition-all shadow-sm">
                                <i class="fa-brands fa-linkedin"></i>
                            </a>
                        </div>

                        <a href="{{ route('blog.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2.5 border border-emerald-200 dark:border-emerald-800/50 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-800 dark:text-emerald-200 rounded-xl text-sm font-semibold transition-all hover:bg-emerald-100 dark:hover:bg-emerald-900/40 shadow-sm">
                            <i class="fa-solid fa-arrow-left"></i>
                            {{ __('Back to Blog') }}
                        </a>
                    </div>
                </div>
            </article>

            <!-- Related Articles -->
            @if ($relatedPosts->count() > 0)
                <div class="mt-12">
                    <h2 class="text-2xl font-bold tracking-tight text-emerald-955 dark:text-white mb-6 font-serif font-playfair">{{ __('Related Articles') }}</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($relatedPosts as $relatedPost)
                            <article class="group bg-white/90 dark:bg-emerald-950/20 border border-emerald-900/10 dark:border-emerald-800/30 hover:border-emerald-450 dark:hover:border-emerald-700 rounded-2xl overflow-hidden transition-all shadow-sm">
                                <div class="aspect-[16/10] overflow-hidden bg-emerald-50 dark:bg-emerald-950/40 relative">
                                    @if ($relatedPost->image)
                                        <img src="{{ asset('storage/' . $relatedPost->image) }}" alt="{{ $relatedPost->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-emerald-700/20">
                                            <i class="fa-solid fa-newspaper text-3xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-5">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 border border-emerald-900/10 mb-3">
                                        {{ $relatedPost->category->name }}
                                    </span>
                                    <h3 class="text-base font-bold text-emerald-950 dark:text-white mb-2 line-clamp-2 font-serif group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">
                                        <a href="{{ route('blog.post', $relatedPost->slug) }}">{{ $relatedPost->title }}</a>
                                    </h3>
                                    <p class="text-xs text-emerald-850/60 dark:text-emerald-400 mb-4 line-clamp-2 leading-relaxed">
                                        {{ Str::limit(strip_tags($relatedPost->content), 80) }}
                                    </p>
                                    <a href="{{ route('blog.post', $relatedPost->slug) }}"
                                        class="inline-flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400 hover:gap-2 text-xs font-bold transition-all">
                                        {{ __('Read More') }}
                                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('jsscript')
    <style>
        .prose { line-height: 1.75; }
        .prose p { margin-bottom: 1.25rem; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
@endsection
