@extends('layouts.admin')
@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
  <!-- Breadcrumb Start -->
  <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between" >
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
      Category
    </h2>
    <nav>
      <ol class="flex items-center gap-2">
        <li>
          <a class="font-medium" href="index.html">Dashboard /</a>
        </li>
        <li class="font-medium text-primary">Category</li>
      </ol>
    </nav>
  </div>
  <!-- Breadcrumb End -->

  <!-- ====== Form Layout Section Start -->
  <div class="grid grid-cols-1 gap-9 sm:grid-cols-2">
   
    <div class="flex flex-col gap-9">

      <!-- Sign Up Form -->
      <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark" >
        <div class="border-b border-stroke px-6.5 py-4 dark:border-strokedark" >
          <h3 class="font-medium text-black dark:text-white">
            Category Form
          </h3>
        </div>
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="p-6.5">
            <div class="mb-4.5">
              <label class="mb-3 block text-sm font-medium text-black dark:text-white" >
                Category
              </label>
              <select name="category_id" id="" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                @foreach($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
              @error('category_id') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4.5">
              <label class="mb-3 block text-sm font-medium text-black dark:text-white" >
                Name
              </label>
              <input
                name="name"
                type="text"
                placeholder="Name"
                value="{{ $product->name }}"
                class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
              />
              @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4.5">
              <label class="mb-3 block text-sm font-medium text-black dark:text-white" >
                Weight
              </label>
              <input
                name="weight"
                type="number"
                placeholder="Weight"
                step="0.01"
                value="{{ $product->weight }}"
                class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
              />
              @error('weight') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4.5">
              <label class="mb-3 block text-sm font-medium text-black dark:text-white" >
                Price
              </label>
              <input
                name="price"
                type="number"
                step="0.01"
                placeholder="Price"
                value="{{ $product->price }}"
                class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
              />
              @error('price') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4.5">
              <label class="mb-3 block text-sm font-medium text-black dark:text-white" >
                Discount
              </label>
              <input
                name="discount"
                type="number"
                step="0.01"
                placeholder="discount"
                value="{{ $product->discount }}"
                class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
              />
              @error('discount') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4.5">
              <label class="mb-3 block text-sm font-medium text-black dark:text-white" >
                Tax
              </label>
              <input
                name="vat"
                type="number"
                step="0.01"
                placeholder="Price"
                value="{{ $product->vat }}"
                class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
              />
              @error('vat') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4.5">
              <label class="mb-3 block text-sm font-medium text-black dark:text-white" >
                Stock
              </label>
              <input
                name="stock"
                type="number"
                step="1"
                placeholder="Stock"
                value="{{ $product->stock }}"
                class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
              />
              @error('stock') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4.5">
              <label class="mb-3 block text-sm font-medium text-black dark:text-white" >
                Referr Discount
              </label>
              <input
                name="referr_discount"
                type="number"
                step="0.01"
                placeholder="Referr Discount"
                value="{{ $product->referr_discount }}"
                class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
              />
              @error('referr_discount') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4.5">
              <label class="mb-3 block text-sm font-medium text-black dark:text-white" >
                Referal Discount
              </label>
              <input
                name="referal_discount"
                type="number"
                step="0.01"
                placeholder="referal Discount"
                value="{{ $product->referal_discount }}"
                class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
              />
              @error('referal_discount') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4.5">
              <label class="mb-3 block text-sm font-medium text-black dark:text-white" >
                Description
              </label>
              <textarea class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" name="description" id="" cols="30" rows="10">{{ $product->description }}</textarea>
              @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4.5">
              <label class="mb-3 block text-sm font-medium text-black dark:text-white" >
                Image / Logo
              </label>
              
              <input
                name="image"
                type="file"
                class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" >
            </div>
            <button class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90" >
              Update
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- ====== Form Layout Section End -->
</div>    
@endsection