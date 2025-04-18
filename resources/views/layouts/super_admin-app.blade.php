<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="apple-mobile-web-app-title" content="バーディーちゃん">
    <meta name="application-name" content="バーディーちゃん">
    <link rel="apple-touch-icon" href="{{ asset('/apple-touch-icon.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>バーディーちゃん（ゴルフレッスン管理システム）</title>

    <!-- Scripts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.2.1/css/drawer.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.1.3/iscroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.2.1/js/drawer.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/i18n/ja.js"></script>
    <script>
        $(document).ready(function () {
            $(".drawer").drawer();
        });
    </script>
    <script src="{{ asset('js/common.js') }}?v={{ filemtime(public_path() . '/js/common.js') }}"></script>
    @yield('js')

    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}?v={{ filemtime(public_path() . '/css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @yield('css')
</head>

<body class="drawer drawer--right">
    @include('partials.super-admin.menu.drawer')
    
    <div class="site-header">
        <div class="site-header-left">
            <div class="namebox">
                <span class="avator size-default" style="background-image:url({{ asset('img/superadmin-logo.png') }});"></span>
                <div>
                    <div class="text size-large">
                        <a href="/" class="site-header-title">SERENDEC</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="site-header-right">
            <div id="drawer">
                <button type="button" class="drawer-toggle drawer-hamburger">
                    <span class="sr-only">toggle navigation</span>
                    <span class="drawer-hamburger-icon"></span>
                </button>
            </div>
        </div>
    </div>

    @if (!Request::routeIs('super_admin.home'))
        <div class="backwards">
            @foreach (Breadcrumbs::generate() as $breadcrumb)
                <a href="{{ $breadcrumb->url }}" class="button button-thirdly">
                    <span class="material-symbols-outlined"> chevron_left </span>
                    <span class="text">{{ $breadcrumb->title }}</span>
                </a>
            @endforeach
        </div>
    @endif
    
    <main class="site-body">
        @include('partials.message')
        @yield('content')
    </main>

    <div class="site-footer">
        <span class="text size-small"> &copy SERENDEC
        </span>
    </div>

    @yield('js-footer')
</body>

</html>
