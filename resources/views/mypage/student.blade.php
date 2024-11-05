@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <h1 class="hd-1">アカウント情報</h1>
        <div class="detail">
            <div class="detail-content">
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="editcase">
                            <div class="editcase-left">
                                <div class="namebox">
                                    @include('partials.icon', [
                                        'icon' => $student->icon,
                                        'size' => 'default',
                                    ])
                                    <div>
                                        <div class="text size-mini block">
                                            {{ $student->family_name_kana }}　{{ $student->first_name_kana }}
                                        </div>
                                        <h1 class="text size-default weight-normal ma-0">
                                            {{ $student->family_name }}　{{ $student->first_name }}
                                        </h1><br>
                                        <span class="text size-mini">ニックネーム：{{ $student->nickname }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="editcase-right">
                                <a href="{{ route('student.edit', $student->id) }}" class="button button-secondary">
                                    <span class="text">編集</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div class="detail-content">
                <div class="detail-content-header">連絡先</div>
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">電話番号</div>
                        <div class="text size-middle block">
                            {{ $student->tel ?? '未設定' }}
                        </div>
                    </div>
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">メール</div>
                        <div class="text size-middle block">
                            {{ $student->email ?? '未設定' }}
                        </div>
                    </div>
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">LINE ID</div>
                        <div class="text size-middle block">
                            {{ $student->line_id ?? '未設定' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="detail-content noedit">
                <div class="detail-content-header">受講プラン</div>
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="text size-middle block">
                            @if ($student->studentProfile != null && $student->studentProfile->lessonPlan != null)
                                {{ $student->studentProfile->lessonPlan->name }}
                            @else
                                未設定
                            @endif
                        </div>
                    </div>
                    @if ($student->studentProfile != null && $student->studentProfile->lessonPlan != null)
                        <div class="detail-content-body-item">
                            <div class="text size-mini block">講座</div>
                            <div class="text size-middle block">
                                {{ $student->studentProfile->lessonPlan->course_available == 0 ? '使用できない' : '使用できる' }}
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="text size-mini block">レッスン記録</div>
                            <div class="text size-middle block">
                                {{ $student->studentProfile->lessonPlan->lesson_record_available == 0 ? '使用できない' : '使用できる' }}
                            </div>
                        </div>
                        <div class="detail-content-body-item">
                            <div class="text size-mini block">動画添削</div>
                            <div class="text size-middle block">
                                {{ $student->studentProfile->lessonPlan->video_advice_available == 0 ? '使用できない' : '使用できる' }}
                            </div>
                            @if ($student->studentProfile->lessonPlan->video_advice_available != 0)
                                <div class="outline in-content mt-8">
                                    <div class="outline-content">
                                        <div class="inputset">
                                            <label for="text1" class="text size-mini block">月の依頼回数</label>
                                            <span class="text size-middle block">
                                                最大
                                                {{ $student->studentProfile->lessonPlan->video_advice_num }}
                                                回まで
                                            </span>
                                        </div>
                                        <div class="inputset mt-16">
                                            <label for="text1" class="text size-mini block">依頼対応期間</label>
                                            <span class="text size-middle block">
                                                依頼後
                                                {{ $student->studentProfile->lessonPlan->video_advice_automatically_close_period }}
                                                日間やり取りできる
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="detail-content-body-item">
                            <div class="text size-mini block">フォーラム</div>
                            <div class="text size-middle block">
                                {{ $student->studentProfile->lessonPlan->forum_available == 0 ? '使用できない' : '使用できる' }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="detail-content noedit">
                <div class="detail-content-header">担当講師</div>
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">メイン</div>
                        <div class="text size-middle block">
                            <span class="teacherlist">
                                <span class="teacherlist-main">
                                    <span class="namebox">
                                        @php
                                            $mainTeacher = $student->teachers->where('category', 'main')->first();
                                        @endphp
                                        @include('partials.icon', [
                                            'icon' => $mainTeacher->icon,
                                            'size' => 'small',
                                        ])
                                        <span>
                                            <span class="text size-small">{{ $mainTeacher->family_name }}　{{ $mainTeacher->first_name }}</span>
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="detail-content-body-item">
                        <div class="text size-mini block">サブ</div>
                        <div class="text size-middle block">
                            <span class="teacherlist">
                                <span class="teacherlist-sub">
                                    @if ($student->teachers->where('category', 'sub')->isNotEmpty())
                                        @foreach ($student->teachers->where('category', 'sub') as $subTeacher)
                                            <span class="namebox">
                                                @include('partials.icon', [
                                                    'icon' => $subTeacher->icon,
                                                    'size' => 'small',
                                                ])
                                                <span class="text size-small">
                                                    {{ $subTeacher->family_name }}　{{ $subTeacher->first_name }}
                                                </span>
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="namebox"><span class="text size-small">未設定</span></span>
                                    @endif
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="detail-content noedit">
                <div class="detail-content-header">登録日</div>
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="text size-middle block">
                            {{ $student->created_at->format('Y/m/d') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
