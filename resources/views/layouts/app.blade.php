<!DOCTYPE html>
<!--
   _____       _             __  __                 _ _
  / ____|     | |           |  \/  |               | (_)
 | (___   __ _| |_   _____  | \  / |_   _ _ __   __| |_
  \___ \ / _` | \ \ / / _ \ | |\/| | | | | '_ \ / _` | |
  ____) | (_| | |\ V /  __/ | |  | | |_| | | | | (_| | |
 |_____/ \__,_|_| \_/ \___| |_|  |_|\__,_|_| |_|\__,_|_|

 Leuk dat je op onze site kijkt.
 Interesse in onze website? De Github link staat onderaan de website.
 Wil je mee werken aan onze website? Neem dan contact op met de ICT-commissie.

-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="kL20HpcKk8V9pG8cZXgGIuM3PYoPJ2BmV76lrElRIPw" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name'))</title>

    <!-- Scripts -->

    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ mix('js/party.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.css">
    {{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">--}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">    <link href="{{ mix('css/checkbox.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/custom.css') }}" rel="stylesheet">
    <link href="{{ mix('css/tabs.css') }}" rel="stylesheet">
    <link href="{{ mix('css/party.css') }}" rel="stylesheet">
    <link href="{{ mix('css/committeeCard.css') }}" rel="stylesheet">

    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.css"/>
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css"/>

    <script src="https://kit.fontawesome.com/a6479d1508.js" crossorigin="anonymous"></script>

    <!-- Favicons -->

    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/apple-touch-icon.png') }}">
    <link rel="icon" href="{{ asset('images/favicons/favicon.ico') }}">
    <link rel="icon" sizes="32x32" href="{{ asset('images/favicons/favicon-32x32.png') }}">
    <link rel="icon" sizes="16x16" href="{{ asset('images/favicons/favicon-16x16.png') }}">
</head>
<body>
    <div id="app">
        @include('include/navbar')
        @yield('content')
        @include('include/footer')
    </div>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
</body>
</html>
