<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @livewireStyles
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            @yield('pageTitle', config('app.name'))
        </title>
    </head>
    <body>
        {{ $slot }}
        @livewireScripts
    </body>
</html>
