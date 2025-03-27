@extends('layouts.app')

@section('content')
    @php
        $top_img_path = (Auth::user()->school->top_img) ? '/storage/img/' . Auth::user()->school_id . '/' . Auth::user()->school->top_img : '/storage/img/default-top.jpg';
    @endphp
    <div class="imagebg" style="background-image: url({{ $top_img_path }});">
        <div class="imagebg-gra">
            <div class="imagebg-gra-content">
                <h1 class="hd-1">ゴルフ講座</h1>

                @can('isStudent')
                    <div class="listcontrol">
                        <div class="listcontrol-left">
                            <p class="text size-mini">
                                いつでも閲覧可能なゴルフ講座を利用して<br
                                class="sp"
                            />ステップアップしましょう。
                            </p>
                @elsecan('isTeacher')
                    <div class="listcontrol mt-24">
                        <div class="listcontrol-left">
                            <a href="{{ route('course.create') }}" class="button button-primary">
                                <span class="text">新規作成</span>
                            </a>
                            @can('isAdmin')
                                <a href="{{ route('course.update_order_index') }}" class="button button-secondary">
                                    <span class="text">順序変更</span>
                                </a>
                                <a href="{{ route('course_category.index') }}" class="button button-secondary">
                                    <span class="text">カテゴリ設定</span>
                                </a>
                            @endcan
                @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="site-body-wrapper">
        @if ($categories->isEmpty())
            <div class="empty">講座はまだありません。</div>
        @else
            @foreach ($categories as $category)
                @php
                    if ($category->courses->isEmpty()) {
                        continue;
                    }
                @endphp
                <h3 class="course-category-name">{{ $category->name }}</h3>
                <ul class="buttonlist ma-0">
                    @foreach ($category->courses as $course)
                        <li>
                            <a href="{{ route('course.show', $course->id) }}" class="button button-secondary">
                                <span class="text">
                                    @if (in_array($course->id, $unreadCourseIds))
                                        <span class="texticon type-new">未読</span>
                                    @endif
                                    {{ $course->title }}
                                </span>
                                <span class="label-icon">
                                    @if (Auth::user()->role == 'admin' && $course->post_status != 'publish')
                                        <span class="texticon type-notice">非公開</span>
                                    @endif
                                    @if (key_exists($course->id, $completedCourseIds))
                                        @if($completedCourseIds[$course->id])
                                            <span class="texticon type-notice">完了</span>
                                        @else
                                            <span class="texticon type-not-yet">未完了</span>
                                        @endif
                                    @endif
                                    <span class="material-symbols-outlined">
                                        chevron_right
                                    </span>
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        @endif
    </div>
@endsection
