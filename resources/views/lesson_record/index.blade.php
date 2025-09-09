@extends('layouts.app')

@section('content')
    @php
        $top_img_path = (Auth::user()->school->top_img) ? '/storage/img/' . Auth::user()->school_id . '/' . Auth::user()->school->top_img : null;
    @endphp
    <div class="imagebg" style="background-image: url({{ $top_img_path }});">
        <div class="imagebg-gra">
            <div class="imagebg-gra-content">
                <h1 class="hd-1">レッスン記録</h1>
                @can('isStudent')
                    <div class="listcontrol">
                        <div class="listcontrol-left">
                            <p class="text size-mini">
                                オフラインレッスンの記録が<br class="sp" />担当講師から届きます。
                            </p>
                        </div>
                @elsecan('isTeacher')
                    <div class="listcontrol mt-24">
                        <div class="listcontrol-left">
                            <a href="{{ route('lesson_record.create') }}" class="button button-primary">
                                <span class="text">新規作成</span>
                            </a>
                        </div>
                @endcan

                        <div class="listcontrol-right">
                            <span class="button button-secondary" id="filter-button">
                                <span class="material-symbols-outlined">
                                    filter_list
                                </span>
                                <span class="text">(<span id="filteredCount">{{ $filteredCount ?? 0 }}</span>)</span>
                            </span>
                            <form action="{{ route('lesson_record.search') }}" method="GET">
                                <div class="filterlist" id="filterlist">
                                    <div class="inputset">
                                        <label for="input-title" class="text size-mini block">タイトル</label>
                                        <div class="text size-middle block">
                                            <input id="input-title" type="text" name="title" value="{{ request()->input('title') ?? '' }}" maxlength="20">
                                        </div>
                                    </div>
                                    <hr />

                                    <div class="inputset">
                                        <label for="input-tag" class="text size-mini block">タグ</label>
                                        <div class="text size-middle block">
                                            <select id="input-tag">
                                                <option value="">選択してください</option>
                                                @foreach ($tags as $tag)
                                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="tagbox" id="tag-list">
                                            @if (isset($selectedTags) && $selectedTags != [])
                                                @foreach ($selectedTags as $selectedTag)
                                                    <span class="tag">
                                                        {{ $selectedTag->name }}
                                                        <button type="button" class="material-symbols-outlined">close</button>
                                                        <input type="hidden" name="tag_ids[]" value="{{ $selectedTag->id }}">
                                                    </span>
                                                @endforeach
                                            @endif
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
                                            <label for="select-student" class="text size-mini block">受講者</label>
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
                                            <label for="select-teacher" class="text size-mini block">作成者</label>
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
                                        @can('isTeacher')
                                            <li>
                                                <label><input type="checkbox" name="post_status" id="post_status" value="draft" {{ request()->input('post_status') == 'draft' ? 'checked' : '' }}>下書き</label>
                                            </li>
                                        @endcan
                                        @can('isStudent')
                                            <li>
                                                <label><input type="checkbox" name="unread" id="unread" value="unread" {{ request()->input('unread') == 'unread' ? 'checked' : '' }}>未読あり</label>
                                            </li>
                                        @endcan
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

        @if ($lessonRecords->isEmpty())
            <div class="empty">
                @if (request()->path() == 'lesson_record')
                    レッスン記録はまだありません。
                @else
                    絞り込み条件に一致するレッスン記録はありません。
                @endif
            </div>
        @else
            <div class="site-body-wrapper">
                @foreach ($lessonRecords as $lessonRecord)
                    <a class="card" href="{{ route('lesson_record.show', $lessonRecord->id) }}">
                        <span class="card-content">
                            <span class="card-header">
                                @if (in_array($lessonRecord->id, $unreadLessonRecordIds))
                                    <span class="texticon type-new">未読</span>
                                @endif
                                <span class="text size-mini">{{ str_replace('-', '/', $lessonRecord->lesson_date) }}</span>
                                @if ($lessonRecord->post_status == 'draft')
                                    <span class="texticon type-notice">下書き</span>
                                @endif
                            </span>
                            <span class="card-name">
                                <span class="namebox">
                                    <span>
                                        <span class="text size-default">{{ $lessonRecord->title ?? '無題' }}</span>
                                    </span>
                                </span>
                            </span>
                            <span class="tagbox">
                                @foreach ($lessonRecord->tags as $tag)
                                    <span class="tag">{{ $tag->name }}</span>
                                @endforeach
                            </span>

                            @can('isTeacher')
                                <span class="outline">
                                    <span class="outline-header text size-mini">受講者</span>
                                    <span class="outline-content">
                                        <span class="teacherlist">
                                            <span class="teacherlist-main">
                                                <span class="namebox">
                                                    @include('partials.icon', [
                                                        'icon' => $lessonRecord->student->icon,
                                                        'size' => 'mini',
                                                    ])
                                                    <span>
                                                        <span class="text size-mini">{{ $lessonRecord->student->family_name }} {{ $lessonRecord->student->first_name }}</span>
                                                    </span>
                                                </span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            @endcan
                            <span class="outline @can('isTeacher') outline-joint @endcan">
                                <span class="outline-header text size-mini">作成者</span>
                                <span class="outline-content">
                                    <span class="teacherlist">
                                        <span class="teacherlist-main">
                                            <span class="namebox">
                                                @include('partials.icon', [
                                                    'icon' => $lessonRecord->teacher->icon,
                                                    'size' => 'mini',
                                                ])
                                                <span>
                                                    <span
                                                        class="text size-mini">{{ $lessonRecord->teacher->family_name }} {{ $lessonRecord->teacher->first_name }}</span>
                                                </span>
                                            </span>
                                        </span>
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

                {{ $lessonRecords->withQueryString()->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>
@endsection

@section('js-footer')
    <script src="{{ asset('js/tag.js') }}"></script>
@endsection
