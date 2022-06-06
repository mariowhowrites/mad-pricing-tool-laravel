<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MadStickers</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        @livewireStyles
    </head>
    <body class="antialiased flex flex-col text-gray-200 items-center justify-center h-full bg-gray-800">
        <livewire:price-calculator />

        @livewireScripts
    </body>
</html>
