@extends('layouts.web')

@section('content')
    <section class="mx-auto w-full h-screen max-w-7xl px-4 py-4">
        <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
            <div class="flex flex-col md:flex-row items-center justify-between min-w-full">
                <h2 class="text-lg font-semibold">Categories</h2>
                <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 items-center space-x-2">
                    <form action="" method="post">
                        @csrf
                        <input type="text" name="search" id="search"
                            class="px-2 py-2 text-sm border border-gray-200 rounded-lg" placeholder="Search" />
                        <button type="submit"
                            class="px-5 text-white bg-primary py-2 rounded-lg hover:bg-primary-dark">Search</button>
                    </form>
                    <a href="{{ route('admin.categories.create') }}"
                        class="px-5 text-white bg-primary py-2 rounded-lg hover:bg-primary-dark">
                        <i class="fa-solid fa-add"></i> Create
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-6 flex flex-col space-y-4">
            <!-- Table Layout for Larger Screens -->
            <div class="">
                <div class="overflow-x-auto">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden border border-gray-200 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-2 py-2 text-left text-xs font-normal text-gray-700 sm:px-4 sm:py-3.5">
                                            Image</th>
                                        <th scope="col"
                                            class="px-2 py-2 text-left text-xs font-normal text-gray-700 sm:px-4 sm:py-3.5">
                                            Name</th>
                                        <th scope="col"
                                            class="px-2 py-2 text-left text-xs font-normal text-gray-700 sm:px-4 sm:py-3.5">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @if ($categories->isEmpty())
                                        <tr>
                                            <td class="whitespace nowrap px-2 py-4 text-sm sm:px-4 sm:py-4" colspan="9">
                                                No products found</td>
                                        </tr>
                                    @endif
                                    @foreach ($categories as $item)
                                        <tr>
                                            <td class="whitespace-nowrap px-2 py-1 text-sm sm:px-4 sm:py-1">
                                                <div class="flex items-center space-x-4">
                                                    <img class="h-10 w-10 rounded-full object-cover"
                                                        src="{{ asset($item->image) }}" alt="Category Image" />
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap px-2 py-1 text-sm sm:px-4 sm:py-1">
                                                {{ $item->name }}
                                            </td>

                                            <td
                                                class="px-2 py-1 text-xs font-medium text-right sm:px-4 sm:py-1 flex space-x-2">
                                                <a href="#" class="">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.categories.edit', $item->id) }}">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.categories.destroy', $item->id) }}"
                                                    method="post">
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
        </div>
        {{-- <x-pagging :paginator=$products /> --}}
        <div class="py-4">
            {{ $categories->links() }}
        </div>
    </section>
@endsection
