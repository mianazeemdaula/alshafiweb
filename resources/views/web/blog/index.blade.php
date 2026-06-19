@extends('layouts.guest')

@section('content')
    <div class="bg-white dark:bg-gray-900 min-h-screen">
        <!-- Page Header -->
        <div class="border-b border-gray-100 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
                <div class="max-w-2xl">
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-400">{{ __('Articles') }}</span>
                    <h1 class="mt-3 text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                        {{ __('Blog') }}
                    </h1>
                    <p class="mt-3 text-base text-gray-500 dark:text-gray-400">
                        {{ __('Stay updated with our latest articles and insights') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
            <!-- Filters Toolbar -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 mb-8">
                <div class="flex flex-col lg:flex-row gap-4 items-stretch lg:items-center justify-between">
                    <!-- Search -->
                    <form action="{{ route('blog.index') }}" method="get" class="flex flex-1 max-w-md">
                        @foreach (collect(request()->query())->except(['search']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <input type="text" name="search"
                            class="flex-1 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-gray-100 rounded-l-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                            placeholder="{{ __('Search articles...') }}" value="{{ request('search') }}">
                        <button type="submit"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-r-xl text-sm font-medium transition-colors">
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </form>

                    <!-- Sort -->
                    <form action="{{ route('blog.index') }}" method="get" class="flex items-center gap-2">
                        @foreach (collect(request()->query())->except(['sort']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ __('sort_by') }}:</label>
                        <select name="sort"
                            class="border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-sm text-gray-900 dark:text-gray-100 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            onchange="this.form.submit()">
                            <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>{{ __('Newest') }}</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>{{ __('Oldest') }}</option>
                            <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>{{ __('Title A-Z') }}</option>
                        </select>
                    </form>
                </div>

                <!-- Category Pills -->
                <div class="flex flex-wrap gap-2 mt-5 pt-5 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}"
                        class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium transition-colors border {{ !request('category') ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700 hover:border-emerald-400' }}">
                        {{ __('All') }}
                    </a>
                    @foreach ($categories as $category)
                        <a href="{{ request()->fullUrlWithQuery(['category' => $category->slug]) }}"
                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium transition-colors border {{ request('category') == $category->slug ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700 hover:border-emerald-400' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Blog Posts Grid -->
            @if ($posts->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                    @foreach ($posts as $post)
                        <article class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors flex flex-col">
                            <!-- Post Image -->
                            <div class="aspect-[16/10] overflow-hidden bg-gray-50 dark:bg-gray-900">
                                @if ($post->image)
                                    <img src="{{ asset($post->image) }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300 dark:text-gray-600">
                                        <i class="fa-solid fa-newspaper text-4xl"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Post Content -->
                            <div class="p-6 flex-1 flex flex-col">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300">
                                        {{ $post->category->name }}
                                    </span>
                                    <span class="text-xs text-gray-400 dark:text-gray-500">
                                        {{ $post->created_at->format('M d, Y') }}
                                    </span>
                                </div>

                                <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                    <a href="{{ route('blog.post', $post->slug) }}">{{ $post->title }}</a>
                                </h2>

                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 line-clamp-3 flex-1">
                                    {{ Str::limit(strip_tags($post->content), 120) }}
                                </p>

                                <a href="{{ route('blog.post', $post->slug) }}"
                                    class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-600 dark:text-emerald-400 hover:gap-3 transition-all">
                                    {{ __('Read More') }}
                                    <i class="fa-solid fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4">
                    {{ $posts->links() }}
                </div>
            @else
                <!-- No Posts Found -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-12 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-50 dark:bg-gray-900 rounded-2xl mb-6">
                        <i class="fa-solid fa-newspaper text-3xl text-gray-300 dark:text-gray-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ __('No Articles Found') }}</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">{{ __('No articles match your current filters.') }}</p>
                    <a href="{{ route('blog.index') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition-colors">
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

