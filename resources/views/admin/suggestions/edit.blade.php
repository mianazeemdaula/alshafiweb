@extends('layouts.web')

@section('content')
<div class="mx-auto ">
    <div class="px-4 sm:px-8 md:px-12 bg-white rounded-lg mt-7 pt-2">
        <form action="{{ route('admin.levels.update', $level->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="main grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-4">
                <div class="flex flex-col gap-2">
                    <x-label>Name</x-label>
                    <x-input name="name" value="{{ $level->name }}" />
                </div>

                <div class="flex flex-col gap-2">
                    <x-label>Min Points</x-label>
                    <x-input name="min_points" value="{{ $level->min_points }}" />
                </div>

                <div class="flex flex-col gap-2">
                    <x-label>Discount</x-label>
                    <x-input name="discount" value="{{ $level->discount }}" />
                </div>

                <div class="flex flex-col gap-2 ">
                    <x-label>Cashback</x-label>
                    <x-input name="cashback" value="{{ $level->cashback }}" />

                </div>
            </div>
            <div class="flex py-6 space-x-4">
                <button
                    type="submit"
                    class="font-poppins py-2 px-4 rounded-md bg-green-500 text-white hover:bg-green-600 cursor-pointer"
                >Update Level</button>

                <button
                    type="submit"
                    class="font-poppins py-2 px-4 rounded-md bg-red-500 text-white hover:bg-green-600 cursor-pointer"
                >Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection