@extends('layouts.web')

@section('content')
<div class="mx-auto ">
    <div class="px-4 sm:px-8 md:px-12 bg-white rounded-lg mt-7 pt-2">
        <form action="{{ route('admin.levels.store') }}" method="POST">
            @csrf
            <div class="main grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-4">
                <div class="flex flex-col gap-2">
                    <x-label>Name</x-label>
                    <x-input name="name" value="{{ old('name') }}" />
                </div>

                <div class="flex flex-col gap-2">
                    <x-label>Min Points</x-label>
                    <x-input name="min_points" value="{{ old('min_points') }}" />
                </div>

                <div class="flex flex-col gap-2">
                    <x-label>Discount</x-label>
                    <x-input name="discount" value="{{ old('discount') }}" />
                </div>

                <div class="flex flex-col gap-2 ">
                    <x-label>Cashback</x-label>
                    <x-input name="cashback" value="{{ old('cashback') }}" />

                </div>
            </div>
            <div class="flex justify-center py-6">
                <button
                    type="submit"
                    class="font-poppins text-[22px] px-8 lg:px-[70px] py-2 rounded-lg bg-green-500 text-white hover:bg-green-600 cursor-pointer"
                >
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection