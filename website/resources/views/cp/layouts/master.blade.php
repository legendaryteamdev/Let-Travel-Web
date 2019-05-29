<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>

        <link href="{{ asset ('img/favicon.144x144.png.html') }}" rel="apple-touch-icon" type="image/png" sizes="144x144">
        <link href="{{ asset ('img/favicon.114x114.png.html') }}" rel="apple-touch-icon" type="image/png" sizes="114x114">
        <link href="{{ asset ('img/favicon.72x72.png.html') }}" rel="apple-touch-icon" type="image/png" sizes="72x72">
        <link href="{{ asset ('img/favicon.57x57.png.html') }}" rel="apple-touch-icon" type="image/png">
        <link href="{{ asset ('img/favicon.png.html') }}" rel="icon" type="image/png">
        <link href="{{ asset ('img/favicon.ico.html') }}" rel="shortcut icon">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        @yield('headercss')
    </head>
    <body @yield('bodyclass') >
        @yield('header')
        @yield('menu')
        @yield('content')
        @yield ('modal')
        @yield('bottomjs')
    </body>
</html>