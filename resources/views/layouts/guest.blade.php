<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Poli App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white dark:bg-neutral-900 flex flex-col h-full">
    @include('partials.header-guest')

    <main class="grow">
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
