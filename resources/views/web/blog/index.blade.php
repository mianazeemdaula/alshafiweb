@extends('layouts.guest')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="container mx-auto px-4">
            <!-- Page Header -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ __('Blog') }}</h1>
                <p class="text-gray-600">{{ __('Stay updated with our latest articles and insights') }}</p>
            </div>

            <!-- Filters and Search -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                    <!-- Search -->
                    <div class="flex-1 max-w-md">
                        <form action="{{ route('blog.index') }}" method="get" class="flex">
                            @foreach (collect(request()->query())->except(['search']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <input type="text" name="search"
                                class="flex-1 border border-gray-300 rounded-l-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="{{ __('Search articles...') }}" value="{{ request('search') }}">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-r-lg transition">
                                <i class="fa-solid fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Category Filter -->
                    <div class="flex gap-2 items-center">
                        <span class="text-sm text-gray-600">{{ __('Category') }}:</span>
                        <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}"
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium transition {{ !request('category') ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            {{ __('All') }}
                        </a>
                        @foreach ($categories as $category)
                            <a href="{{ request()->fullUrlWithQuery(['category' => $category->slug]) }}"
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium transition {{ request('category') == $category->slug ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>

                    <!-- Sort -->
                    <div class="flex gap-2 items-center">
                        <span class="text-sm text-gray-600">{{ __('sort_by') }}:</span>
                        <form action="{{ route('blog.index') }}" method="get" class="inline">
                            @foreach (collect(request()->query())->except(['sort']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <select name="sort" class="border border-gray-300 rounded px-3 py-1 text-sm"
                                onchange="this.form.submit()">
                                <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>
                                    {{ __('Newest') }}</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                    {{ __('Oldest') }}</option>
                                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>
                                    {{ __('Title A-Z') }}</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Blog Posts Grid -->
            @if ($posts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach ($posts as $post)
                        <article class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                            <!-- Post Image -->
                            <div
                                class="h-48 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                                @if ($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="text-white text-center">
                                        <i class="fa-solid fa-newspaper text-4xl mb-2"></i>
                                        <p class="text-sm font-medium">{{ $post->category->name }}</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Post Content -->
                            <div class="p-6">
                                <!-- Category and Date -->
                                <div class="flex items-center justify-between mb-3">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $post->category->name }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ $post->created_at->format('M d, Y') }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <h2 class="text-lg font-semibold text-gray-800 mb-3 line-clamp-2">
                                    <a href="{{ route('blog.post', $post->slug) }}" class="hover:text-blue-600 transition">
                                        {{ $post->title }}
                                    </a>
                                </h2>

                                <!-- Excerpt -->
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ Str::limit(strip_tags($post->content), 120) }}
                                </p>

                                <!-- Read More -->
                                <a href="{{ route('blog.post', $post->slug) }}"
                                    class="inline-flex items-center text-blue-600 hover:text-blue-700 text-sm font-medium transition">
                                    {{ __('Read More') }}
                                    <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    {{ $posts->links() }}
                </div>
            @else
                <!-- No Posts Found -->
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <i class="fa-solid fa-newspaper text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-medium text-gray-600 mb-2">{{ __('No Articles Found') }}</h3>
                    <p class="text-gray-500 mb-4">{{ __('No articles match your current filters.') }}</p>
                    <a href="{{ route('blog.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                        <i class="fa-solid fa-refresh mr-2"></i>
                        {{ __('View All Articles') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('jsscript')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
