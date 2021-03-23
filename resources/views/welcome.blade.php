<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="/css/landing.css">

        <!-- Scripts -->
        @routes
        <script src="https://kit.fontawesome.com/6ac5664eee.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script>
            window.default_locale = "{{ config('app.locale') }}";
            window.fallback_locale = "{{ config('app.fallback_locale') }}";
        </script>
    </head>
<body>

</body>

</html>