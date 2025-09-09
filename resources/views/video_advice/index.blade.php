@extends('layouts.app')

@section('content')
    @php
        $top_img_path = (Auth::user()->school->top_img) ? '/storage/img/' . Auth::user()->school_id . '/' . Auth::user()->school->top_img : null;
    @endphp
    <div class="imagebg" style="background-image: url({{ $top_img_path }});">
        <div class="imagebg-gra">
            <div class="imagebg-gra-content">
                <h1 class="hd-1">動画添削</h1>
                @can('isStudent')
                    <div class="listcontrol">
                        <div class="listcontrol-left">
                            <p class="text size-mini">
                                自身で撮影した動画について<br class="sp" />担当講師から添削が届きます。
                            </p>
                        </div>
                    </div>
                    <div class="listcontrol mt-24">
                        <div class="listcontrol-left">
                            <a href="{{ route('video_advice.create') }}" class="button button-primary">
                                <span class="text">新規作成</span>
                            </a>
                        </div>
                @elsecan('isTeacher')
                    <div class="listcontrol">
                        <div class="listcontrol-left"></div>
                @endcan

                        <div class="listcontrol-right">
                            <span class="button button-secondary" id="filter-button">
                                <span class="material-symbols-outlined">
                                    filter_list
                                </span>
                                <span class="text">(<span id="filteredCount">{{ $filteredCount ?? 0 }}</span>)</span>
                            </span>
                            <form action="{{ route('video_advice.search') }}" method="GET">
                                <div class="filterlist" id="filterlist">
                                    <div class="inputset">
                                        <label for="input-title" class="text size-mini block">タイトル</label>
                                        <div class="text size-middle block">
                                            <input id="input-title" type="text" name="title" value="{{ request()->input('title') ?? '' }}" maxlength="20">
                                        </div>
                                    </div>
                                    <hr />

                                    <div class="inputset">
                                        <label for="input-from" class="text size-mini block">期間</label>
                                        <div class="text size-middle block">
                                            <input id="input-from" name="from" type="date" value="{{ request()->input('from') ?? '' }}"><br> 〜 <input id="input-to" name="to" type="date" value="{{ request()->input('to') ?? '' }}">
                                        </div>
                                    </div>
                                    <hr />

                                    @can('isTeacher')
                                        <div class="inputset">
                                            <label for="select-student" class="text size-mini block">生徒</label>
                                            <div class="text size-middle block">
                                                <select id="select-student" name="student_id">
                                                    <option value="">選択してください</option>
                                                    @foreach ($students as $student)
                                                        <option value="{{ $student->id }}" {{ request()->input('student_id') == $student->id ? 'selected' : '' }}>{{ $student->family_name }}　{{ $student->first_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="inputset mt-16">
                                            <label for="select-teacher" class="text size-mini block">担当</label>
                                            <div class="text size-middle block">
                                                <select id="select-teacher" name="teacher_id">
                                                    <option value="">選択してください</option>
                                                    @foreach ($teachers as $teacher)
                                                        <option value="{{ $teacher->id }}" {{ request()->input('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->family_name }}　{{ $teacher->first_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <hr />
                                    @endcan

                                    <span class="text size-mini">ステータス</span>
                                    <ul>
                                        <li>
                                            <label><input type="checkbox" name="status" id="status" value="open" {{ request()->input('status') == 'open' ? 'checked' : '' }}>未了</label>
                                        </li>
                                        <li>
                                            <label><input type="checkbox" name="unread" id="unread" value="unread" {{ request()->input('unread') == 'unread' ? 'checked' : '' }}>未読あり</label>
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
                </div>
            </div>
        </div>

        @if ($videoAdviceList->isEmpty())
            <div class="empty">
                @if (request()->path() == 'video_advice')
                    動画添削はまだありません。
                @else
                    絞り込み条件に一致する動画添削はありません。
                @endif
            </div>
        @else
            <div class="site-body-wrapper">
                @foreach ($videoAdviceList as $videoAdvice)
                    <a class="card" href="{{ route('video_advice.show', $videoAdvice->id) }}">
                        <span class="card-content">
                            <span class="card-header">
                                @if (in_array($videoAdvice->id, $unreadVideoAdviceIds))
                                    <span class="texticon type-new">未読</span>
                                @endif
                                <span class="text size-mini">{{ $videoAdvice->created_at->format('Y/m/d') }}</span>
                                @if ($videoAdvice->status == 'closed')
                                    <span class="texticon type-done">終了</span>
                                @else
                                    <span class="texticon type-notice">未了</span>
                                @endif
                            </span>
                            <span class="card-name">
                                <span class="namebox">
                                    <span>
                                        <span class="text size-default">{{ $videoAdvice->title }}</span>
                                    </span>
                                </span>
                            </span>

                            @can('isTeacher')
                                <span class="outline">
                                    <span class="outline-header text size-mini">生徒</span>
                                    <span class="outline-content">
                                        <span class="teacherlist">
                                            <span class="teacherlist-main">
                                                <span class="namebox">
                                                    @include('partials.icon', [
                                                        'icon' => $videoAdvice->student->icon,
                                                        'size' => 'mini',
                                                    ])
                                                    <span>
                                                        <span class="text size-mini">{{ $videoAdvice->student->family_name }} {{ $videoAdvice->student->first_name }}</span>
                                                    </span>
                                                </span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            @endcan
                            <span class="outline @can('isTeacher') outline-joint @endcan">
                                <span class="outline-header text size-mini">担当</span>
                                <span class="outline-content">
                                    <span class="teacherlist">
                                        <span class="teacherlist-main">
                                            <span class="namebox">
                                                @php
                                                    $mainTeacher = $videoAdvice->student->teachers->where('category', 'main')->first();
                                                @endphp
                                                @include('partials.icon', [
                                                    'icon' => $mainTeacher->icon,
                                                    'size' => 'mini',
                                                ])
                                                <span>
                                                    <span
                                                    class="text size-mini">{{ $mainTeacher->family_name }} {{ $mainTeacher->first_name }}</span>
                                                </span>
                                            </span>
                                        </span>
                                        @if ($videoAdvice->student->teachers->where('category', 'sub')->isNotEmpty())
                                            <span class="teacherlist-sub">
                                                @foreach ($videoAdvice->student->teachers->where('category', 'sub') as $subTeacher)
                                                    <span class="namebox">
                                                        @include('partials.icon', [
                                                            'icon' => $subTeacher->icon,
                                                            'size' => 'mini',
                                                        ])
                                                        <span>
                                                            <span
                                                                class="text size-mini">{{ $subTeacher->family_name }} {{ $subTeacher->first_name }}</span>
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

                {{ $videoAdviceList->withQueryString()->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>
@endsection

@section('js-footer')
    <script src="{{ asset('js/tag.js') }}"></script>
@endsection
