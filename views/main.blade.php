<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Warehouse Management</title>
    @yield('styles')
</head>
<body>
<div class="mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-lg text-center">
        <h1 class="text-2xl font-bold sm:text-3xl"><a href="/">Manage Warehouses</a></h1>

        <p class="mt-4 text-gray-500">
            @yield('pagetitle')
        </p>
    </div>
    @yield('content')
</div>
@yield('scripts')
</body>
