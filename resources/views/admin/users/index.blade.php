@extends('layouts.web')

@section('content')
    <section class="mx-auto max-w-7xl px-4 max-[375px]:px-0 py-4">
        <!-- Header Section -->
        <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
            <div>
                <h2 class="text-lg font-semibold">Users</h2>
                <div class="flex items center">
                    @foreach (\Spatie\Permission\Models\Role::get() as $item)
                        <div class="px-1 @if (!$loop->last) border-r @endif">
                            <a href="{{ route('admin.users.index', ['role' => $item->name]) }}"
                                class="text-xs text-primary hover:text-gray-900">{{ $item->name }}</a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <form action="{{ route('admin.products.filter') }}" method="post">
                    @csrf
                    <input type="text" name="search" id="search"
                        class="border border-gray-200 rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-gray-200"
                        placeholder="Search" value="{{ request()->search }}" />
                    <button type="submit"
                        class="text-white bg-black px-5 py-2 rounded-lg hover:bg-gray-800">Search</button>
                </form>
                <a href="{{ route('admin.users.create') }}"
                    class="px-5 text-white bg-black py-2 rounded-lg hover:bg-gray-800">
                    <i class="fa-solid fa-add"></i> Create
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
                                        <span>User</span>
                                    </th>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                                        Email
                                    </th>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                                        Phone
                                    </th>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                                        Level
                                    </th>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                                        Extra Discount
                                    </th>
                                    <th scope="col" class="relative py-3.5">
                                        <span class="text-center text-sm font-normal text-gray-700">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($users as $item)
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-2">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    <img class="h-10 w-10 rounded-full object-cover"
                                                        src="https://images.unsplash.com/photo-1628157588553-5eeea00af15c?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=1160&amp;q=80"
                                                        alt="" />
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $item->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-2">
                                            <div class="text-sm text-gray-900">
                                                {{ $item->email }}
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-2">
                                            <span
                                                class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
                                                {{ $item->mobile }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-2 text-sm text-gray-700">
                                            {{ $item->level->name ?? '' }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-2 text-sm text-gray-700">
                                            {{ $item->extra_discount ?? '' }}
                                        </td>
                                        <td class="px-4 py-2 text-right text-xs font-medium flex space-x-2">
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

        <x-pagging :paginator=$users />
    </section>
@endsection
