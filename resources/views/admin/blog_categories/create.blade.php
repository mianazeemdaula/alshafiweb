@extends('layouts.web')
@section('content')
    <div class="container mx-auto px-4 py-8 max-w-lg">
        <h1 class="text-2xl font-bold mb-6">Add Blog Category</h1>
        <form action="{{ route('admin.blog-categories.store') }}" method="POST" class="bg-white rounded shadow p-6">
            @csrf
            <div class="mb-4">
                <label class="block mb-1 font-medium">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2"
                    required>
                @error('name')
                    <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Slug <span class="text-xs text-gray-400">(optional)</span></label>
                <input type="text" name="slug" value="{{ old('slug') }}" class="w-full border rounded px-3 py-2">
                @error('slug')
                    <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex justify-end">
                <a href="{{ route('admin.blog-categories.index') }}" class="mr-4 text-gray-600">Cancel</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Create</button>
            </div>
        </form>
    </div>
@endsection
