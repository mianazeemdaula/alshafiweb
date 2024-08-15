@extends('layouts.web')

@section('content')
<section class="mx-auto w-full max-w-7xl px-4 py-4">
    <!-- Header Section -->
    <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
        <div>
            <h2 class="text-lg font-semibold">Users</h2>
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
                                <th scope="col" class="px-6 py-3.5 text-left text-sm font-normal text-gray-700">
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
                            @foreach($posts as $item)
                            <tr>
                                <td class="whitespace-nowrap px-4 py-2">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img
                                                class="h-10 w-10 rounded-full object-cover"
                                                src="{{ $item->image }}"
                                                alt="User Image"
                                            />
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $item->title }}
                                            </div>
                                            <div class="text-sm text-gray-700">
                                                {{ $item->category->name ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-2 text-sm text-gray-900">
                                    {{ $item->email }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2">
                                    <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
                                        {{ $item->mobile }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-2 text-sm text-gray-700">
                                    {{ $item->level->name ?? '' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2 text-sm text-gray-700">
                                    {{ $item->extra_discount ?? '' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-2 text-right text-sm font-medium flex space-x-2">
                                    <a href="#" class="text-gray-700 hover:text-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2">
                                            <path strokeLinecap="round" strokeLinejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm7.5 0c-.914 3.407-4.104 6-7.5 6s-6.586-2.593-7.5-6c.914-3.407 4.104-6 7.5-6s6.586 2.593 7.5 6z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.posts.edit', $item->id) }}" class="text-gray-700 hover:text-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 19h-2a1 1 0 01-1-1v-2a1 1 0 01.293-.707l8.59-8.59a1.5 1.5 0 012.12 0l2.12 2.12a1.5 1.5 0 010 2.12l-8.59 8.59A1 1 0 0111 19z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 17l-3-3m0 0l1-1m-1 1l-1-1m1 1h1.5m3-5.5L14 9m-1 1L11.5 7.5" />
                                        </svg>
                                    </a>
                                    <a href="http://" class="text-gray-700 hover:text-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
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

    <!-- Card Section for Mobile -->
    <div class="mt-6 md:hidden">
        <!-- Dummy Data -->
        <div class="mb-4 border border-gray-200 rounded-lg bg-white p-4">
            <div class="flex items-center">
                <div class="h-12 w-12 flex-shrink-0">
                    <img
                        class="h-12 w-12 rounded-full object-cover"
                        src="https://images.unsplash.com/photo-1628157588553-5eeea00af15c?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=1160&amp;q=80"
                        alt="Dummy User"
                    />
                </div>
                <div class="ml-4 flex-1">
                    <div class="text-lg font-semibold text-gray-900">
                        John Doe
                    </div>
                    <div class="text-sm text-gray-700">
                        Admin
                    </div>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-700">
                <div>Email: john.doe@example.com</div>
                <div>Phone: <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
                    +1234567890
                </span></div>
                <div>Level: Super Admin</div>
                <div>Extra Discount: 20%</div>
            </div>
            <div class="mt-4 flex space-x-2">
                <a href="#" class="text-gray-700 hover:text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm7.5 0c-.914 3.407-4.104 6-7.5 6s-6.586-2.593-7.5-6c.914-3.407 4.104-6 7.5-6s6.586 2.593 7.5 6z"/>
                    </svg>
                </a>
                <a href="#" class="text-gray-700 hover:text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 19h-2a1 1 0 01-1-1v-2a1 1 0 01.293-.707l8.59-8.59a1.5 1.5 0 012.12 0l2.12 2.12a1.5 1.5 0 010 2.12l-8.59 8.59A1 1 0 0111 19z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 17l-3-3m0 0l1-1m-1 1l-1-1m1 1h1.5m3-5.5L14 9m-1 1L11.5 7.5" />
                    </svg>
                </a>
                <a href="http://" class="text-gray-700 hover:text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Add more dummy cards as needed -->
    </div>

    <x-pagging :paginator=$posts />
</section>
@endsection
