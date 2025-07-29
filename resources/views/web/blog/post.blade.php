@extends('layouts.guest')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Breadcrumb -->
                <nav class="mb-6">
                    <ol class="flex items-center space-x-2 text-sm text-gray-600">
                        <li><a href="{{ route('web.home') }}" class="hover:text-blue-600">{{ __('Home') }}</a></li>
                        <li><i class="fa-solid fa-chevron-right text-xs"></i></li>
                        <li><a href="{{ route('blog.index') }}" class="hover:text-blue-600">{{ __('Blog') }}</a></li>
                        <li><i class="fa-solid fa-chevron-right text-xs"></i></li>
                        <li class="text-gray-400">{{ $post->title }}</li>
                    </ol>
                </nav>

                <!-- Main Article -->
                <article class="bg-white rounded-lg shadow-sm overflow-hidden mb-8">
                    <!-- Article Header -->
                    <div class="p-8 border-b border-gray-200">
                        <!-- Category and Meta -->
                        <div class="flex items-center justify-between mb-4">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $post->category->name }}
                            </span>
                            <div class="text-sm text-gray-500">
                                <span>{{ $post->created_at->format('F d, Y') }}</span>
                                @if ($post->user)
                                    <span class="ml-4">{{ __('By') }} {{ $post->user->name }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Title -->
                        <h1 class="text-3xl font-bold text-gray-900 mb-4 leading-tight">
                            {{ $post->title }}
                        </h1>

                        <!-- Meta Description -->
                        @if ($post->meta_description)
                            <p class="text-lg text-gray-600 leading-relaxed">
                                {{ $post->meta_description }}
                            </p>
                        @endif
                    </div>

                    <!-- Featured Image -->
                    @if ($post->image)
                        <div class="h-64 md:h-96">
                            <img src="{{ asset($post->image) }}" alt="{{ $post->title }}"
                                class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="h-64 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                            <div class="text-white text-center">
                                <i class="fa-solid fa-newspaper text-6xl mb-4"></i>
                                <p class="text-xl font-medium">{{ $post->category->name }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Article Content -->
                    <div class="p-8">
                        <div class="prose prose-lg max-w-none">
                            {!! nl2br(e($post->content)) !!}
                        </div>
                    </div>

                    <!-- Article Footer -->
                    <div class="p-8 border-t border-gray-200 bg-gray-50">
                        <div class="flex items-center justify-between">
                            <!-- Share Buttons -->
                            <div class="flex items-center space-x-3">
                                <span class="text-sm font-medium text-gray-700">{{ __('Share this article:') }}</span>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                    target="_blank" class="text-blue-600 hover:text-blue-700 transition">
                                    <i class="fa-brands fa-facebook text-lg"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}"
                                    target="_blank" class="text-blue-400 hover:text-blue-500 transition">
                                    <i class="fa-brands fa-twitter text-lg"></i>
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($post->title) }}"
                                    target="_blank" class="text-blue-700 hover:text-blue-800 transition">
                                    <i class="fa-brands fa-linkedin text-lg"></i>
                                </a>
                            </div>

                            <!-- Back to Blog -->
                            <a href="{{ route('blog.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
                                <i class="fa-solid fa-arrow-left mr-2"></i>
                                {{ __('Back to Blog') }}
                            </a>
                        </div>
                    </div>
                </article>

                <!-- Related Articles -->
                @if ($relatedPosts->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('Related Articles') }}</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach ($relatedPosts as $relatedPost)
                                <article
                                    class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                                    <!-- Post Image -->
                                    <div
                                        class="h-32 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                                        @if ($relatedPost->image)
                                            <img src="{{ asset('storage/' . $relatedPost->image) }}"
                                                alt="{{ $relatedPost->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="text-white text-center">
                                                <i class="fa-solid fa-newspaper text-2xl mb-1"></i>
                                                <p class="text-xs font-medium">{{ $relatedPost->category->name }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Post Content -->
                                    <div class="p-4">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-2">
                                            {{ $relatedPost->category->name }}
                                        </span>
                                        <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2">
                                            <a href="{{ route('blog.post', $relatedPost->slug) }}"
                                                class="hover:text-blue-600 transition">
                                                {{ $relatedPost->title }}
                                            </a>
                                        </h3>
                                        <p class="text-xs text-gray-600 mb-3 line-clamp-2">
                                            {{ Str::limit(strip_tags($relatedPost->content), 80) }}
                                        </p>
                                        <a href="{{ route('blog.post', $relatedPost->slug) }}"
                                            class="inline-flex items-center text-blue-600 hover:text-blue-700 text-xs font-medium transition">
                                            {{ __('Read More') }}
                                            <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('jsscript')
    <style>
        .prose {
            line-height: 1.7;
        }

        .prose p {
            margin-bottom: 1.5rem;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
