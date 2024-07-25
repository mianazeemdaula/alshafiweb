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
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="p-6.5">
            <div class="mb-4.5">
              <label class="mb-3 block text-sm font-medium text-black dark:text-white" >
                Name
              </label>
              <input
                name="name"
                type="text"
                placeholder="Name"
                value="{{ $category->name }}"
                class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
              />
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
              Register
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- ====== Form Layout Section End -->
</div>    
@endsection