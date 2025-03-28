<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ $appName }} {{ $appVersion }}</title>
    <link rel="stylesheet" href="/plugins/zui/zui.css">
    @stack('styles')
</head>
<body class="container">

    @include('index/layouts/menu')

    @yield('content')
    <script src="/plugins/zui/zui.js"></script>
    @stack('scripts')
</body>
</html>