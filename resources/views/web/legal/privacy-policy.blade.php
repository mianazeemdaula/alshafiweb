@extends('layouts.guest')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-8 lg:p-12 prose prose-lg dark:prose-invert max-w-none">
            {!! nl2br(e(file_get_contents(base_path('Alshaafi_Online_Privacy_Policy.md')))) !!}
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('web.home') }}"
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg shadow-lg">
                <i class="fas fa-home mr-2"></i>Back to Home
            </a>
        </div>
    </div>
@endsection
