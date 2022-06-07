<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? 'MadStickers'}}</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        @livewireStyles
    </head>
    <body class="antialiased flex flex-col text-white items-center justify-center h-full bg-blue-700">
        {{ $slot }}

        @livewireScripts
    </body>
</html>
