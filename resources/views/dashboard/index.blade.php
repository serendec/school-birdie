@extends('layouts.app')

@section('content')
    @php
        $top_img_path = (Auth::user()->school->top_img) ? '/storage/img/' . Auth::user()->school_id . '/' . Auth::user()->school->top_img : '/storage/img/default-top.jpg';
    @endphp
    <div class="imagebg" style="background-image: url({{ $top_img_path }});">
        <div class="imagebg-gra">
            <div class="imagebg-gra-content">
                <div class="indexheader">
                    <div class="indexheader-left">
                        @include('partials.menu.services')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="site-body-wrapper">
        <div class="drawer-menu-content">
            @can('isStudent')
                <div class="indexbox">
                    @if ($recommendVideoAdvice)
                        <div>
                            <div class="hd-2">ピックアップ</div>
                            <a class="card mt-8" href="{{ route('video_advice.create') }}">
                                <span class="card-content">
                                    <span class="card-name mr-16">
                                        <span class="namebox">
                                            <span>
                                                <span class="text size-default">動画添削を利用してみませんか？</span>
                                            </span>
                                        </span>
                                    </span>
                                    <span class="image mr-16">
                                        <img src="https://media.istockphoto.com/id/1319208308/ja/%E3%82%B9%E3%83%88%E3%83%83%E3%82%AF%E3%83%95%E3%82%A9%E3%83%88/%E3%83%97%E3%83%AD%E3%81%AE%E3%82%B4%E3%83%AB%E3%83%95%E3%82%B3%E3%83%BC%E3%82%B9%E3%81%A7%E3%82%B4%E3%83%AB%E3%83%95%E3%82%A1%E3%83%BC%E5%AE%8C%E7%92%A7%E3%81%AA%E3%82%B7%E3%83%A7%E3%83%83%E3%83%88%E3%81%AE%E3%81%9F%E3%82%81%E3%81%AB%E3%83%9C%E3%83%BC%E3%83%AB%E3%82%92%E6%89%93%E3%81%A4%E3%82%B4%E3%83%AB%E3%83%95%E3%82%AF%E3%83%A9%E3%83%96%E3%82%92%E6%8C%81%E3%81%A4%E3%82%B4%E3%83%AB%E3%83%95%E3%82%A1%E3%83%BC.jpg?s=612x612&w=0&k=20&c=nMlENIyd17AqJBPGM_WKHCJJNEoJwV8sCJNS1TJ8jas="
                                            alt="" />
                                    </span>
                                    <span class="description-arrow">
                                        <span class="description">
                                            動画添削では、練習時の動画を送るだけでプロ講師からアドバイスなどを受けることができます。<br />
                                        </span>
                                        <span class="card-arrow">
                                            <span class="material-symbols-outlined">
                                                chevron_right
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </a>
                        </div>
                    @endif
                    
                    {{-- <div>
                        <div class="hd-2">今日のおすすめ講座</div>
                        <ul class="buttonlist mt-8">
                            <li>
                                <a href="{{ route('course.show', 1) }}" class="button button-secondary height-auto">
                                    <span class="textset">
                                        <span class="text block">飛距離を伸ばす5つの方法</span>
                                    </span>
                                    <span class="label-icon">
                                        <span class="material-symbols-outlined">
                                            chevron_right
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('course.show', 2) }}" class="button button-secondary height-auto">
                                    <span class="textset">
                                        <span class="text block">飛距離を伸ばす5つの方法</span>
                                    </span>
                                    <span class="label-icon">
                                        <span class="material-symbols-outlined">
                                            chevron_right
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('course.show', 3) }}" class="button button-secondary height-auto">
                                    <span class="textset">
                                        <span class="text block">飛距離を伸ばす5つの方法</span>
                                    </span>
                                    <span class="label-icon">
                                        <span class="material-symbols-outlined">
                                            chevron_right
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('course.show', 4) }}" class="button button-secondary height-auto">
                                    <span class="textset">
                                        <span class="text block">飛距離を伸ばす5つの方法</span>
                                    </span>
                                    <span class="label-icon">
                                        <span class="material-symbols-outlined">
                                            chevron_right
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('course.show', 5) }}" class="button button-secondary height-auto">
                                    <span class="textset">
                                        <span class="text block">飛距離を伸ばす5つの方法</span>
                                    </span>
                                    <span class="label-icon">
                                        <span class="material-symbols-outlined">
                                            chevron_right
                                        </span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div> --}}
                </div>
            @endcan

            @if (!empty($lessonRecordNotificationsCount) || !empty($videoAdviceNotificationsCount) || !empty($forumNotificationsCount) || !empty($courseNotificationsCount))
                <div class="indexbox">
                    <div>
                        <div class="hd-2">通知</div>
                        <ul class="buttonlist mt-8">
                            @if (isset($lessonRecordNotificationsCount) && $lessonRecordNotificationsCount > 0)
                                <li>
                                    <a href="{{ route('lesson_record.search', ['unread' => 'unread']) }}" class="button button-secondary height-auto">
                                        <span class="textset">
                                            <span class="text size-mini block">レッスン記録</span>
                                            <span class="text block">未読の記録が{{ $lessonRecordNotificationsCount }}つあります。</span>
                                        </span>
                                        <span class="label-icon">
                                            <span class="material-symbols-outlined">
                                                chevron_right
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            @endif

                            @if (isset($videoAdviceNotificationsCount) && $videoAdviceNotificationsCount > 0)
                                <li>
                                    <a href="{{ route('video_advice.search', ['unread' => 'unread']) }}" class="button button-secondary height-auto">
                                        <span class="textset">
                                            <span class="text size-mini block">動画添削</span>
                                            <span class="text block">未読のコメントが{{ $videoAdviceNotificationsCount }}つあります。</span>
                                        </span>
                                        <span class="label-icon">
                                            <span class="material-symbols-outlined">
                                                chevron_right
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            @endif

                            @if (isset($forumNotificationsCount) && $forumNotificationsCount > 0)
                                <li>
                                    <a href="{{ route('forum.search', ['unread' => 'unread']) }}" class="button button-secondary height-auto">
                                        <span class="textset">
                                            <span class="text size-mini block">フォーラム</span>
                                            <span class="text block">未読のコメントが{{ $forumNotificationsCount }}つあります。</span>
                                        </span>
                                        <span class="label-icon">
                                            <span class="material-symbols-outlined">
                                                chevron_right
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            @endif

                            @if (isset($courseNotificationsCount) && $courseNotificationsCount > 0)
                                <li>
                                    <a href="{{ route('course.index') }}" class="button button-secondary height-auto">
                                        <span class="textset">
                                            <span class="text size-mini block">講座</span>
                                            <span class="text block">未読のコメントが{{ $courseNotificationsCount }}つあります。</span>
                                        </span>
                                        <span class="label-icon">
                                            <span class="material-symbols-outlined">
                                                chevron_right
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    {{-- <div>
                        <div class="hd-2">成果</div>
                        <ul class="buttonlist mt-8">
                            <li>
                                <a href="#" class="button button-secondary height-auto">
                                    <span class="textset">
                                        <span class="text size-mini block">レッスン記録</span>
                                        <span class="text size-mini block">スイングのコツについて</span>
                                        <span class="text block">20件</span>
                                    </span>
                                    <span class="label-icon">
                                        <span class="material-symbols-outlined">
                                            chevron_right
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="button button-secondary height-auto">
                                    <span class="textset">
                                        <span class="text size-mini block">レッスン記録</span>
                                        <span class="text size-mini block">スイングのコツについて</span>
                                        <span class="text block">未読のコメントがあります。</span>
                                    </span>
                                    <span class="label-icon">
                                        <span class="material-symbols-outlined">
                                            chevron_right
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="button button-secondary height-auto">
                                    <span class="textset">
                                        <span class="text size-mini block">レッスン記録</span>
                                        <span class="text size-mini block">スイングのコツについて</span>
                                        <span class="text block">未読のコメントがあります。</span>
                                    </span>
                                    <span class="label-icon">
                                        <span class="material-symbols-outlined">
                                            chevron_right
                                        </span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div> --}}
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white">
        <div class="site-body-wrapper">
            <div class="drawer-menu-content">
                <div class="indexbox">
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

                        <div>
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

                    <div class="column column-2">
                        <div>
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
                            <div>
                                <div class="hd-2">法人設定</div>
                                <nav class="listmenu">
                                    <ul>
                                        <li>
                                            <a href="{{ route('school.index') }}" class="button button-secondary width-full">
                                                <span class="namebox">
                                                    @include('partials.icon', [
                                                        'icon' => Auth::user()->school->icon,
                                                        'size' => 'middle',
                                                    ])
                                                    <span>
                                                        <span class="text size-default">
                                                            スクール情報
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
                            <div>
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
                    </div>

                    <div>
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
@endsection
