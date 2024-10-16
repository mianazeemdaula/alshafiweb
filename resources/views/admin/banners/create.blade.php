@extends('layouts.web')

@section('content')
    <div class="mx-auto ">
        <div class="px-4 sm:px-8 md:px-12 bg-white rounded-lg mt-7 pt-2">
            {{-- // if there is any error --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ $errors->first() }}</span>
                </div>
            @endif
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="main grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-4">
                    <div class="flex flex-col gap-2">
                        <x-label>Country</x-label>
                        <x-select name="country_id">
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}
                                </option>
                            @endforeach
                        </x-select>
                    </div>
                    <div class="flex flex-col gap-2">
                        <x-label>Title</x-label>
                        <x-input name="title" value="{{ old('title') }}" placeholder="Title" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-label>URL</x-label>
                        <x-input name="url" type="url" value="{{ old('url') }}" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-label>Start Date</x-label>
                        <x-input name="start_date" type="date" value="{{ old('start_date') }}" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-label>End Date</x-label>
                        <x-input name="end_date" type="date" value="{{ old('end_date') }}" />
                    </div>

                    <div class="flex flex-col gap-2 ">
                        <x-label>Active</x-label>
                        <x-select name="is_active">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </x-select>
                    </div>
                </div>
                <div>
                    <x-label>Description</x-label>
                    <textarea name="description" id="mytextarea" cols="30" rows="10"
                        class="w-full border border-gray-300 rounded-md p-2">{{ old('description') }}</textarea>
                </div>
                <div>
                    <x-label>Image</x-label>
                    <input type="file" name="image" id=""
                        class="border border-gray-300 rounded-md p-2 w-full">
                    @error('image')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex py-6 space-x-4">
                    <button type="submit"
                        class="font-poppins py-2 px-4 rounded-md bg-green-500 text-white hover:bg-green-600 cursor-pointer">Create
                        Product</button>

                    <button type="submit"
                        class="font-poppins py-2 px-4 rounded-md bg-red-500 text-white hover:bg-green-600 cursor-pointer">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection
