@extends('layouts.app')

@section('content')
    <div class="site-body-wrapper" id="site-body-wrapper">
        <div class="detail">
            <div class="detail-content">
                <div class="detail-content-body">
                    <div class="detail-content-body-item">
                        <div class="post-header">
                            <div class="editcase">
                                <div class="editcase-left">
                                    <span class="card-header">
                                        <span class="text size-mini">{{ $videoAdvice->created_at->format('Y/m/d') }}</span>
                                        @if ($videoAdvice->status == 'open')
                                            <span class="texticon type-notice">未了</span>
                                        @else
                                            <span class="texticon type-done">終了</span>
                                        @endif
                                    </span>
                                    <div class="card-name">
                                        <div class="namebox">
                                            <div>
                                                <h1 class="text size-default block ma-0">
                                                    {{ $videoAdvice->title }}
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="editcase-right">
                                    @if ($videoAdvice->status == 'open')
                                        @can('isTeacher')
                                            <form action="{{ route('video_advice.change_status') }}" method="POST" id="form-done">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $videoAdvice->id }}">
                                                <input type="hidden" name="status" value="closed">
                                                <button class="button button-secondary" id="button-done" type="button">
                                                    <span class="text">対応終了</span>
                                                </button>
                                            </form>
                                        @elsecan('isStudent')
                                            <a href="{{ route('video_advice.edit', $videoAdvice->id) }}" class="button button-secondary">
                                                <span class="text">編集</span>
                                            </a>
                                        @endcan
                                    @endif
                                </div>
                            </div>

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

                            <div class="movie pt-0">
                                @foreach ($videos as $index => $video)
                                    <div class="video-container">
                                        <video id="video-player-{{ $index + 1 }}" controls style="display: none;"></video>
                                        @can('isStudent')
                                            <button class="favorite-btn" data-video="{{ $video }}" data-video_category="video_advice" data-video_category_id="{{ $videoAdvice->id }}">
                                                <i class="fa fa-heart {{ in_array($video, $favorites) ? 'favorited' : '' }}"></i>
                                            </button>
                                        @endcan
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="text size-middle block mt-16">
                            {!! nl2br(e($videoAdvice->question)) !!}
                        </div>
                    </div>
                </div>
            </div>

            @if ($videoAdvice->status == 'open')
                <hr />

                <div class="edit-footer" id="reply-0">
                    <div class="edit-footer-left">
                        <button class="button button-secondary reply-button" data-comment-id="0" data-parent-comment-id="0" data-user-id="{{ Auth::user()->role == 'student' ? $mainTeacher->id : $videoAdvice->student_id }}">
                            <span class="material-symbols-outlined">
                                comment
                            </span>
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <h2 class="hd-2" id="comment-area-title">コメント</h2>
        @if ($videoAdvice->comments->isNotEmpty())
            <div id="comments">
                @foreach ($videoAdvice->comments as $comment)
                    @php
                        if ($comment->parent_comment_id != null) {
                            continue;
                        }
                    @endphp
                    <div class="detail" id="card-{{ $comment->id }}">
                        @include('partials.comment', [
                            'comment'           => $comment,
                            'parent_comment_id' => $comment->id,
                            'can_reply'         => $videoAdvice->status == 'open',
                            'unread'            => in_array($comment->id, $unreadCommentIds)
                        ])

                        @if ($comment->children->count() > 0)
                            @foreach ($comment->children as $child)
                                <div class="detail reply" id="reply-container-{{ $child->id }}">
                                    @include('partials.comment', [
                                        'comment'           => $child,
                                        'parent_comment_id' => $comment->id,
                                        'can_reply'         => $videoAdvice->status == 'open',
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
            <input type="hidden" name="video_advice_id" value="{{ $videoAdvice->id }}">
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
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script src="{{ asset('js/comment.js') }}"></script>
    <script src="{{ asset('js/hls.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // HLS読み込み
            const videoSources = [
                @foreach ($videos as $video)
                    "{{ $video ? asset('storage/media/video_advice/' . Auth::user()->school_id . '/' . $videoAdvice->id . '/' . $video . '.m3u8') : '' }}",
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

            @if ($videoAdvice->status == 'open')
                // コメント機能
                const createRoute = "{{ route('video_advice.comment.create') }}";
                const deleteRoute = "{{ route('video_advice.comment.delete') }}";
                initCommentSystem(createRoute, deleteRoute, false);

                @if (Auth::user()->role != 'student')
                    // 対応終了ボタン押下時の処理
                    const button = document.getElementById('button-done');
                    button.addEventListener('click', function() {
                        if (window.confirm('本動画添削の対応ステータスを終了に変更しますか？')) {
                            const form = document.getElementById('form-done');
                            form.submit();
                        } else {
                            return false;
                        }
                    });
                @endif
            @endif
        });
    </script>
@endsection
