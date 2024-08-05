@extends('layouts.web')

@section('content')
<div class="mx-auto ">
    <div class="px-4 sm:px-8 md:px-12 bg-white rounded-lg mt-7 pt-2">
        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf
            <div class="main grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-4">
                <div class="flex flex-col gap-2">
                    <x-label>Category</x-label>
                    <x-select name="category_id">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </x-select>
                </div>

                <div class="flex flex-col gap-2">
                    <x-label>Name</x-label>
                    <x-input name="name" value="{{ old('name') }}" />
                </div>

                <div class="flex flex-col gap-2">
                    <x-label>Weight</x-label>
                    <x-input name="weight" type="number" value="{{ old('weight') }}" />
                </div>

                <div class="flex flex-col gap-2">
                    <x-label>Price</x-label>
                    <x-input name="price" value="{{ old('price') }}" />
                </div>

                <div class="flex flex-col gap-2">
                    <x-label>Discount</x-label>
                    <x-input name="discount" value="{{ old('discount') }}" />
                </div>

                <div class="flex flex-col gap-2 ">
                    <x-label>VAT</x-label>
                    <x-input name="vat" value="{{ old('vat') }}" />
                </div>

                <div class="flex flex-col gap-2 ">
                    <x-label>Stock</x-label>
                    <x-input name="stock" value="{{ old('stock') }}" />
                </div>

                <div class="flex flex-col gap-2 ">
                    <x-label>Featured</x-label>
                    <input type="checkbox" name="featured" id="">
                </div>

                <div class="flex flex-col gap-2 ">
                    <x-label>Referrer Discount</x-label>
                    <x-input name="referrer_discount" value="{{ old('referrer_discount') }}" />
                </div>

                 <div class="flex flex-col gap-2 ">
                    <x-label>Referal Discount</x-label>
                    <x-input name="referal_discount" value="{{ old('referal_discount') }}" />
                </div>

                 <div class="flex flex-col gap-2 ">
                    <x-label>Buyer Discount</x-label>
                    <x-input name="buyer_discount" value="{{ old('buyer_discount') }}" />
                </div>

                <div class="flex flex-col gap-2 ">
                    <x-label>Active</x-label>
                    <input type="checkbox" name="is_active" id="" >
                </div>
            </div>
            <div>
                <x-label>Description</x-label>
                <textarea name="description" id="mytextarea" cols="30" rows="10" class="w-full border border-gray-300 rounded-md p-2">{{ old('description') }}</textarea>
            </div>
            <div>
                <x-label>Image</x-label>
                <input type="file" name="image" id="" class="border border-gray-300 rounded-md p-2 w-full">
            </div>
            <div class="flex py-6 space-x-4">
                <button
                    type="submit"
                    class="font-poppins py-2 px-4 rounded-md bg-green-500 text-white hover:bg-green-600 cursor-pointer"
                >Create Product</button>

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
    <script src="https://cdn.tiny.cloud/1/kput55tw7sf7m8nadh5lth5ghsdshrjgwfbj9ju8hcdigf4a/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
        selector: '#mytextarea'
      });
        
    </script>
@endsection
