<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#18A0FB">

        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-K53P4WJ');</script>
        <!-- End Google Tag Manager -->

        <title>{{ isset($page['props']['meta']['title']) ? $page['props']['meta']['title'].__('other.document_title_append') : __('other.document_title_append') }}</title>
        <meta name="description" content="{{ isset($page['props']['meta']['description']) ? $page['props']['meta']['description'] : '' }}">

        <meta property="og:type" content="website" />

        @if(isset($page['props']['meta']))
        <meta property="og:title" content="{{ $page['props']['meta']['title'].__('other.document_title_append') }}" />
        <meta property="og:description" content="{{ $page['props']['meta']['description'] }}" />
        <meta property="og:image" content="{{ $page['props']['meta']['img'] }}" />
        @endif

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
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src=???https://www.googletagmanager.com/ns.html?id=GTM-K53P4WJ???
        height=???0" width=???0??? style=???display:none;visibility:hidden???></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        @inertia
    </body>
</html>
