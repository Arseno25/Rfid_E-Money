@extends('_layouts.master')

@section('body')
<div class="container mx-auto px-6">
    <h3 class="text-gray-700 text-2xl font-medium">All Product</h3>
        <span class="mt-3 text-sm text-gray-500">{{  $product->where('is_enabled', 1)->count()}} Products</span>
    @if($product->where('is_enabled', 1)->count() == 0)
        <div class="text-center text-gray-500 text-3xl font-bold flex justify-center items-center w-full h-auto">No products available.</div>
    @else
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-6">
            @foreach ($product as $item)
                @if ($item->is_enabled == 1)
                    <div class="{{ $item->stock > 0 ? 'w-full' : 'disabled opacity-70' }} max-w-sm mx-auto rounded-md shadow-md overflow-hidden relative">
                        <div class="flex items-end justify-end h-56 w-full bg-cover bg-no-repeat overflow-hidden bg-gray-300 relative">
                            <div class="absolute top-[-5px] right-0 bg-sky-500 py-1 px-10 opacity-80 drop-shadow-md rounded-l-md z-10">
                                <span class="text-white font-12">Stock: {{ $item->stock }}</span>
                            </div>
                            @if ($item->getFirstMediaUrl('product_image'))
                                <img class="object-cover w-full h-full hover:scale-110 ease-in-out duration-300"
                                     src="{{ $item->getFirstMediaUrl('product_image') }}"
                                     alt="">
                            @else
                                {{-- Tampilkan gambar default jika URL tidak tersedia --}}
                                <img class="object-cover w-full h-full hover:scale-110 ease-in-out duration-300 "
                                     src="{{ asset('default.png') }}"
                                     alt="Default Image">
                            @endif
                        </div>
                        <div class="px-5 py-3">
                            <strong><h1 class="text-gray-700 uppercase justify-center flex">{{ $item->name }}</h1></strong>
                            <h3 class="text-gray-500 mt-2 font-bold justify-center flex">{{ formatCurrency($item->price) }}</h3>
                        </div>
                        <div class="flex items-start justify-start px-5 py-3">
                            <span class="text-black-100 text-sm mt-2 justify-center flex rounded bg-neutral-200 px-2 opacity-70 py-1 font-bold text-neutral-600">{{ $item->category->name }}</span>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif

    <div class="flex justify-center">
        <div class="flex rounded-md mt-8">
            {{ $product->links() }}
            </div>
    </div>
</div>
@endsection
