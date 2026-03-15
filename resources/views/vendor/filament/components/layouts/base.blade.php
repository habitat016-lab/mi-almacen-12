<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ __('filament::layout.direction') ?? 'ltr' }}"
    @class([
        'filament',
        'dark' => filament()->hasDarkModeForced(),
    ])
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name') }}</title>

    <style>
        [x-cloak] { display: none !important; }
    </style>

    @filamentStyles
    @vite('resources/css/app.css')
    {{ filament()->getTheme()->getHtml() }}
    {{ filament()->getFontHtml() }}

    @stack('styles')
</head>

<body class="filament-body bg-gray-50 text-gray-900 dark:bg-gray-900 
dark:text-white">
    <!-- INFO USUARIO PERSONALIZADA -->
    @auth
        <div style="position: absolute; top: 10px; right: 20px; z-index: 
50;">
            @include('panel.info-usuario')
        </div>
    @endauth

    {{ $slot }}

    @livewire('notifications')

    @filamentScripts
    @vite('resources/js/app.js')
    
    @stack('scripts')
</body>
</html>
