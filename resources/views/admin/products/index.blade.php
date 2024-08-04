@extends('layouts.web')

@section('content')
<section class="mx-auto w-full h-screen max-w-7xl px-4 py-4">
    <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
        <div>
            <h2 class="text-lg font-semibold">Products</h2>
        </div>
    </div>
    <div class="mt-6 flex flex-col space-y-4">
        <!-- Card Layout for Small Screens -->
        <div class="block lg:hidden">
            @foreach($products as $item)
            <div class="bg-white shadow rounded-lg p-4 mb-4">
                <div class="flex items-center space-x-4">
                    <img
                        class="h-20 w-20 rounded-full object-cover"
                        src="https://images.unsplash.com/photo-1628157588553-5eeea00af15c?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=1160&amp;q=80"
                        alt="Product Image"
                    />
                    <div>
                        <div class="text-lg font-medium text-gray-900">
                            {{ $item->name }}
                        </div>
                        <div class="text-sm text-gray-700">
                            Category: {{ $item->category->name ?? 'N/A' }}
                        </div>
                        <div class="text-sm text-gray-700">
                            Price: {{ $item->price }}
                        </div>
                        <div class="text-sm text-gray-700">
                            Status: {{ $item->is_active ? 'Active' : 'Inactive' }}
                        </div>
                        <div class="text-sm text-gray-700">
                            Discount: {{ $item->discount }}%
                        </div>
                        <div class="text-sm text-gray-700">
                            Stock: {{ $item->stock }}
                        </div>
                        <div class="text-sm text-gray-700">
                            Referrer Discount: {{ $item->referrer_discount }}
                        </div>
                        <div class="text-sm text-gray-700">
                            Referral Discount: {{ $item->referal_discount }}
                        </div>
                        <div class="text-sm text-gray-700">
                            Buyer Discount: {{ $item->buyer_discount }}
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="#" class="text-blue-500 hover:text-blue-700">View Details</a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Table Layout for Larger Screens -->
        <div class="hidden lg:block">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden border border-gray-200 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-2 py-2 text-left text-xs font-normal text-gray-700 sm:px-4 sm:py-3.5">Employee</th>
                                    <th scope="col" class="px-2 py-2 text-left text-xs font-normal text-gray-700 sm:px-4 sm:py-3.5">Title</th>
                                    <th scope="col" class="px-2 py-2 text-left text-xs font-normal text-gray-700 sm:px-4 sm:py-3.5">Status</th>
                                    <th scope="col" class="px-2 py-2 text-left text-xs font-normal text-gray-700 sm:px-4 sm:py-3.5">Discount</th>
                                    <th scope="col" class="px-2 py-2 text-left text-xs font-normal text-gray-700 sm:px-4 sm:py-3.5">Stock</th>
                                    <th scope="col" class="px-2 py-2 text-left text-xs font-normal text-gray-700 sm:px-4 sm:py-3.5">Referrer Discount</th>
                                    <th scope="col" class="px-2 py-2 text-left text-xs font-normal text-gray-700 sm:px-4 sm:py-3.5">Referral Discount</th>
                                    <th scope="col" class="px-2 py-2 text-left text-xs font-normal text-gray-700 sm:px-4 sm:py-3.5">Buyer Discount</th>
                                    <th scope="col" class="px-2 py-2 text-left text-xs font-normal text-gray-700 sm:px-4 sm:py-3.5">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($products as $item)
                                <tr>
                                    <td class="whitespace-nowrap px-2 py-4 text-sm sm:px-4 sm:py-4">
                                        <div class="flex items-center space-x-4">
                                            <img
                                                class="h-10 w-10 rounded-full object-cover"
                                                src="https://images.unsplash.com/photo-1628157588553-5eeea00af15c?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=1160&amp;q=80"
                                                alt="Product Image"
                                            />
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $item->name }}
                                                </div>
                                                <div class="text-sm text-gray-700">
                                                    {{ $item->category->name ?? '' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-4 text-sm sm:px-4 sm:py-4">
                                        {{ $item->price }}
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-4 text-sm sm:px-4 sm:py-4">
                                        <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
                                            {{ $item->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-4 text-sm sm:px-4 sm:py-4">
                                        {{ $item->discount }}%
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-4 text-sm sm:px-4 sm:py-4">
                                        {{ $item->stock }}
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-4 text-sm sm:px-4 sm:py-4">
                                        {{ $item->referrer_discount }}
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-4 text-sm sm:px-4 sm:py-4">
                                        {{ $item->referal_discount }}
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-4 text-sm sm:px-4 sm:py-4">
                                        {{ $item->buyer_discount }}
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-4 text-sm font-medium text-right sm:px-4 sm:py-4">
                                        <a href="#" class="text-gray-700 hover:text-blue-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2">
                                                <path strokeLinecap="round" strokeLinejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm7.5 0c-.914 3.407-4.104 6-7.5 6s-6.586-2.593-7.5-6c.914-3.407 4.104-6 7.5-6s6.586 2.593 7.5 6z"/>
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
    </div>
    <x-pagging />
</section>
@endsection
