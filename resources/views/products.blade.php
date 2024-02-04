@extends('_layouts.master')

@section('body')
<div class="container mx-auto px-6">
    <div class="mx-auto flex justify-between items-center">
        <h3 class="text-gray-700 text-2xl font-medium">All Product</h3>
        <form method="GET" action="{{ route('search') }}" class="flex items-center">
            <div class="relative max-w-lg flex items-center">
                <label>
                    <input class="pl-3 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" name="query" id="query" type="text" placeholder="Search.." value={{ $search ?? '' }}>
                </label>
                <button type="submit" class="absolute ml-2 px-3 right-0 flex items-center hover:bg-gray-100">
                    <svg class="h-5 w-5 text-gray-500 transition-transform transform hover:text-blue-500" viewBox="0 0 24 24" fill="none">
                        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
    @if($product->where('is_enabled', 1)->count() == 0)
        <div class="text-center text-gray-500 text-3xl font-bold flex justify-center items-center w-full h-auto">No products available.</div>
    @else
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-6">
            @foreach ($product as $item)
                @if ($item->is_enabled == 1)
                    <div class="{{ $item->stock > 0 ? 'w-full' : 'disabled opacity-70' }} max-w-sm mx-auto rounded-md shadow-md overflow-hidden relative">
                        <div class="flex items-end justify-end h-56 w-full bg-cover bg-no-repeat overflow-hidden bg-gray-300 relative">
                            <div class="absolute top-[-5px] right-0 bg-sky-500 py-1 px-10 z-10 opacity-80 drop-shadow-md rounded-l-md">
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
