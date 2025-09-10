<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'TravelBlogJP') }}</title>

    {{-- 載入 Vite 編譯後的 JS 與 CSS --}}
    @vite(['resources/js/app.js', 'resources/css/app.css'])

    {{-- Laravel 內建的 CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="antialiased">
    {{-- Vue SPA 掛載點 --}}
    <div id="app"></div>
</body>
</html>
