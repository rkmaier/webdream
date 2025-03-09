@extends('main')

@section('content')
    <div class="overflow-x-auto mt-20">
        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm border-gray-200">
            <thead class="ltr:text-left rtl:text-right">
            <tr>
                <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">#</th>
                <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">Name</th>
                <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">Address</th>
                <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">Capacity</th>
                <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">Stock</th>
                <th class="px-4 py-2"></th>
            </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
            <!-- Base -->

            <a
                    class="my-12 mx-5 inline-block rounded-sm bg-indigo-600 px-8 py-3 text-sm font-medium text-white transition hover:scale-110 hover:shadow-xl focus:ring-3 focus:outline-hidden"
                    href="/create"
            >
                Add Warehouse
            </a>

            <a
                    class="my-12 inline-block rounded-sm bg-indigo-600 px-8 py-3 text-sm font-medium text-white transition hover:scale-110 hover:shadow-xl focus:ring-3 focus:outline-hidden"
                    href="/addStock"
            >
                Add Stock
            </a>

            <a
                    class="my-12 mx-5 inline-block rounded-sm bg-indigo-600 px-8 py-3 text-sm font-medium text-white transition hover:scale-110 hover:shadow-xl focus:ring-3 focus:outline-hidden"
                    href="/removeStock"
            >
                Remove Stock
            </a>
            @foreach($warehouses as $warehouse)
                <tr>
                    <td class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">{{ $warehouse->getId() }}</td>
                    <td class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">{{ $warehouse->getName() }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-gray-700">{{ $warehouse->getAddress() }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-gray-700">{{ $warehouse->getCapacity() }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-gray-700">{{ $warehouse->getStocksCount() }}</td>

                    <td class="px-4 py-2 whitespace-nowrap">
                        <a
                                href="/view?id={{ $warehouse->getId() }}"
                                class="inline-block rounded-sm bg-indigo-600 px-4 py-2 text-xs font-medium text-white hover:bg-indigo-700"
                        >
                            View
                        </a>
                    </td>
                </tr>
            @endforeach


            </tbody>
        </table>

        @if($showError)
            <div role="alert" class="rounded-sm border-s-4 border-red-500 bg-red-50 p-4 my-5">
                <strong class="block font-medium text-red-800"> Something went wrong </strong>

                <p class="mt-2 text-sm text-red-700">
                    {{ $msg }}
                </p>
            </div>
        @endif
    </div>
@endsection