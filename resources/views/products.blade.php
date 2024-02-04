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
                        <img class="h-48 w-full object-cover object-center" src="https://images.unsplash.com/photo-1674296115670-8f0e92b1fddb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80" alt="Product Image" />
                        <div class="p-4">
                            <h2 class="mb-2 text-lg font-medium dark:text-white text-gray-900">Product Name</h2>
                            <p class="mb-2 text-base dark:text-gray-300 text-gray-700">Product description goes here.</p>
                            <div class="flex items-center">
                                <p class="mr-2 text-lg font-semibold text-gray-900 dark:text-white">$20.00</p>
                                <p class="text-base  font-medium text-gray-500 line-through dark:text-gray-300">$25.00</p>
                                <p class="ml-auto text-base font-medium text-green-500">20% off</p>
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
