<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'MadStickers'}}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="antialiased min-h-screen max-h-screen h-full flex flex-col">
    <x-navigation />

    <div class="flex flex-col flex-grow w-full px-4 sm:px-6 lg:px-8 justify-center">
        {{ $slot }}
    </div>

    @livewireScripts
</body>

</html>