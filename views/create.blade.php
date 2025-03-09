@extends('main')
@section('pagetitle')
    Create Warehouse
@endsection
@section('content')
    <form action="/save" method="POST" class="mx-auto mt-8 mb-0 max-w-md space-y-4">
        <div>
            <label for="email" class="sr-only">Name</label>

            <div class="relative">
                <input name="name"
                        type="text"
                        class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
                        placeholder="Name"
                />
            </div>
        </div>

        <div>
            <label for="Address" class="sr-only">Address</label>

            <div class="relative">
                <input name="address"
                        type="text"
                        min="1"
                        class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
                        placeholder="Address"
                />
            </div>
        </div>

        <div>
            <label for="Capacity" class="sr-only">Capacity</label>

            <div class="relative">
                <input name="capacity"
                        type="number"
                        class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-xs"
                        placeholder="Capacity"
                />
            </div>
        </div>

        <div class="flex items-center justify-between">


            <button
                    type="submit"
                    class="inline-block rounded-lg bg-blue-500 px-5 py-3 text-sm font-medium text-white">
                Save
            </button>
        </div>
    </form>
@endsection