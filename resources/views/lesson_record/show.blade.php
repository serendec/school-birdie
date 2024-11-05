@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper">
        <div class="detail">
            <div class="detail-content">
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="post-header">
                            <div class="editcase">
                                <div class="editcase-left">
                                    <span class="card-header">
                                        <span class="text size-mini">{{ $lessonRecord->lesson_date ? str_replace('-', '/', $lessonRecord->lesson_date) : '' }}</span>
                                        @if ($lessonRecord->post_status == 'draft')
                                            <span class="texticon type-notice">下書き</span>
                                        @endif
                                    </span>
                                    <div class="card-name">
                                        <div class="namebox">
                                            <div>
                                                <h1 class="text size-default block ma-0">
                                                    {{ $lessonRecord->title ?? '無題' }}
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="editcase-right">
                                    @can('isTeacher')
                                        <a href="{{ route('lesson_record.edit', $lessonRecord->id) }}" class="button button-secondary">
                                            <span class="text">編集</span>
                                        </a>
                                    @endcan
                                </div>
                            </div>
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
                                                    <span class="text size-mini">{{ $lessonRecord->teacher->family_name }} {{ $lessonRecord->teacher->first_name }}</span>
                                                </span>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <hr />

            <div class="detail-content">
                <div class="detail-content-header">レッスン概要</div>
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="text size-middle block">
                            {!! nl2br(e($lessonRecord->summary)) !!}
                        </div>
                        @if (!empty($lessonRecord->video))
                            <div class="movie pt-0">
                                @foreach ($videos as $index => $video)
                                    <div class="video-container">
                                        <video id="video-player-{{ $index + 1 }}" controls style="display: none;"></video>
                                        @can('isStudent')
                                            <button class="favorite-btn" data-video="{{ $video }}" data-video_category="lesson_record" data-video_category_id="{{ $lessonRecord->id }}">
                                                <i class="fa fa-heart {{ in_array($video, $favorites) ? 'favorited' : '' }}"></i>
                                            </button>
                                        @endcan
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="detail-content">
                <div class="detail-content-header">生徒へのコメント</div>
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="text size-middle block">
                            {!! nl2br(e($lessonRecord->teacher_comment)) !!}
                        </div>
                    </div>
                </div>
            </div>

            @can('isTeacher')
                <hr />
                <div class="detail-content">
                    <div class="detail-content-header">内部向けメモ（生徒には表示されません）</div>
                    <div class="detail-content-body">
                        <div class="detail-content-body-item">
                            <div class="text size-middle block">
                                {!! nl2br(e($lessonRecord->school_memo)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            @can('isStudent')
                <hr />
                <div class="detail-content">
                    <div class="detail-content-header">メモ</div>
                    <div class="detail-content-body">
                        <div class="detail-content-body-item">
                            <div class="text size-middle block">
                                <form method="POST" action="{{ route('lesson_record.update_student_memo') }}">
                                    @csrf
                                    @method('PATCH')
                                    <textarea class="textarea" name="student_memo" rows="5">{{ $lessonRecord->student_memo }}</textarea>
                                    <input type="hidden" name="lesson_record_id" value="{{ $lessonRecord->id }}">
                                    <button type="submit" class="button button-primary">
                                        <span class="text">保存</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        </div>

        @include('vendor.pagination.next_prev', [
            'previous'      => $previousLessonRecord,
            'next'          => $nextLessonRecord,
            'route'         => 'lesson_record.show',
            'currentNumber' => $currentRecordNumber,
            'totalNumber'   => $totalRecordsNumber,
        ])
    </div>
@endsection

@section('js-footer')
    @if (!empty($lessonRecord->video))
        <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
        <script src="{{ asset('js/hls.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // HLS読み込み
                const videoSources = [
                    @foreach ($videos as $video)
                        "{{ $video ? asset('storage/media/lesson_record/' . Auth::user()->school_id . '/' . $lessonRecord->id . '/' . $video . '.m3u8') : '' }}",
                    @endforeach
                ];
                videoSources.forEach((source, index) => {
                    if (!source) {
                        return;
                    }

                    const video = document.getElementById(`video-player-${index + 1}`);
                    
                    if (Hls.isSupported()) {
                        const hls = new Hls();
                        hls.loadSource(source);
                        hls.attachMedia(video);
                    } else if (video.canPlayType("application/vnd.apple.mpegurl")) {
                        video.src = source;
                    } else {
                        alert("動画再生に対応していないブラウザです。\nお手数でございますが、別のブラウザをご利用ください。");
                        return;
                    }

                    video.style.display = "block";
                });                
            });
        </script>
    @endif
@endsection
