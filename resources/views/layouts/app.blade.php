<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Mindesign</title>
    
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <div id="app">
        <div class="content">
            <div class="flex-1 sidenav">
                @include('layouts._sidenav')
            </div>
        
            <div class="flex-3">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="/js/app.js"></script>
</body>
</html>
