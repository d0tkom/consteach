<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#18A0FB">

        <title>{{ $page['props']['meta']['title'].__('other.document_title_append') }}</title>
        <meta name="description" content="{{ $page['props']['meta']['description'] }}">

        <meta property="og:type" content="website" />

        <meta property="og:title" content="{{ $page['props']['meta']['title'].__('other.document_title_append') }}" />
        <meta property="og:description" content="{{ $page['props']['meta']['description'] }}" />
        <meta property="og:image" content="{{ $page['props']['meta']['img'] }}" />
        <meta property="og:url" content="{{ url()->full() }}" />
        <meta property="og:site_name" content="ConsTeach" />

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="/css/landing.css">
        <link rel="stylesheet" href="{{ url('css/app.css?ver='.env('ASSET_VERSION', 1)) }}">

        @include('partials.favicon')

        <!-- Scripts -->
        @routes
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
        <script src="{{ url('js/app.js?ver='.env('ASSET_VERSION', 1)) }}" defer></script>
        <script>
            window.app_url = "{{ env('APP_URL') }}";
            window.app_en_url = "{{ env('APP_EN_URL') }}";
            window.default_locale = "{{ config('app.locale') }}";
            window.fallback_locale = "{{ config('app.fallback_locale') }}";
        </script>
    </head>
    <body class="antialiased" data-scroll-lock-fill-gap>
        @inertia
    </body>
</html>
