<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  id="slideshow">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->

    <link rel="icon" href="/images/icon.png">
    
    <link rel="stylesheet" href="/dist/app.css" type="text/css">
    <script type="text/javascript" src="/dist/app.js"></script>
    <script type="text/javascript" src="/dist/vues.js" defer></script>

</head>
<body data-bs-theme="dark">
@yield('content')

@yield('javascripts')
</body>
</html>
