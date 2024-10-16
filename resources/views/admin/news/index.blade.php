@extends('layouts.web')

@section('content')
    <section class="mx-auto w-full max-w-7xl px-4 py-4">
        <!-- Header Section -->
        <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
            <div>
                <h2 class="text-lg font-semibold">News</h2>
            </div>
            <div class="flex items-center space-x-2">
                <form action="{{ route('admin.news.filter') }}" method="post">
                    @csrf
                    <input type="text" name="search" id="search"
                        class="border border-gray-200 rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-gray-200"
                        placeholder="Search" value="{{ request()->search }}" />
                    <button type="submit"
                        class="text-white bg-black px-5 py-2 rounded-lg hover:bg-gray-800">Search</button>
                </form>
                <a href="{{ route('admin.news.create') }}"
                    class="px-5 text-white bg-black py-2 rounded-lg hover:bg-gray-800">
                    <i class="fa fa-add"></i> Create
                </a>
            </div>
        </div>

        <!-- Table Section for Desktop -->
        <div class="mt-6 hidden md:block">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden border border-gray-200 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                                        <span>Title</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-sm font-normal text-gray-700">
                                        Status
                                    </th>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                                        Link
                                    </th>
                                    <th scope="col" class="relative py-3.5">
                                        <span class="text-center text-sm font-normal text-gray-700">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($news as $item)
                                    <tr>
                                        <td class="whitespace-normal px-4 py-2">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    <img class="h-10 w-10 rounded-full object-cover"
                                                        src="{{ asset($item->image) }}" alt="User Image" />
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $item->title }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-2 text-sm text-gray-900">
                                            <x-status-chip :status="$item->is_active ? 'Active' : 'inactive'" />
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-2 text-sm text-gray-700">
                                            <a href="#">read</a>
                                        </td>
                                        <td class="px-4 py-2 text-right text-xs font-medium flex space-x-2">
                                            <a href="#" class="">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.posts.edit', $item->id) }}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.posts.destroy', $item->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit">
                                                    <i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <x-pagging :paginator=$news />
    </section>
@endsection
