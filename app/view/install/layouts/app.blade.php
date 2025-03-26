<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $appName }} {{ $appVersion }} - @yield('title')</title>
    <link rel="stylesheet" href="/plugins/zui/zui.css">
    @stack('styles')
</head>
<body class="container">
    @yield('content')
    <script src="/plugins/zui/zui.js"></script>
    @stack('scripts')
</body>
</html>