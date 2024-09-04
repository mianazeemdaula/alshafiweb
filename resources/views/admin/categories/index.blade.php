@extends('layouts.web')

@section('content')
    <section class="mx-auto w-full h-screen max-w-7xl px-4 py-4">
        <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
            <div class="flex items-center justify-between min-w-full">
                <h2 class="text-lg font-semibold">Categories</h2>
                <a href="{{ route('admin.categories.create') }}"
                    class="px-5 text-white bg-black py-2 rounded-lg hover:bg-gray-800">Create</a>
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
                                            <td class="whitespace-nowrap px-2 py-2 text-sm sm:px-4 sm:py-2">
                                                <div class="flex items-center space-x-4">
                                                    <img class="h-10 w-10 rounded-full object-cover"
                                                        src="{{ asset($item->image) }}" alt="Category Image" />
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap px-2 py-4 text-sm sm:px-4 sm:py-4">
                                                {{ $item->name }}
                                            </td>

                                            <td
                                                class="whitespace-nowrap px-2 py-4 text-sm font-medium text-right sm:px-4 sm:py-4 flex space-x-2">
                                                <a href="#" class="">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.categories.edit', $item->id) }}">
                                                    <i class="fa fa-wrench"></i>
                                                </a>
                                                <a href="#">
                                                    <i class="fa fa-trash"></i>
                                                </a>
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
