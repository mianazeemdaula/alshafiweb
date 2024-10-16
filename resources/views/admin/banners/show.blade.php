@extends('layouts.web')

@section('content')
    <section class="mx-auto w-full max-w-7xl px-4 py-4 mg">
        <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
            <div class="flex items center justify-between min-w-full">
                <h2 class="text-lg font-semibold">Banner Details</h2>
                <a href="{{ route('admin.banners.index') }}"
                    class="px-5 text-white bg-black py-2 rounded-lg hover:bg-gray-800">Back</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-4 py-4">
            <div class="border p-4 rounded-lg bg-gray-50">
                <div class="font-bold text-sm">Banner Details</div>
                <table class="text-sm w-full ">
                    <tr>
                        <td class="py-1 font-bold text-gray-500">ID:</td>
                        <td class="text-right">{{ $banner->id }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-bold text-gray-500">URL</td>
                        <td class="text-right">{{ $banner->url }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-bold text-gray-500">Start Date</td>
                        <td class="text-right">{{ $banner->start_date }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-bold text-gray-500">End Date</td>
                        <td class="text-right">{{ $banner->end_date }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-bold text-gray-500">Status:</td>
                        <td class="text-right ">
                            <x-status-chip :status="$banner->is_active ? 'Active' : 'inActive'" />
                        </td>
                    </tr>
                    <tr>
                        <td class="py-1 font-bold text-gray-500">Banner Country:</td>
                        <td class="text-right">
                            {{ $banner->country->name }}
                        </td>
                    </tr>
                </table>
            </div>

            <div class="border p-4 rounded-lg bg-gray-50">
                <div class="font-bold text-sm">Image</div>
                <img src="{{ asset($banner->image) }}" alt="" srcset="" class="w-full object-cover">
            </div>
        </div>
    </section>
@endsection
