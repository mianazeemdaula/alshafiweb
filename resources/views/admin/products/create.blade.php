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
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
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
                        <x-label>Category</x-label>
                        <x-select name="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </x-select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-label>SKU</x-label>
                        <x-input name="sku" value="{{ old('sku') }}" placeholder="SKU-6265A" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <x-label>Name</x-label>
                        <x-input name="name" value="{{ old('name') }}" placeholder="Capsule" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-label>Weight (g)</x-label>
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

                    <div class="flex flex-col gap-2">
                        <x-label>WhatsApp Contact (optional)</x-label>
                        <x-input name="whatsapp_contact" value="{{ old('whatsapp_contact') }}"
                            placeholder="e.g. 923001234567" />
                    </div>

                    <div class="flex flex-col gap-2 ">
                        <x-label>Stock</x-label>
                        <x-input name="stock" value="{{ old('stock') }}" />
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
                        <x-label>Earn Points</x-label>
                        <x-input name="earn_points" value="{{ old('earn_points') }}" type="number" step="0.01" />
                    </div>

                    <div class="flex flex-col gap-2 ">
                        <x-label>Featured</x-label>
                        <x-select name="featured">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-select>
                    </div>

                    <div class="flex flex-col gap-2 ">
                        <x-label>Sorting Order</x-label>
                        <x-input name="sorting" type="number" min="0" value="{{ old('sorting', 0) }}" />
                    </div>

                    <div class="flex flex-col gap-2 ">
                        <x-label>Active</x-label>
                        <x-select name="is_active">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </x-select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <x-label>Visibility</x-label>
                        <div class="flex items-center gap-3 mt-2">
                            <input type="checkbox" name="manual_only" id="manual_only"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                {{ old('manual_only') ? 'checked' : '' }}>
                            <label for="manual_only" class="text-sm text-gray-700 dark:text-gray-300">
                                Manual Orders Only (Hidden from website)
                            </label>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Check this to hide the product from website and show only in
                            manual orders</p>
                    </div>
                </div>
                <div>
                    <x-label>Description</x-label>
                    <textarea name="description" id="mytextarea" cols="30" rows="10"
                        class="w-full border border-gray-300 rounded-md p-2">{{ old('description') }}</textarea>
                </div>
                <div>
                    <x-label>Image</x-label>
                    <input type="file" name="image[]" id="" class="border border-gray-300 rounded-md p-2 w-full"
                        multiple>
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

@section('head')
    <script
        src="https://cdn.tiny.cloud/1/{{ config('app.env') === 'production' ? 'qxsiixa2mkq6u711kgpc20nafpny7wpufinm5gdvvytgryxh' : env('TINYMCE_API_KEY') }}/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#mytextarea'
        });
    </script>
@endsection
