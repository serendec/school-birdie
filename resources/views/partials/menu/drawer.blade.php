@php
    $top_img_path = (Auth::user()->school->top_img) ? '/storage/img/' . Auth::user()->school_id . '/' . Auth::user()->school->top_img : '/storage/img/default-top.jpg';
@endphp
<div class="drawer-nav" id="drawer-content">
    <div class="drawer-menu">
        <div class="drawer-menu-header">
            <div class="drawer-menu-header-bg" style="background-image: url({{ $top_img_path }});">
                <div class="drawer-menu-header-bg-gra">
                    @include('partials.menu.services')
                </div>
            </div>
        </div>
        
        <div class="drawer-menu-content">
            @can('isTeacher')
                <div>
                    <div class="hd-2">アカウント発行</div>
                    <nav class="listmenu">
                        <ul>
                            <li>
                                <a href="{{ route('student.qrcode') }}" class="button button-secondary width-full">
                                    <span class="material-symbols-outlined">
                                        qr_code
                                    </span>
                                    <span class="text">生徒アカウント</span>
                                    <span class="material-symbols-outlined">
                                        chevron_right
                                    </span>
                                </a>
                            </li>

                            @can('isAdmin')
                                <li>
                                    <a href="{{ route('teacher.qrcode') }}" class="button button-secondary width-full">
                                        <span class="material-symbols-outlined">
                                            qr_code
                                        </span>
                                        <span class="text">講師アカウント</span>
                                        <span class="material-symbols-outlined">
                                            chevron_right
                                        </span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </nav>
                </div>

                <div class="mtbox">
                    <div class="hd-2">管理メニュー</div>
                    <nav class="listmenu">
                        <ul>
                            <li>
                                <a href="{{ route('student.index') }}" class="button button-secondary width-full">
                                    <span class="text">生徒管理</span>
                                    <span class="material-symbols-outlined">
                                        chevron_right
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('teacher.index') }}" class="button button-secondary width-full">
                                    <span class="text">講師管理</span>
                                    <span class="material-symbols-outlined">
                                        chevron_right
                                    </span>
                                </a>
                            </li>

                            @can('isAdmin')
                                <li>
                                    <a href="{{ route('lesson_plan.index') }}" class="button button-secondary width-full">
                                        <span class="text">受講プラン管理</span>
                                        <span class="material-symbols-outlined">
                                            chevron_right
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('course_category.index') }}" class="button button-secondary width-full">
                                        <span class="text">講座カテゴリ管理</span>
                                        <span class="material-symbols-outlined">
                                            chevron_right
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('tag.index') }}" class="button button-secondary width-full">
                                        <span class="text">タグ管理</span>
                                        <span class="material-symbols-outlined">
                                            chevron_right
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://dashboard.stripe.com" class="button button-secondary width-full" target="_blank" rel="noopener noreferrer">
                                        <span class="text">決済管理</span>
                                        <span class="material-symbols-outlined">
                                            chevron_right
                                        </span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </nav>
                </div>
            @endcan

            <div class="mtbox">
                <div class="hd-2">個人設定</div>
                <nav class="listmenu">
                    <ul>
                        <li>
                            <a href="{{ route('mypage') }}" class="button button-secondary width-full">
                                <span class="text">基本情報</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('password.edit') }}" class="button button-secondary width-full">
                                <span class="text">パスワード変更</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            @can('isAdmin')
                <div class="mtbox">
                    <div class="hd-2">法人設定</div>
                    <nav class="listmenu">
                        <ul>
                            <li>
                                <a href="{{ route('school.index') }}" class="button button-secondary width-full">
                                    <span class="namebox">
                                        @include('partials.icon', ['icon' => Auth::user()->school->icon, 'size' => 'middle'])
                                        <span>
                                            <span class="text size-default">
                                                {{ Auth::user()->school->name }}
                                            </span>
                                        </span>
                                    </span>
                                    <span class="material-symbols-outlined">
                                        chevron_right
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('school.contract') }}" class="button button-secondary width-full">
                                    <span class="text">契約情報</span>
                                    <span class="material-symbols-outlined">
                                        chevron_right
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            @endcan

            @can('isStudent')
                <div class="mtbox">
                    <div class="hd-2">お気に入り</div>
                    <nav class="listmenu">
                        <ul>
                            <li>
                                <a href="{{ route('favorite.index') }}" class="button button-secondary width-full">
                                    <span class="text">動画</span>
                                    <span class="material-symbols-outlined">
                                        chevron_right
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            @endcan

            <div class="mtbox">
                <div class="hd-2">サポート</div>
                <nav class="listmenu">
                    <ul>
                        <li>
                            <a href="{{ route('contact.create') }}" class="button button-secondary width-full">
                                <span class="text">お問い合わせ</span>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="drawer-menu-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="button button-thirdly">
                    <span class="text">ログアウト</span>
                    <span class="material-symbols-outlined"> logout </span>
                </button>
            </form>
        </div>
    </div>
</div>
