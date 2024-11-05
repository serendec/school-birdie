@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">講師管理</h1>

        <div class="listcontrol">
            <div class="listcontrol-left">
                @can('isAdmin')
                    <a href="{{ route('teacher.qrcode') }}" class="button button-primary">
                        <span class="text">アカウント発行</span>
                    </a>
                @endcan
            </div>
            <div class="listcontrol-right">
                <span class="button button-secondary" id="filter-button">
                    <span class="material-symbols-outlined">
                        filter_list
                    </span>
                    <span class="text">(<span id="filteredCount">{{ $filteredCount ?? 0 }}</span>)</span>
                </span>
                <form action="{{ route('teacher.search') }}" method="GET">
                    <div class="filterlist" id="filterlist">
                        <div class="inputset">
                            <label for="input-name" class="text size-mini block">名前</label>
                            <div class="text size-middle block">
                                <input id="input-name" type="text" name="name" value="{{ request()->input('name') ?? '' }}" maxlength="20">
                            </div>
                        </div>
                        <hr />

                        <div class="inputset">
                            <label for="input-tel" class="text size-mini block">電話番号</label>
                            <div class="text size-middle block">
                                <input id="input-tel" type="text" name="tel" value="{{ request()->input('tel') ?? '' }}" maxlength="13">
                            </div>
                        </div>
                        <div class="inputset mt-16">
                            <label for="input-email" class="text size-mini block">メールアドレス</label>
                            <div class="text size-middle block">
                                <input id="input-email" type="text" name="email" value="{{ request()->input('email') ?? '' }}" maxlength="20">
                            </div>
                        </div>
                        <hr />                        

                        <span class="text size-mini">ステータス</span>
                        <ul>
                            <li>
                                <label><input type="checkbox" name="inactive" id="inactive" value="1" {{ request()->input('inactive') == '1' ? 'checked' : '' }}>退職者</label>
                            </li>
                        </ul>
                        <hr />

                        <div class="buttonset">
                            <button class="button button-primary" type="submit">
                                <span class="text">絞り込み</span>
                            </button>
                            <button id="filter-reset-button" class="button button-secondary" type="button">
                                <span class="text">リセット</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if ($teachers->isEmpty())
            <div class="empty">
                @if (request()->path() == 'student')
                    講師が登録されていません。
                @else
                    絞り込み条件に一致する講師がおりません。
                @endif
            </div>
        @else
            @foreach ($teachers as $teacher)
                <a class="card" href="{{ route('teacher.show', $teacher->id) }}">
                    <span class="card-content">
                        <span class="card-name">
                            <span class="namebox">
                                @include('partials.icon', ['icon' => $teacher->icon, 'size' => 'default'])
                                <span>
                                    <span class="text size-mini">{{ $teacher->family_name_kana }}　{{ $teacher->first_name_kana }}</span><br />
                                    <span class="text size-default">{{ $teacher->family_name }}　{{ $teacher->first_name }}</span><br />
                                    <span class="text size-mini">メイン {{ $teacher->students->where('category', 'main')->count() }}名 ／ サブ {{ $teacher->students->where('category', 'sub')->count() }}名</span>
                                </span>
                            </span>
                        </span>
                    </span>
                    <span class="card-arrow">
                        <span class="material-symbols-outlined">
                            chevron_right
                        </span>
                    </span>
                </a>
            @endforeach

            {{ $teachers->links('vendor.pagination.custom') }}
        @endif
    </div>
@endsection
