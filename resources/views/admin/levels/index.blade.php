@extends('layouts.web')

@section('content')
    <section class="mx-auto w-full max-w-7xl px-4 py-4">
        <!-- Header Section -->
        <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
            <div>
                <h2 class="text-lg font-semibold">Items</h2>
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
                                        <span>Name/Title</span>
                                    </th>
                                    <th scope="col" class="px-12 py-3.5 text-left text-sm font-normal text-gray-700">
                                        Points
                                    </th>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                                        Off (%)
                                    </th>
                                    <th scope="col" class="relative py-3.5">
                                        <span class="text-center text-sm font-normal text-gray-700">View</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($levels as $item)
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-1">
                                            <div class="flex items-center">
                                                <div class="">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $item->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-700">
                                                        {{ $item->users()->count() }} users
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-12 py-1">
                                            <div class="text-sm text-gray-900">
                                                {{ $item->min_points }} points
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-1 text-sm text-gray-700">
                                            {{ $item->discount }}%
                                        </td>
                                        <td
                                            class="px-4 py-2 text-right text-xs font-medium flex items-center justify-center space-x-2">
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
        <x-pagging :paginator=$levels />
    </section>
@endsection
