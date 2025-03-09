@extends('main')
@section('pagetitle')
    Add Stock
@endsection
@section('content')
    <form action="/saveStock" method="POST" class="mx-auto mt-8 mb-0 max-w-md space-y-4">
        <div>
            <label for="email" class="sr-only">Name</label>

            <div class="relative">
                <select name="warehouse" class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs">
                    <option value="">Select Warehouse</option>
                    @foreach($warehouses as $warehouse)
                        <option value="{{ $warehouse->getId() }}">{{ $warehouse->getName() }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label for="Address" class="sr-only">Address</label>

            <div class="relative">
                <select name="product" class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs">
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->getId() }}">{{ $product->getName() }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label for="Capacity" class="sr-only">Capacity</label>

            <div class="relative">
                <input name="stock"
                        min="1"
                        type="number"
                        class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
                        placeholder="Stock Amount"
                />
            </div>
        </div>

        <div class="flex items-center justify-between">


            <button
                    type="submit"
                    class="inline-block rounded-lg bg-blue-500 px-5 py-3 text-sm font-medium text-white"
            >
                Save
            </button>
        </div>
    </form>
@endsection