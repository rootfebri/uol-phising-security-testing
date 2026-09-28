<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'UOL E-mail' }}</title>
    @vite(['resources/css/app.css', 'resources/js/blade.js'])
</head>
<body class="font-sans antialiased">
    {{ $slot }}
</body>
</html>
