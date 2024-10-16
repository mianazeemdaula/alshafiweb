@extends('layouts.web')

@section('content')
    <section class="mx-auto w-full max-w-7xl px-4 py-4 mg">
        <div class="flex flex-col space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0">
            <div class="flex items center justify-between min-w-full">
                <h2 class="text-lg font-semibold">Product Details</h2>
                <a href="{{ route('admin.products.index') }}"
                    class="px-5 text-white bg-black py-2 rounded-lg hover:bg-gray-800">Back</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-4 py-4">
            <div class="border p-4 rounded-lg bg-gray-50">
                <div class="font-bold text-sm">Product Details</div>
                <table class="text-sm w-full ">
                    <tr>
                        <td class="py-1 font-bold text-gray-500">ID:</td>
                        <td class="text-right">{{ $product->id }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-bold text-gray-500">SKU</td>
                        <td class="text-right">{{ $product->sku }}</td>
                    </tr>

                    <tr>
                        <td class="py-1 font-bold text-gray-500">Weight:</td>
                        <td class="text-right">{{ $product->weight ?? 'N/A' }} Grams</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-bold text-gray-500">Purcahse Price:</td>
                        <td class="text-right">{{ $product->currency }} {{ $product->price ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-bold text-gray-500">Discount Price:</td>
                        <td class="text-right">{{ $product->currency }} {{ $product->discount ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-bold text-gray-500">VAT (Tax):</td>
                        <td class="text-right">{{ $product->currency }} {{ $product->vat ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-bold text-gray-500">Referrer Discount:</td>
                        <td class="text-right">{{ $product->currency }} {{ $product->referrer_discount ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-bold text-gray-500">Referal Discount:</td>
                        <td class="text-right">{{ $product->currency }} {{ $product->referal_discount ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-bold text-gray-500">Buyer Discount:</td>
                        <td class="text-right">{{ $product->currency }} {{ $product->buyer_discount ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <td class="py-1 font-bold text-gray-500">Status:</td>
                        <td class="text-right ">
                            <x-status-chip :status="$product->is_active ? 'Active' : 'inActive'" />
                        </td>
                    </tr>
                    <tr>
                        <td class="py-1 font-bold text-gray-500">Category:</td>
                        <td class="text-right">
                            {{ $product->category->name }}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-1 font-bold text-gray-500">Product Country:</td>
                        <td class="text-right">
                            {{ $product->country->name }}
                        </td>
                    </tr>
                </table>
            </div>

            <div class="border p-4 rounded-lg bg-gray-50">
                <div class="font-bold text-sm">Sales Details</div>
                <table class="text-sm w-full ">
                    <tr>
                        <td class="py-1 font-bold text-gray-500">Available Stock:</td>
                        <td class="text-right">{{ $product->stock }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-bold text-gray-500">Total Sales:</td>
                        <td class="text-right">{{ $product->sales_count }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 font-bold text-gray-500">Default Iamge:</td>
                        <td class="text-right"><img src="{{ asset($product->image) }}" alt="" srcset=""
                                class="w-40 h-40 object-cover"></td>
                    </tr>
                </table>
                <div class="grid gap-2 grid-cols-4 mt-4" id="media-img">
                    @foreach ($product->media as $item)
                        <div data-mediaid="{{ $item->id }}" class="bg-white">
                            <div class="w-20 h-20">
                                <img src="{{ asset($item->file_path) }}" alt="" srcset=""
                                    class="w-full h-full object-contain">
                            </div>
                            <div class="flex items-center justify-between">
                                <form action="{{ route('admin.products.defaultimage') }}" method="post" class="text-xs">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="image" value="{{ $item->file_path }}">
                                    <button type="submit">
                                        <i class="fa-solid fa-home"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.media.destroy', $item->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"><i class="fa-solid fa-trash text-xs"></i></button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endsection


    @section('js')
        <script type="module">
            $(document).ready(function() {
                var mediaImg = document.getElementById('media-img');
                new Sortable(mediaImg, {
                    animation: 150,
                    onEnd: function(e) {
                        // get list of data-mediaid from the sorted list
                        var mediaIds = [];
                        mediaImg.querySelectorAll('div').forEach((item) => {
                            mediaIds.push(item.getAttribute('data-mediaid'));
                        });
                        // remove all null values from the array
                        mediaIds = mediaIds.filter(function(el) {
                            return el != null;
                        });
                        fetch("{{ route('admin.products.sortmedia') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            body: JSON.stringify({
                                mediaIds: mediaIds,
                                productId: "{{ $product->id }}"
                            })
                        }).then(response => response.json()).then(data => {
                            console.log(data);
                        }).catch((error) => {
                            console.error('Error:', error);
                        });
                    }
                })
            });
        </script>
    @endsection
