@php
$versions = config('api-doc.versions');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name') }}</title>
        <meta name="description" content="{{ $description ?? '' }}">

        <meta name="robots" content="noindex">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

        {{-- <link href="{{ asset(mix('css/doc.css', 'vendor/api-doc')) }}" rel="stylesheet"> --}}
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        {{-- <script src="{{ asset(mix('js/doc.js', 'vendor/api-doc')) }}" defer></script> --}}
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>

    <body class="antialiased font-sans">
        <div x-data="{version: {{ count($versions) > 1 ? '\'' . reset($versions) . '\'' : 'null' }}}" class="overflow-hidden relative flex h-screen">
            <x-api-doc::nav></x-api-doc::nav>

            <section class="w-full h-full overflow-y-auto">
                {{ $slot }}
            </section>
        </div>
    </body>
</html>
