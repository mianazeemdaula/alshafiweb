@extends('layouts.admin')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Blog Categories</h1>
            <a href="{{ route('admin.blog-categories.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Add Category</a>
        </div>
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
        @endif
        <div class="bg-white rounded shadow p-4">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-3 py-2 text-left">#</th>
                        <th class="px-3 py-2 text-left">Name</th>
                        <th class="px-3 py-2 text-left">Slug</th>
                        <th class="px-3 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $i => $category)
                        <tr class="border-b">
                            <td class="px-3 py-2">{{ $categories->firstItem() + $i }}</td>
                            <td class="px-3 py-2">{{ $category->name }}</td>
                            <td class="px-3 py-2">{{ $category->slug }}</td>
                            <td class="px-3 py-2">
                                <a href="{{ route('admin.blog-categories.show', $category) }}"
                                    class="text-blue-600 hover:underline mr-2">View</a>
                                <a href="{{ route('admin.blog-categories.edit', $category) }}"
                                    class="text-yellow-600 hover:underline mr-2">Edit</a>
                                <form action="{{ route('admin.blog-categories.destroy', $category) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">{{ $categories->links() }}</div>
        </div>
    </div>
@endsection
