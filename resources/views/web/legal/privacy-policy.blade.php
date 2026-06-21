@extends('layouts.guest')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="bg-white/90 dark:bg-emerald-950/20 rounded-2xl border border-emerald-900/10 dark:border-emerald-800/30 p-8 lg:p-12 prose prose-lg dark:prose-invert max-w-none shadow-sm">
            @php
                // Load markdown file and convert to HTML using League\CommonMark
                $mdPath = base_path('Alshaafi_Online_Privacy_Policy.md');
                $mdContent = file_exists($mdPath) ? file_get_contents($mdPath) : '';
                try {
                    $converter = new \League\CommonMark\CommonMarkConverter([
                        'html_input' => 'escape',
                        'allow_unsafe_links' => false,
                    ]);
                    $html = $converter->convertToHtml($mdContent);
                } catch (\Throwable $e) {
                    // Fallback: render raw markdown with line breaks
                    $html = nl2br(e($mdContent));
                }
            @endphp

            {!! $html !!}
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('web.home') }}"
                class="h-11 px-5 inline-flex items-center justify-center bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl font-bold text-sm transition-all shadow-sm hover:shadow-md shadow-emerald-700/10 cursor-pointer">
                <i class="fas fa-home mr-2 text-xs"></i>Back to Home
            </a>
        </div>
    </div>
@endsection
