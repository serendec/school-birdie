<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
    <meta name="application-name" content="{{ config('app.name') }}">
    @if (file_exists(public_path() . '/apple-touch-icon.png'))
        <link rel="apple-touch-icon" href="{{ asset('/apple-touch-icon.png') }}">
    @endif
    <title>{{ config('app.name') }}</title>
    @yield('js')
    @vite(['resources/scss/login.scss'])
    @yield('css')
</head>
<body>
    <div id="site-container">
        <header id="site-header">
            <a href="/" class="site-header-name">
                <span class="avator-icon"></span>
                <span class="text">{{ config('app.name') }}</span>
            </a>
        </header>
        <div class="login-content">
            @yield('content')
        </div>
    </div>

    @yield('js-footer')
</body>
</html>
