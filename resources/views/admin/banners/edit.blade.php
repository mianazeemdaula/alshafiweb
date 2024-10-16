@extends('layouts.web')

@section('content')
    <div class="mx-auto ">
        {{-- if any error --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ $errors->first() }}</span>
            </div>
        @endif
        <div class="px-4 sm:px-8 md:px-12 bg-white rounded-lg mt-7 pt-4">
            <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="main grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-4">
                    <div class="flex flex-col gap-2">
                        <x-label>Country</x-label>
                        <x-select name="country_id">
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}"
                                    {{ $banner->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}
                                </option>
                            @endforeach
                        </x-select>
                    </div>
                    <div class="flex flex-col gap-2">
                        <x-label>Title</x-label>
                        <x-input name="title" value="{{ $banner->title }}" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <x-label>URL</x-label>
                        <x-input name="url" type="url" value="{{ $banner->url }}" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-label>Start Date</x-label>
                        <x-input name="start_date" type="date" value="{{ $banner->start_date->format('Y-m-d') }}" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-label>End Date</x-label>
                        <x-input name="end_date" type="date" value="{{ $banner->end_date->format('Y-m-d') }}" />
                    </div>

                    <div class="flex flex-col gap-2 ">
                        <x-label>Active</x-label>
                        <x-select name="is_active">
                            <option value="1" @if ($banner->is_active) selected @endif>Active</option>
                            <option value="0" @if (!$banner->is_active) selected @endif>Inactive</option>
                        </x-select>
                    </div>
                </div>
                <div>
                    <x-label>Description</x-label>
                    <textarea name="description" id="mytextarea" cols="30" rows="10"
                        class="w-full border border-gray-300 rounded-md p-2">{{ $banner->description }}</textarea>
                </div>
                <div>
                    <x-label>Image</x-label>
                    <input type="file" name="image" id=""
                        class="border border-gray-300 rounded-md p-2 w-full">
                </div>
                <div class="flex py-6 space-x-4">
                    <button type="submit"
                        class="font-poppins py-2 px-4 rounded-md bg-primary text-white hover:bg-primary-dark cursor-pointer">Update
                        Banner</button>

                    <button type="submit"
                        class="font-poppins py-2 px-4 rounded-md bg-red-500 text-white hover:bg-red-600 cursor-pointer">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection
