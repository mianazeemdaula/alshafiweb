@extends('layouts.admin')
@section('content')
    <div class="container mx-auto px-4 py-8 max-w-lg">
        <h1 class="text-2xl font-bold mb-6">Blog Category Details</h1>
        <div class="bg-white rounded shadow p-6">
            <div class="mb-4">
                <div class="font-medium">Name:</div>
                <div>{{ $blogCategory->name }}</div>
            </div>
            <div class="mb-4">
                <div class="font-medium">Slug:</div>
                <div>{{ $blogCategory->slug }}</div>
            </div>
            <div class="flex justify-end">
                <a href="{{ route('admin.blog-categories.edit', $blogCategory) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded mr-2">Edit</a>
                <form action="{{ route('admin.blog-categories.destroy', $blogCategory) }}" method="POST" class="inline"
                    onsubmit="return confirm('Delete this category?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Delete</button>
                </form>
            </div>
        </div>
        <div class="mt-6">
            <a href="{{ route('admin.blog-categories.index') }}" class="text-blue-600 hover:underline">&larr; Back to
                list</a>
        </div>
    </div>
@endsection
