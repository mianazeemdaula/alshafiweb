@extends('layouts.guest')

@section('content')
    <div class="bg-transparent min-h-screen">
        <!-- Page Header -->
        <div class="border-b border-emerald-900/10 dark:border-emerald-800/20 bg-[#fdfcf9]/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
                <x-breadcrumb :links="[['name' => 'Home', 'link' => '/'], ['name' => 'Blog']]" />
                <div class="mt-6 max-w-2xl">
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-455">{{ __('Articles') }}</span>
                    <h1 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-tight text-emerald-950 dark:text-white font-playfair font-serif">
                        {{ __('Blog') }}
                    </h1>
                    <p class="mt-3 text-sm text-emerald-850/70 dark:text-emerald-400">
                        {{ __('Stay updated with our latest articles and insights') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
            <!-- Filters Toolbar -->
            <div class="bg-white/90 dark:bg-emerald-950/20 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/30 p-5 mb-8 shadow-sm">
                <div class="flex flex-col lg:flex-row gap-4 items-stretch lg:items-center justify-between">
                    <!-- Search -->
                    <form action="{{ route('blog.index') }}" method="get" class="flex flex-1 max-w-md">
                        @foreach (collect(request()->query())->except(['search']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <input type="text" name="search"
                            class="flex-1 h-10 border border-emerald-900/10 dark:border-emerald-800/40 bg-[#f6f3eb]/40 dark:bg-emerald-950/20 text-xs text-emerald-955 dark:text-gray-100 rounded-l-xl px-4 focus:outline-none focus:ring-4 focus:ring-emerald-100 dark:focus:ring-emerald-950/30 focus:border-emerald-650 placeholder-emerald-955/30"
                            placeholder="{{ __('Search articles...') }}" value="{{ request('search') }}">
                        <button type="submit"
                            class="h-10 bg-emerald-700 hover:bg-emerald-800 dark:bg-emerald-600 dark:hover:bg-emerald-500 text-white px-4 rounded-r-xl text-xs font-bold transition-all shadow-sm hover:shadow-md cursor-pointer flex items-center justify-center">
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </form>

                    <!-- Sort -->
                    <form action="{{ route('blog.index') }}" method="get" class="flex items-center gap-2">
                        @foreach (collect(request()->query())->except(['sort']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <label class="text-xs font-bold uppercase tracking-wider text-emerald-850/50 dark:text-emerald-400 whitespace-nowrap">{{ __('sort_by') }}:</label>
                        <select name="sort"
                            class="border border-emerald-900/10 dark:border-emerald-800/40 bg-[#f6f3eb]/40 dark:bg-emerald-950/20 text-sm text-emerald-950 dark:text-white rounded-xl px-3 py-2 focus:outline-none focus:ring-4 focus:ring-emerald-100 dark:focus:ring-emerald-950/30 focus:border-emerald-650 cursor-pointer"
                            onchange="this.form.submit()">
                            <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>{{ __('Newest') }}</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>{{ __('Oldest') }}</option>
                            <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>{{ __('Title A-Z') }}</option>
                        </select>
                    </form>
                </div>

                <!-- Category Pills -->
                <div class="flex flex-wrap gap-2 mt-5 pt-5 border-t border-emerald-900/10 dark:border-emerald-800/30">
                    <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}"
                        class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider transition-colors border {{ !request('category') ? 'bg-emerald-700 text-white border-emerald-700 dark:bg-emerald-600 dark:border-emerald-600' : 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-800 dark:text-emerald-200 border-emerald-250 dark:border-emerald-800/50 hover:bg-emerald-100 dark:hover:bg-emerald-900/40' }}">
                        {{ __('All') }}
                    </a>
                    @foreach ($categories as $category)
                        <a href="{{ request()->fullUrlWithQuery(['category' => $category->slug]) }}"
                            class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider transition-colors border {{ request('category') == $category->slug ? 'bg-emerald-700 text-white border-emerald-700 dark:bg-emerald-600 dark:border-emerald-600' : 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-800 dark:text-emerald-200 border-emerald-250 dark:border-emerald-800/50 hover:bg-emerald-100 dark:hover:bg-emerald-900/40' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Blog Posts Grid -->
            @if ($posts->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                    @foreach ($posts as $post)
                        <article class="group bg-white/90 dark:bg-emerald-950/20 rounded-2xl overflow-hidden border border-emerald-900/10 dark:border-emerald-800/30 hover:border-emerald-450 dark:hover:border-emerald-750 hover:shadow-md transition-all flex flex-col shadow-sm">
                            <!-- Post Image -->
                            <div class="aspect-[16/10] overflow-hidden bg-emerald-50 dark:bg-emerald-950/40 relative">
                                @if ($post->image)
                                    <img src="{{ asset($post->image) }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-emerald-700/20">
                                        <i class="fa-solid fa-newspaper text-5xl"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Post Content -->
                            <div class="p-6 flex-1 flex flex-col justify-between gap-4">
                                <div>
                                    <div class="flex items-center justify-between mb-3.5">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 border border-emerald-900/10">
                                            {{ $post->category->name }}
                                        </span>
                                        <span class="text-xs font-semibold text-emerald-850/50 dark:text-emerald-400">
                                            {{ $post->created_at->format('M d, Y') }}
                                        </span>
                                    </div>

                                    <h2 class="text-base sm:text-lg font-bold text-emerald-950 dark:text-white mb-2 line-clamp-2 font-serif group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">
                                        <a href="{{ route('blog.post', $post->slug) }}">{{ $post->title }}</a>
                                    </h2>

                                    <p class="text-sm text-emerald-850/70 dark:text-emerald-400 mb-2 line-clamp-3 leading-relaxed">
                                        {{ Str::limit(strip_tags($post->content), 120) }}
                                    </p>
                                </div>

                                <a href="{{ route('blog.post', $post->slug) }}"
                                    class="inline-flex items-center gap-1.5 text-sm font-bold text-emerald-700 dark:text-emerald-455 hover:gap-2.5 transition-all">
                                    {{ __('Read More') }}
                                    <i class="fa-solid fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="bg-white/95 dark:bg-emerald-950/20 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/30 p-4 shadow-sm">
                    {{ $posts->links('components.web-pagination') }}
                </div>
            @else
                <!-- No Posts Found -->
                <div class="bg-white/90 dark:bg-emerald-950/20 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/30 p-12 text-center backdrop-blur-sm shadow-sm">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-50 dark:bg-emerald-900/30 rounded-2xl mb-6 border border-emerald-900/10 dark:border-emerald-800/20">
                        <i class="fa-solid fa-newspaper text-3xl text-emerald-700/40"></i>
                    </div>
                    <h3 class="text-xl font-bold text-emerald-950 dark:text-white mb-2 font-serif">{{ __('No Articles Found') }}</h3>
                    <p class="text-emerald-850/60 dark:text-emerald-400 mb-6 text-sm">{{ __('No articles match your current filters.') }}</p>
                    <a href="{{ route('blog.index') }}"
                        class="inline-flex items-center gap-2 px-6 py-3.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-sm font-bold transition-all shadow-sm hover:shadow-md shadow-emerald-700/10 cursor-pointer">
                        {{ __('View All Articles') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('jsscript')
    <style>
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
@endsection
