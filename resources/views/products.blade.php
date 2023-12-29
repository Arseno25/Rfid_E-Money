@extends('_layouts.master')

@section('body')
<div class="container mx-auto px-6">
    <h3 class="text-gray-700 text-2xl font-medium">Wrist Watch</h3>
    <span class="mt-3 text-sm text-gray-500">{{ $product->count() }} Products</span>
    <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-6">
        @foreach ($product as $item)
        <div class="w-full max-w-sm mx-auto rounded-md shadow-md overflow-hidden">
            <div class="flex items-end justify-end h-56 w-full bg-cover bg-no-repeat overflow-hidden" style="background-image:  ">
                <img class="object-cover w-full h-full hover:scale-110 ease-in-out duration-300" src="{{ $item->getFirstMediaUrl('product_image') }}" alt="">
            </div>
            <div class="px-5 py-3">
                <h2 class="text-gray-700 uppercase justify-center flex">{{ $item->name }}</h2>
                <span class="text-black-100 text-sm mt-2"> Stock: {{ $item->stock }}</span>
                <strong><h3 class="text-gray-500 mt-2">Rp.{{ $item->price }}</h3></strong>
            </div>
        </div>
        @endforeach
    </div>
    <div class="flex justify-center">
        <div class="flex rounded-md mt-8">
            <a href="#" class="py-2 px-4 leading-tight bg-white border border-gray-200 text-blue-700 border-r-0 ml-0 rounded-l hover:bg-blue-500 hover:text-white"><span>Previous</a></a>
            <a href="#" class="py-2 px-4 leading-tight bg-white border border-gray-200 text-blue-700 border-r-0 hover:bg-blue-500 hover:text-white"><span>1</span></a>
            <a href="#" class="py-2 px-4 leading-tight bg-white border border-gray-200 text-blue-700 border-r-0 hover:bg-blue-500 hover:text-white"><span>2</span></a>
            <a href="#" class="py-2 px-4 leading-tight bg-white border border-gray-200 text-blue-700 border-r-0 hover:bg-blue-500 hover:text-white"><span>3</span></a>
            <a href="#" class="py-2 px-4 leading-tight bg-white border border-gray-200 text-blue-700 rounded-r hover:bg-blue-500 hover:text-white"><span>Next</span></a>
        </div>
    </div>
</div>
@endsection
