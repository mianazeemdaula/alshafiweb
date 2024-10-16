@extends('layouts.web')

@section('content')
    <div class="mx-auto ">
        <div class="px-4 sm:px-8 md:px-12 bg-white rounded-lg mt-7 pt-2">
            <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="main grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-4">
                    <div class="flex flex-col gap-2">
                        <x-label>Title</x-label>
                        <x-input name="title" value="{{ old('title') }}" />
                    </div>
                    <div>
                        {{-- status of the post --}}
                        <x-label>Status</x-label>
                        <x-select name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </x-select>
                    </div>
                </div>
                <div class="my-2">
                    <x-label>Image</x-label>
                    <x-input type="file" name="image" />
                </div>
                <div>
                    <x-label>Content</x-label>
                    <textarea name="content" id="mytextarea" cols="30" rows="10"
                        class="w-full border border-gray-300 rounded-md p-2">{{ old('content') }}</textarea>
                </div>
                <div class="flex py-6 space-x-4">
                    <button type="submit"
                        class="font-poppins py-2 px-4 rounded-md bg-green-500 text-white hover:bg-green-600 cursor-pointer">Create
                        News</button>

                    <button type="submit"
                        class="font-poppins py-2 px-4 rounded-md bg-red-500 text-white hover:bg-green-600 cursor-pointer">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('head')
    <script src="https://cdn.tiny.cloud/1/kput55tw7sf7m8nadh5lth5ghsdshrjgwfbj9ju8hcdigf4a/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#mytextarea'
        });
    </script>
@endsection
