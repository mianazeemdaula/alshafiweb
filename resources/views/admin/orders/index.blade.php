@extends('layouts.web')

@section('content')
<section class="mx-auto w-full max-w-7xl px-4 py-4">
    <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
        <div>
            <h2 class="text-lg font-semibold">Orders</h2>
        </div>
    </div>
    <div class="mt-6 flex flex-col">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                            <span>User</span>
                        </th>
                        <th scope="col" class="px-12 py-3.5 text-left text-sm font-normal text-gray-700">
                            Payment
                        </th>
                        <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700" >
                            Street
                        </th>
                        <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                            Cit/Zip
                        </th>
                        <th scope="col" class="relative py-3.5">
                            <span class="text-center text-sm font-normal text-gray-700">Stock</span>
                        </th>
                        <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                            Shipping Cost
                        </th>
                        <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                            Total
                        </th>
                        <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                            Extra Note
                        </th>
                        <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach($orders as $item)
                    <tr>
                        <td class="whitespace-nowrap px-4 py-4">
                            <div class="flex items-center">
                            <div class="h-10 w-10 flex-shrink-0">
                                {{ $item->id }}
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                {{ $item->user->name ?? '' }}
                                </div>
                                <div class="text-sm text-gray-700">
                                {{ $item->user->mobile ?? '' }}
                                </div>
                            </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-12 py-4">
                            <div class="text-sm text-gray-900">{{ $item->paymentMethod->name ?? '' }} </div>
                            <p class="line-through">{{ $item->payment_status }}</p>
                        </td>
                        <td class="whitespace-nowrap px-4 py-4">
                            <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
                            {{ $item->status }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-700">
                            {{ $item->street_address }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-700">
                            {{ $item->city->name }} ({{ $item->zip_code }})
                        </td>
                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-700">
                            {{ $item->shipping_cost }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-700">
                            {{ $item->total }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-700">
                            {{ $item->extra_note }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-4 text-right text-sm font-medium">
                            <a href="#" class="text-gray-700 hover:text-blue-500">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                strokeWidth="2"
                            >
                                <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm7.5 0c-.914 3.407-4.104 6-7.5 6s-6.586-2.593-7.5-6c.914-3.407 4.104-6 7.5-6s6.586 2.593 7.5 6z"
                                />
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
    <x-pagging />
</section>
@endsection