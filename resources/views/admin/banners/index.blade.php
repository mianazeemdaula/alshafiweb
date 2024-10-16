@extends('layouts.web')

@section('content')
    <section class="mx-auto w-full h-screen max-w-7xl px-4 py-4">
        <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
            <div class="flex items-center justify-between min-w-full">
                <div>
                    <h2 class="text-lg font-semibold">Banners</h2>
                    <div class="flex items-center">
                        @foreach (\App\Models\Country::get() as $item)
                            <div class="px-1 @if (!$loop->last) border-r @endif">
                                <a href="{{ route('admin.banners.index', ['country' => $item->id]) }}"
                                    class="text-xs text-primary hover:text-gray-900">{{ $item->name }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <form action="{{ route('admin.banners.filter') }}" method="post">
                        @csrf
                        <input type="text" name="search" id="search"
                            class="border border-gray-200 rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-gray-200"
                            placeholder="Search" value="{{ request()->search }}" />
                        <button type="submit"
                            class="text-white bg-black px-5 py-2 rounded-lg hover:bg-gray-800">Search</button>
                    </form>
                    <a href="{{ route('admin.banners.create') }}"
                        class="px-5 text-white bg-black py-2 rounded-lg hover:bg-gray-800">Create</a>
                </div>
            </div>
        </div>
        <div class="mt-6 flex flex-col space-y-4">
            <!-- Table Layout for Larger Screens -->
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden border border-gray-200 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-2 py-2 text-left text-xs font-normal text-gray-700 sm:px-4 sm:py-3.5">
                                        Banner</th>
                                    <th scope="col"
                                        class="px-2 py-2 text-left text-xs font-normal text-gray-700 sm:px-4 sm:py-3.5">
                                        Description</th>
                                    <th scope="col"
                                        class="px-2 py-2 text-left text-xs font-normal text-gray-700 sm:px-4 sm:py-3.5">
                                        Status</th>
                                    <th scope="col"
                                        class="px-2 py-2 text-left text-xs font-normal text-gray-700 sm:px-4 sm:py-3.5">
                                        Start Date</th>
                                    <th scope="col"
                                        class="px-2 py-2 text-left text-xs font-normal text-gray-700 sm:px-4 sm:py-3.5">
                                        End Date</th>
                                    <th scope="col"
                                        class="px-2 py-2 text-left text-xs font-normal text-gray-700 sm:px-4 sm:py-3.5">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse ($banners as $item)
                                    <tr>
                                        <td class="whitespace-nowrap px-2 py-4 text-sm sm:px-4 sm:py-4">
                                            <div class="flex items-center space-x-4">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $item->title }}
                                                    </div>
                                                    <div class="text-sm text-gray-700">
                                                        {{ $item->country->name ?? '' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-2 py-2 text-sm sm:px-4 sm:py-4">
                                            {!! $item->description !!}
                                        </td>
                                        <td class="whitespace-nowrap px-2 py-2 text-sm sm:px-4 sm:py-4">
                                            <x-status-chip status="{{ $item->is_active ? 'Active' : 'Inactive' }}" />
                                        </td>
                                        <td class="whitespace-nowrap px-2 py-2 text-sm sm:px-4 sm:py-4">
                                            {{ $item->start_date }}
                                        </td>
                                        <td class="whitespace-nowrap px-2 py-2 text-sm sm:px-4 sm:py-4">
                                            {{ $item->end_date }}
                                        </td>
                                        <td class="px-2 py-2 text-xs text-right sm:px-4 sm:py-4 flex space-x-2">
                                            <a href="{{ route('admin.banners.show', $item->id) }}"
                                                class="text-primary hover:text-primary-dark">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.banners.edit', $item->id) }}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="http://">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="whitespace nowrap px-2 py-4 text-sm sm:px-4 sm:py-4" colspan="9">
                                            No products found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <x-pagging :paginator=$banners />
    </section>
@endsection
