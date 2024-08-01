@extends('layouts.web')

@section('content')
<div class="mx-auto ">
    <div class="px-4 sm:px-8 md:px-12 bg-white rounded-lg mt-7 pt-2">
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="main grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-4">
                <div class="flex flex-col gap-2 ">
                    <x-label>Payment Method</x-label>
                    <x-input name="payment_method_id" value="{{ $order->paymentMethod->name }}" readonly="readonly" />
                </div>
                <div class="flex flex-col gap-2">
                    <x-label>Payment Status</x-label>
                    <x-select name="payment_status">
                        <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                    </x-select>
                </div>
                <div class="flex flex-col gap-2 ">
                    <x-label>Zipcode</x-label>
                    <x-input name="zip_code" value="{{ $order->zip_code }}" />
                </div>

                 <div class="flex flex-col gap-2 ">
                    <x-label>Street</x-label>
                    <x-input name="street_address" value="{{ $order->street_address }}" />
                </div>

                 <div class="flex flex-col gap-2 ">
                    <x-label>City</x-label>
                    <x-select name="city_id">
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ $order->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </x-select>
                </div>

                <div class="flex flex-col gap-2 ">
                    <x-label>Status</x-label>
                    <x-select name="status">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </x-select>
                </div>
            </div>
            <div class="flex py-6 space-x-4">
                <button
                    type="submit"
                    class="font-poppins py-2 px-4 rounded-md bg-green-500 text-white hover:bg-green-600 cursor-pointer"
                >Update Order</button>

                <button
                    type="submit"
                    class="font-poppins py-2 px-4 rounded-md bg-red-500 text-white hover:bg-green-600 cursor-pointer"
                >Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('head')
@endsection
