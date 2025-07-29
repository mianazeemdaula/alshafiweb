@extends('layouts.web')

@section('content')
    <section class="mx-auto w-full max-w-7xl px-4 py-4">
        <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
            <div>
                <h2 class="text-lg font-semibold">Orders</h2>
            </div>
        </div>
        <div class="mt-6">
            <div class="">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden border border-gray-200 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                                            User</th>
                                        <th scope="col" class="px-12 py-3.5 text-left text-sm font-normal text-gray-700">
                                            Payment</th>
                                        <th scope="col" class="px-12 py-3.5 text-left text-sm font-normal text-gray-700">
                                            Status</th>
                                        <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                                            City/Zip</th>
                                        <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                                            Shipping Cost</th>
                                        <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                                            Total</th>
                                        <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                                            Extra Note</th>
                                        <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-700">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @forelse ($orders as $item)
                                        <tr>
                                            <td class="whitespace-nowrap px-4 py-4">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0">
                                                        <img class="h-10 w-10 rounded-full object-cover"
                                                            src="{{ $item->user->avatar }}" alt="{{ $item->user->name }}" />
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $item->user->name ?? '' }}</div>
                                                        <div class="text-sm text-gray-700">{{ $item->user->mobile ?? '' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap px-12 py-4">
                                                <div class="text-sm text-gray-900">{{ $item->paymentMethod->name ?? '' }}
                                                </div>
                                                <p class="text-sm">{{ $item->payment_status }}</p>
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-4">
                                                <span
                                                    class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">{{ $item->status }}</span>
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-700">
                                                {{ $item->shipping_address['city'] ?? '' }} ({{ $item->zip_code }})</td>
                                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-700">
                                                {{ $item->shipping_cost }}</td>
                                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-700">
                                                {{ $item->total }}</td>
                                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-700">
                                                {{ $item->extra_note }}</td>
                                            <td
                                                class="px-2 py-1 text-xs font-medium text-right sm:px-4 sm:py-1 flex space-x-2">
                                                <a href="{{ route('admin.orders.show', $item->id) }}" class="">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.orders.edit', $item->id) }}">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.orders.destroy', $item->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit">
                                                        <i class="fa fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-4">No orders found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-pagging :paginator=$orders />
    </section>
@endsection
