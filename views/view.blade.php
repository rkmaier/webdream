@extends('main')
@section('pagetitle')
    View Warehouse
@endsection
@section('content')
    <div class="overflow-x-auto mt-20">
        @foreach($warehouse->getStocks() as $key => $stock)
            <article class="rounded-lg border border-gray-100 bg-white p-6 my-12">
                <div>
                    <p class="text-3xl text-gray-900">{{ $stock->getName() }}</p>

                    <p class="text-2xs font-medium text-gray-900"><span>Quantity: </span> {{ $key }}</p>
                </div>
                <p class="text-2xs underline font-medium text-gray-900"><span>Product details: </span></p>
                <div class="mt-2 space-y-1">
                    @if($stock instanceof \App\Model\Tablet)
                        <p class="text-sm text-gray-700"><span
                                    class="font-medium">Screen Size:</span> {{ $stock->getScreenSize() }}</p>
                        <p class="text-sm text-gray-700"><span
                                    class="font-medium">Storage:</span> {{ $stock->getStorageCapacity() }} GB</p>
                    @elseif($stock instanceof \App\Model\Book)
                        <p class="text-sm text-gray-700"><span
                                    class="font-medium">Author:</span> {{ $stock->getAuthor() }}</p>
                        <p class="text-sm text-gray-700"><span class="font-medium">ISBN:</span> {{ $stock->getIsbn() }}
                        </p>
                        <p class="text-sm text-gray-700"><span
                                    class="font-medium">Pages:</span> {{ $stock->getPages() }}</p>
                        <p class="text-sm text-gray-700"><span
                                    class="font-medium">Genre:</span> {{ $stock->getGenre() }}</p>
                    @endif
                    <p class="text-sm text-gray-700"><span
                                class="font-medium">Brand:</span> {{ $stock->getBrand()->getName() }}</p>
                    <p class="text-sm text-gray-700"><span class="font-medium">Price:</span> ${{ $stock->getPrice() }}
                    </p>
                </div>
            </article>
        @endforeach
    </div>
@endsection