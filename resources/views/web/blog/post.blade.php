@extends('layouts.guest')

@section('title', $post->title ?? 'Blog Post')
@section('meta_description', $post->meta_description)
@section('meta_keywords', $post->meta_keywords)

@section('content')
    <div class="bg-white dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
            <!-- Breadcrumb -->
            <nav class="mb-8">
                <ol class="flex items-center flex-wrap gap-2 text-xs text-gray-500 dark:text-gray-400">
                    <li><a href="{{ route('web.home') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400">{{ __('Home') }}</a></li>
                    <li><i class="fa-solid fa-chevron-right text-[10px] text-gray-300"></i></li>
                    <li><a href="{{ route('blog.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400">{{ __('Blog') }}</a></li>
                    <li><i class="fa-solid fa-chevron-right text-[10px] text-gray-300"></i></li>
                    <li class="text-gray-700 dark:text-gray-300 truncate max-w-xs">{{ $post->title }}</li>
                </ol>
            </nav>

            <!-- Main Article -->
            <article class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden mb-10">
                <!-- Header -->
                <div class="p-6 sm:p-10">
                    <div class="flex items-center gap-3 flex-wrap mb-5">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300">
                            {{ $post->category->name }}
                        </span>
                        <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1.5">
                            <i class="fa-solid fa-calendar-days"></i>
                            {{ $post->created_at->format('F d, Y') }}
                        </span>
                        @if ($post->user)
                            <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1.5">
                                <i class="fa-solid fa-user"></i>
                                {{ $post->user->name }}
                            </span>
                        @endif
                    </div>

                    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white leading-tight mb-4">
                        {{ $post->title }}
                    </h1>

                    @if ($post->meta_description)
                        <p class="text-lg text-gray-500 dark:text-gray-400 leading-relaxed">
                            {{ $post->meta_description }}
                        </p>
                    @endif
                </div>

                <!-- Featured Image -->
                @if ($post->image)
                    <div class="aspect-[16/9] overflow-hidden bg-gray-50 dark:bg-gray-900">
                        <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="aspect-[16/9] bg-gray-50 dark:bg-gray-900 flex items-center justify-center text-gray-300 dark:text-gray-600">
                        <i class="fa-solid fa-newspaper text-5xl"></i>
                    </div>
                @endif

                <!-- Content -->
                <div class="p-6 sm:p-10">
                    <div class="prose prose-lg dark:prose-invert max-w-none prose-headings:text-gray-900 dark:prose-headings:text-white prose-a:text-emerald-600 dark:prose-a:text-emerald-400">
                        {!! $post->content !!}
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 sm:px-10 py-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Share:') }}</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank"
                                class="w-9 h-9 rounded-lg bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:text-emerald-600 hover:border-emerald-400 flex items-center justify-center transition-colors">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" target="_blank"
                                class="w-9 h-9 rounded-lg bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:text-emerald-600 hover:border-emerald-400 flex items-center justify-center transition-colors">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($post->title) }}" target="_blank"
                                class="w-9 h-9 rounded-lg bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:text-emerald-600 hover:border-emerald-400 flex items-center justify-center transition-colors">
                                <i class="fa-brands fa-linkedin"></i>
                            </a>
                        </div>

                        <a href="{{ route('blog.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:border-emerald-400 text-gray-700 dark:text-gray-300 rounded-xl text-sm font-medium transition-colors">
                            <i class="fa-solid fa-arrow-left"></i>
                            {{ __('Back to Blog') }}
                        </a>
                    </div>
                </div>
            </article>

            <!-- Related Articles -->
            @if ($relatedPosts->count() > 0)
                <div>
                    <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white mb-6">{{ __('Related Articles') }}</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($relatedPosts as $relatedPost)
                            <article class="group bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 hover:border-emerald-300 dark:hover:border-emerald-700 rounded-2xl overflow-hidden transition-colors">
                                <div class="aspect-[16/10] overflow-hidden bg-gray-50 dark:bg-gray-900">
                                    @if ($relatedPost->image)
                                        <img src="{{ asset('storage/' . $relatedPost->image) }}" alt="{{ $relatedPost->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300 dark:text-gray-600">
                                            <i class="fa-solid fa-newspaper text-3xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-5">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 mb-3">
                                        {{ $relatedPost->category->name }}
                                    </span>
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                        <a href="{{ route('blog.post', $relatedPost->slug) }}">{{ $relatedPost->title }}</a>
                                    </h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4 line-clamp-2">
                                        {{ Str::limit(strip_tags($relatedPost->content), 80) }}
                                    </p>
                                    <a href="{{ route('blog.post', $relatedPost->slug) }}"
                                        class="inline-flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400 hover:gap-2 text-xs font-semibold transition-all">
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

