@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">生徒管理</h1>

        <div class="listcontrol">
            <div class="listcontrol-left">
                <a href="{{ route('student.qrcode') }}" class="button button-primary">
                    <span class="text">アカウント発行</span>
                </a>
            </div>
            <div class="listcontrol-right">
                <span class="button button-secondary" id="filter-button">
                    <span class="material-symbols-outlined">
                        filter_list
                    </span>
                    <span class="text">(<span id="filteredCount">{{ $filteredCount ?? 0 }}</span>)</span>
                </span>
                <form action="{{ route('student.search') }}" method="GET">
                    <div class="filterlist" id="filterlist">
                        <div class="inputset">
                            <label for="input-name" class="text size-mini block">名前</label>
                            <div class="text size-middle block">
                                <input id="input-name" type="text" name="name" value="{{ request()->input('name') ?? '' }}" maxlength="20">
                            </div>
                        </div>
                        <div class="inputset mt-16">
                            <label for="input-nickname" class="text size-mini block">ニックネーム</label>
                            <div class="text size-middle block">
                                <input id="input-nickname" type="text" name="nickname" value="{{ request()->input('nickname') ?? '' }}" maxlength="20">
                            </div>
                        </div>
                        <hr />

                        <div class="inputset">
                            <label for="select-main_teacher" class="text size-mini block">メイン担当</label>
                            <div class="text size-middle block">
                                <select id="select-main_teacher" name="main_teacher_id">
                                    <option value="">選択してください</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ request()->input('main_teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->family_name }}　{{ $teacher->first_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="inputset mt-16">
                            <label for="select-sub_teacher" class="text size-mini block">サブ担当</label>
                            <div class="text size-middle block">
                                <select id="select-sub_teacher" name="sub_teacher_id">
                                    <option value="">選択してください</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ request()->input('sub_teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->family_name }}　{{ $teacher->first_name }}</option>
                                    @endforeach
                                </select>
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
                                <label><input type="checkbox" name="inactive" id="inactive" value="1" {{ request()->input('inactive') == '1' ? 'checked' : '' }}>退会者</label>
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

        @if ($students->isEmpty())
            <div class="empty">
                @if (request()->path() == 'student')
                    生徒が登録されていません。
                @else
                    絞り込み条件に一致する生徒がおりません。
                @endif
            </div>
        @else
            @foreach ($students as $student)
                <a class="card" href="{{ route('student.show', $student->id) }}">
                    <span class="card-content">
                        <span class="card-name">
                            <span class="namebox">
                                @include('partials.icon', ['icon' => $student->icon, 'size' => 'default'])
                                <span>
                                    <span class="text size-mini">{{ $student->family_name_kana }}　{{ $student->first_name_kana }}</span><br />
                                    <span class="text size-default">{{ $student->family_name }}　{{ $student->first_name }}</span><br />
                                    <span class="text size-mini">ニックネーム：{{ $student->nickname }}</span><br />
                                </span>
                            </span>
                        </span>
                        <span class="outline">
                            <span class="outline-header text size-mini">担当</span>
                            <span class="outline-content">
                                <span class="teacherlist">
                                    <span class="teacherlist-main">
                                        <span class="namebox">
                                            @php
                                                $mainTeacher = $student->teachers->where('category', 'main')->first();
                                            @endphp
                                            @include('partials.icon', [
                                                'icon' => $mainTeacher->icon,
                                                'size' => 'mini',
                                            ])
                                            <span>
                                                <span class="text size-mini">{{ $mainTeacher->family_name }}　{{ $mainTeacher->first_name }}</span>
                                            </span>
                                        </span>
                                    </span>
                                    @if ($student->teachers->where('category', 'sub')->isNotEmpty())
                                        <span class="teacherlist-sub">
                                            @foreach ($student->teachers->where('category', 'sub') as $subTeacher)
                                                <span class="namebox">
                                                    @include('partials.icon', [
                                                        'icon' => $subTeacher->icon,
                                                        'size' => 'mini',
                                                    ])
                                                    <span>
                                                        <span class="text size-mini">{{ $subTeacher->family_name }}　{{ $subTeacher->first_name }}</span>
                                                    </span>
                                                </span>
                                            @endforeach
                                        </span>
                                    @endif
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

            {{ $students->links('vendor.pagination.custom') }}
        @endif
    </div>
@endsection
