<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#18A0FB">

        <title>{{ config('app.name', 'ConsTeach') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="/css/landing.css">
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @include('partials.favicon')

        <!-- Scripts -->
        @routes
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script>
            window.default_locale = "{{ config('app.locale') }}";
            window.fallback_locale = "{{ config('app.fallback_locale') }}";
        </script>
    </head>
    <body class="antialiased" data-scroll-lock-fill-gap>
        @inertia
    </body>
</html>
