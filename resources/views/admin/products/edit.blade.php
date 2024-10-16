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
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="main grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-4">
                    <div class="flex flex-col gap-2">
                        <x-label>Country</x-label>
                        <x-select name="country_id">
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}"
                                    {{ $product->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}
                                </option>
                            @endforeach
                        </x-select>
                    </div>
                    <div class="flex flex-col gap-2">
                        <x-label>Category</x-label>
                        <x-select name="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                </option>
                            @endforeach
                        </x-select>
                    </div>
                    <div class="flex flex-col gap-2">
                        <x-label>Name</x-label>
                        <x-input name="name" value="{{ $product->name }}" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-label>SKU</x-label>
                        <x-input name="sku" value="{{ $product->sku }}" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-label>Weight</x-label>
                        <x-input name="weight" type="number" value="{{ $product->weight }}" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-label>Price</x-label>
                        <x-input name="price" value="{{ $product->price }}" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-label>Discount</x-label>
                        <x-input name="discount" value="{{ $product->discount }}" />
                    </div>

                    <div class="flex flex-col gap-2 ">
                        <x-label>VAT</x-label>
                        <x-input name="vat" value="{{ $product->vat }}" />
                    </div>

                    <div class="flex flex-col gap-2 ">
                        <x-label>Stock</x-label>
                        <x-input name="stock" value="{{ $product->stock }}" />
                    </div>

                    <div class="flex flex-col gap-2 ">
                        <x-label>Referrer Discount</x-label>
                        <x-input name="referrer_discount" value="{{ $product->referrer_discount }}" />
                    </div>
                    <div class="flex flex-col gap-2 ">
                        <x-label>Referal Discount</x-label>
                        <x-input name="referal_discount" value="{{ $product->referal_discount }}" />
                    </div>
                    <div class="flex flex-col gap-2 ">
                        <x-label>Buyer Discount</x-label>
                        <x-input name="buyer_discount" value="{{ $product->buyer_discount }}" />
                    </div>
                    <div class="flex flex-col gap-2 ">
                        <x-label>Earn Points</x-label>
                        <x-input name="earn_points" value="{{ $product->earn_points }}" />
                    </div>
                    <div class="flex flex-col gap-2 ">
                        <x-label>Featured</x-label>
                        <x-select name="featured">
                            <option value="1" {{ $product->featured == 1 ? 'selected' : '' }}>Featured</option>
                            <option value="0" {{ $product->featured == 0 ? 'selected' : '' }}>Not Featured</option>
                        </x-select>
                    </div>

                    <div class="flex flex-col gap-2 ">
                        <x-label>Active</x-label>
                        <x-select name="is_active">
                            <option value="1" {{ $product->is_active == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $product->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                        </x-select>
                    </div>
                </div>
                <div>
                    <x-label>Description</x-label>
                    <textarea name="description" id="mytextarea" cols="30" rows="10"
                        class="w-full border border-gray-300 rounded-md p-2">{{ $product->description }}</textarea>
                </div>
                <div>
                    <x-label>Image</x-label>
                    <input type="file" name="image[]" id="" class="border border-gray-300 rounded-md p-2 w-full"
                        multiple>
                </div>
                <div class="flex py-6 space-x-4">
                    <button type="submit"
                        class="font-poppins py-2 px-4 rounded-md bg-green-500 text-white hover:bg-green-600 cursor-pointer">Update
                        Product</button>

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
