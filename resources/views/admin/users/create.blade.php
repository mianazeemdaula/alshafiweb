@extends('layouts.web')

@section('content')
    <div class="mx-auto ">
        <div class="px-4 sm:px-8 md:px-12 bg-white rounded-lg mt-7 pt-2">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="main grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-4">
                    <div class="flex flex-col gap-2">
                        <x-label>Name</x-label>
                        <x-input name="name" value="{{ old('name') }}" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-label>Email</x-label>
                        <x-input name="email" value="{{ old('email') }}" type="email" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-label>Mobile</x-label>
                        <x-input name="mobile" value="{{ old('mobile') }}" />
                    </div>


                    <div class="flex flex-col gap-2 ">
                        <x-label>Referal Code</x-label>
                        <x-input name="ref_code" value="{{ old('ref_code') }}" />

                    </div>

                    <div class="flex flex-col gap-2 ">
                        <x-label>Extra Discount</x-label>
                        <x-input name="extra_discount" value="{{ old('extra_discount', 0) }}" type="number"
                            step="0.1" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-label>Role <span class="text-red-500">*</span></x-label>
                        <select name="role"
                            class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2 ">
                        <x-label>Password</x-label>
                        <x-input name="password" type="password" />
                    </div>
                    <div class="flex flex-col gap-2 ">
                        <x-label>Confirm Password</x-label>
                        <x-input name="password_confirmation" type="password" />
                    </div>
                </div>
                <div class="flex py-6 space-x-4">
                    <button type="submit"
                        class="font-poppins py-2 px-4 rounded-md bg-green-500 text-white hover:bg-green-600 cursor-pointer">Create
                        User</button>

                    <button type="submit"
                        class="font-poppins py-2 px-4 rounded-md bg-red-500 text-white hover:bg-green-600 cursor-pointer">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection
