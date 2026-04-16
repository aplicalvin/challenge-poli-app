<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Poli App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="dark:bg-neutral-900 bg-gray-100 flex h-full items-center py-16">
    <main class="w-full max-w-md mx-auto p-6">
        @yield('content')
    </main>
</body>
</html>
