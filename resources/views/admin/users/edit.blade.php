@extends('layouts.web')

@section('content')
<div class="mx-auto ">
    <div class="px-4 sm:px-8 md:px-12 bg-white rounded-lg mt-7 pt-2">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="main grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-4">
                <div class="flex flex-col gap-2">
                    <x-label>Name</x-label>
                    <x-input name="name" value="{{ $user->name }}" />
                </div>

                <div class="flex flex-col gap-2">
                    <x-label>Email</x-label>
                    <x-input name="email" value="{{ $user->email }}" type="email" />
                </div>

                <div class="flex flex-col gap-2">
                    <x-label>Mobile</x-label>
                    <x-input name="mobile" value="{{ $user->mobile }}" />
                </div>


                <div class="flex flex-col gap-2 ">
                    <x-label>Referal Code</x-label>
                    <x-input name="ref_code" value="{{ $user->ref_code }}" />

                </div>

                <div class="flex flex-col gap-2 ">
                    <x-label>Extra Discount</x-label>
                    <x-input name="extra_discount" value="{{ $user->extra_discount }}" />

                </div>
            </div>
            <div class="flex py-6 space-x-4">
                <button
                    type="submit"
                    class="font-poppins py-2 px-4 rounded-md bg-green-500 text-white hover:bg-green-600 cursor-pointer"
                >Update User</button>

                <button
                    type="submit"
                    class="font-poppins py-2 px-4 rounded-md bg-red-500 text-white hover:bg-green-600 cursor-pointer"
                >Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection