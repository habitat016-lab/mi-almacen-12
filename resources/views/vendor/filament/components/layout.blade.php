<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Filament Styles -->
    @filamentStyles
    @vite('resources/css/app.css')
</head>
<body class="filament-body">
    <!-- RECUADRO VERDE FIJO EN PARTE SUPERIOR DERECHA -->
    <div style="position: fixed; top: 20px; right: 30px; z-index: 9999; 
max-width: 400px; width: auto;">
        <x-recuadro-verde />
    </div>

    <!-- Contenido principal de Filament -->
    {{ $slot }}

    <!-- Filament Scripts -->
    @filamentScripts
    @vite('resources/js/app.js')
</body>
</html>
