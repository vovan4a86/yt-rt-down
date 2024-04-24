<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <META NAME="robots" CONTENT="noindex,nofollow">
    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}" media="all">
    <script src="{{ mix('js/app.js') }}" defer></script>
    @yield('head')
    <title>@yield('title')</title>
</head>
<body class="bg-dark">

    <div class="container">
        @yield('content')
    </div>

</body>
</html>
