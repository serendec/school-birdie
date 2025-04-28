@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper" id="site-body-wrapper">
        @if ($course->post_status == 'draft')
            <span class="texticon type-notice">非公開</span>
        @endif

        <div class="detail">
            <div class="detail-content">
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="post-header">
                            <div class="editcase">
                                <div class="editcase-left">
                                    <span class="card-header">
                                        @if ($course->read == 1)
                                            <span class="texticon type-notice">完了</span>
                                        @endif
                                    </span>
                                    <div class="card-name">
                                        <div class="namebox">
                                            <div>
                                                <h1 class="text size-default weight-normal">
                                                    {{ $course->category->name }} / {{ $course->title }}
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="editcase-right">
                                    @can('isTeacher')
                                        <a href="{{ route('course.edit', $course->id) }}" class="button button-secondary">
                                            <span class="text">編集</span>
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>

                        @if (!empty($course->video))
                            <div class="movie pt-0">
                                <video id="video-player"></video>
                                <div id="video-controls">
                                    <button class="play-button" id="playBtn">▶</button>
                                    <button class="stop-button" id="stopBtn">■</button>

                                    <div class="speed-control" id="speed_control">
                                        <label for="speedControl">倍速: </label>
                                        <select id="speedControl">
                                            <option value="0.5">0.5x</option>
                                            <option value="1.0" selected>1x</option>
                                            <option value="1.5">1.5x</option>
                                            <option value="2.0">2x</option>
                                            <option value="3.0">3x</option>
                                            <option value="4.0">4x</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @can('isStudent')
                            <div class="listbuttons">
                                <div class="element left">
                                    @if($previousCourseId)
                                    <a href="{{ route('course.show', $previousCourseId) }}" class="button button-secondary button-previous"><span class="text">前の講座</span></a>
                                    @endif
                                </div>
                                <div class="btn-complete element">
                                    <form action="{{ route('course.update_progress') }}" method="POST" id="form-done">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $course->id }}">
                                        @if ($isCompleted == 1)
                                            <input type="hidden" name="is_completed" value="0">
                                            <button class="button button-secondary" id="button-done" type="submit">
                                                <span class="text">完了</span>
                                            </button>
                                        @else
                                            <input type="hidden" name="is_completed" value="1">
                                            <button class="button button-secondary" id="button-done" type="submit">
                                                <span class="text">未完了</span>
                                            </button>
                                        @endif
                                    </form>
                                </div>
                                <div class="element right">
                                    @if($nextCourseId)
                                    <a href="{{ route('course.show', $nextCourseId) }}" class="button button-secondary button-next"><span class="text">次の講座</span></a>
                                    @endif
                                </div>
                            </div>
                        @endcan

                        <div class="text size-middle block mt-16">
                            {!! Purify::clean($course->content) !!}
                        </div>
                    </div>
                </div>
            </div>

            <hr />

            <div class="edit-footer" id="reply-0">
                <div class="edit-footer-left">
                    <button class="button button-secondary reply-button" data-comment-id="0" data-parent-comment-id="0" data-user-id="">
                        <span class="material-symbols-outlined">
                            comment
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <h2 class="hd-2" id="comment-area-title">コメント</h2>
        @if ($course->comments->isNotEmpty())
            <div id="comments">
                @foreach ($course->comments as $comment)
                    @php
                        if ($comment->parent_comment_id != null) {
                            continue;
                        }
                    @endphp
                    <div class="detail" id="card-{{ $comment->id }}">
                        @include('partials.comment', [
                            'comment'           => $comment,
                            'parent_comment_id' => $comment->id,
                            'can_reply'         => true,
                            'unread'            => in_array($comment->id, $unreadCommentIds)
                        ])

                        @if ($comment->children->count() > 0)
                            @foreach ($comment->children as $child)
                                <div class="detail reply" id="reply-container-{{ $child->id }}">
                                    @include('partials.comment', [
                                        'comment'           => $child,
                                        'parent_comment_id' => $comment->id,
                                        'can_reply'         => true,
                                        'unread'            => in_array($child->id, $unreadCommentIds)
                                    ])
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty" id="no-comment-msg">コメントはまだありません。</div>
            <div id="comments"></div>
        @endif
    </div>

    <div class="comment-input" id="comment-form-container" style="display:none;">
        <form id="comment-form">
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <input type="hidden" name="parent_comment_id" id="parent_comment_id" value="">
            <input type="hidden" name="mentioned_user_id" id="mentioned_user_id" value="">
            <div class="comment-input-textarea">
                <label for="body" class="text size-mini block">コメント</label>
                <textarea name="body" id="body" cols="30" rows="10"></textarea>
            </div>
            <div class="edit-footer">
                <div class="edit-footer-left">
                    <button class="button button-primary">
                        <span class="text">投稿</span>
                    </button>
                    <span id="cancel-reply" class="button button-secondary">
                        <span class="text">キャンセル</span>
                    </span>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('js-footer')
    @if (!empty($course->video))
        <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // HLS読み込み
                const videoSrc = "{{ asset('storage/media/course/' . Auth::user()->school_id . '/' . $course->id . '/' . $course->video . '.m3u8') }}";
                initHls(videoSrc);
            });

            function initHls(videoSrc) {
                const video = document.getElementById("video-player");
                const videoControls = document.getElementById("video-controls");
                const playBtn = document.getElementById("playBtn");
                const stopBtn = document.getElementById("stopBtn");
                const speedControl = document.getElementById('speedControl');

                videoControls.classList.add('show');
                playBtn.classList.add('show');

                playBtn.addEventListener("click", () => {
                    video.play();
                    playBtn.classList.remove('show');
                    stopBtn.classList.add('show');

                    @can('isStudent')
                        $.ajax({
                            url: '{{ route('course.update_progress') }}',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: '{{ $course->id }}',
                                type: 'start_play',
                            },
                            success: function(response) {
                                console.log('Success:', response);
                            },
                            error: function(xhr, status, error) {
                                console.log('Error:', error);
                            }
                        });
                    @endcan
                });

                stopBtn.addEventListener("click", () => {
                    playBtn.classList.add('show');
                    stopBtn.classList.remove('show');
                    video.pause();
                });

                speedControl.addEventListener("change", () => {
                    const v_speed = Number(speedControl.value);
                    video.playbackRate = v_speed;
                });

                video.addEventListener("seeking", function (event) {
                    if (video.currentTime > video.played.end(0)) {
                        video.currentTime = video.played.end(0);
                    }
                });

                video.addEventListener('mouseenter', () => {
                    if (!video.paused) {
                        videoControls.classList.add('show');
                        stopBtn.classList.add('show');
                    }
                });

                stopBtn.addEventListener('mouseenter', () => {
                    if (!video.paused) {
                        stopBtn.classList.add('show');
                    }
                });

                video.addEventListener('mouseleave', () => {
                    stopBtn.classList.remove('show');
                    if (!video.paused) {
                        videoControls.classList.remove('show');
                    }

                });

                video.addEventListener("ended", function (event) {
                    playBtn.classList.add('show');
                    stopBtn.classList.remove('show');

                    @can('isStudent')
                        $.ajax({
                            url: '{{ route('course.update_progress') }}',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: '{{ $course->id }}',
                                type: 'finish_play',
                            },
                            success: function(response) {
                                console.log('Success:', response);
                            },
                            error: function(xhr, status, error) {
                                console.log('Error:', error);
                            }
                        });
                    @endcan
                });

                video.addEventListener("contextmenu", (event) => event.preventDefault());

                if (Hls.isSupported()) {
                    const hls = new Hls();
                    hls.loadSource(videoSrc);
                    hls.attachMedia(video);
                } else if (video.canPlayType("application/vnd.apple.mpegurl")) {
                    video.src = videoSrc;
                } else {
                    alert("動画再生に対応していないブラウザです。\nお手数でございますが、別のブラウザをご利用ください。");
                }
            }

        </script>
    @endif

    <script src="{{ asset('js/comment.js?v=') . filemtime(public_path('js/comment.js')) }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // コメント機能
            const category = 'course';
            const createRoute = "{{ route('course.comment.create') }}";
            const deleteRoute = "{{ route('course.comment.delete') }}";
            initCommentSystem(createRoute, deleteRoute, category);
        });
    </script>
@endsection
