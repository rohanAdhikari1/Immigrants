<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'ग्रामथान गाउँपालिका' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles()
    @stack('styles')
</head>

<body class="bg-gray-100">
    @include('components.layouts.header')
    <main>
        {{ $slot }}
    </main>
    @livewireScripts()
    @stack('scripts')
</body>

</html>
