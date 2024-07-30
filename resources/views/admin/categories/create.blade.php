@extends('layouts.web')

@section('content')
<div class="mx-auto ">
    <div class="px-4 sm:px-8 md:px-12 bg-white rounded-lg mt-7 pt-2">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="main grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-4">
                <div class="flex flex-col gap-2">
                    <x-label>Name</x-label>
                    <x-input name="name" value="{{ old('name') }}" />
                </div>

                <div class="flex flex-col gap-2">
                    <x-label>Image</x-label>
                    <x-input name="image" value="{{ old('image') }}" type="file" />
                </div>
            </div>
            <div class="flex py-6 space-x-2">
                <button
                    type="submit"
                    class="font-poppins py-2 px-4 rounded-md bg-green-500 text-white hover:bg-green-600 cursor-pointer"
                >Create</button>

                <button
                    type="submit"
                    class="font-poppins py-2 px-4 rounded-md bg-red-500 text-white hover:bg-green-600 cursor-pointer"
                >Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection