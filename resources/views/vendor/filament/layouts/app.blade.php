{{-- resources/views/vendor/filament/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ filament()->getTitle() }}</title>
    <link rel="icon" href="{{ secure_asset('assets/img/LogoEkraf.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    @filamentStyles
</head>
<body class="filament-body">
    {{ $slot }}
    @filamentScripts
</body>
</html>
