<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
    <meta name="application-name" content="{{ config('app.name') }}">
    @if (file_exists(public_path() . '/apple-touch-icon.png'))
        <link rel="apple-touch-icon" href="{{ asset('/apple-touch-icon.png') }}">
    @endif

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

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
    <script src="{{ asset('js/upload-movie.js') }}?v={{ filemtime(public_path() . '/js/upload-movie.js') }}"></script>
    @if (Auth::user()->role === 'student')
        <script src="{{ asset('js/favorite.js') }}?v={{ filemtime(public_path() . '/js/favorite.js') }}"></script>
    @endif
    @yield('js')

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}?v={{ filemtime(public_path() . '/css/style.css') }}" rel="stylesheet">
    @yield('css')

    <style>
        {{-- 特商法リンクのスタイル --}}
        .tokushoho-link {
            margin-bottom: 10px;
            a {
                color: #fff!important;
                text-decoration: none;
            }
        }
        .site-footer-app-name {
            font-size: 18px;
            color: #fff;
            margin-bottom: 10px;
        }
    </style>
</head>

<body @if (Request::routeIs('home')) id="home" @endif class="drawer drawer--right">
    @include('partials.menu.drawer')

    <div class="site-header">
        <div class="site-header-left">
            <div class="namebox">
                @include('partials.icon', [
                    'icon' => Auth::user()->school->icon,
                    'size' => 'default',
                ])
                <div>
                    <div class="text size-large">
                        <a href="/" class="site-header-title">{{ Auth::user()->school->name }}</a>
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

    @if (!Request::routeIs('home'))
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
        <div class="site-footer-content">
            <div class="site-footer-app-name">
            オンラインレッスンシステム「バーディーちゃん」
            </div>
            @if(Auth::check() && Route::has('tokushoho.show'))
                <div class="tokushoho-link">
                    <a href="{{ route('tokushoho.show') }}">特定商取引法に基づく表記</a>
                </div>
            @endif

            <span class="text size-small"> &copy SERENDEC</span>
        </div>
    </div>

    @yield('js-footer')
</body>

</html>
