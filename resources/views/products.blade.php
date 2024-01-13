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
                    <div class="mx-auto mt-11 w-80 transform overflow-hidden rounded-lg bg-white dark:bg-slate-800 shadow-md duration-300 hover:scale-105 hover:shadow-lg">
                        <div class="absolute shadow-cyan-500/50 bg-cyan-500 shadow-md w-25 top-[-5px] right-0  py-1 px-10 z-10 opacity-80 rounded-l-md">
                             <span class="text-white font-12">Stock: {{ $item->stock }}</span>
                         </div>
                        @if ($item->getFirstMediaUrl('product_image'))
                        <img class="h-48 w-full object-cover object-center" src="{{$item->getFirstMediaUrl('product_image')}}" alt="Product Image" />
                        @else
                        <img class="h-48 w-full object-cover object-center" src="{{ asset('default.png') }}" alt="Product Image" />
                        @endif
                        <div class="p-4">
                            <div class="flex items-center justify-start mb-2">
                                <span class="shadow-cyan-500/50 bg-cyan-500 items-center shadow-md text-black-100 text-sm mt-2 justify-center flex rounded-full px-2 py-1 font-semibold text-white">{{ $item->category->name }}</span>
                            </div>
                            <h2 class="mb-2 text-lg font-bold dark:text-white text-gray-900">{{ $item->name }}</h2>
                            <p class="mb-2 text-base dark:text-gray-300 text-gray-700">{{ $item->description }}</p>
                            <div class="flex items-center">
                                <p class="mr-2 text-lg font-semibold text-gray-900 dark:text-white">{{ formatCurrency($item->price - ($item->price * $discount->percentage / 100)) }}</p>
                                <p class="text-base font-medium text-gray-500 line-through dark:text-gray-300">{{ formatCurrency($item->price) }}</p>
                                <p class="ml-auto text-base font-medium text-green-500">{{ $discount->percentage }}% off</p>
                            </div>
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
