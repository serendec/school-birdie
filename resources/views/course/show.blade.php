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
                                    @can('isStudent')
                                        <form action="{{ route('course.update_progress') }}" method="POST" id="form-done">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $course->id }}">
                                            @if ($isCompleted == 1)
                                                <input type="hidden" name="is_completed" value="0">
                                                <button class="button button-secondary" id="button-done" type="submit">
                                                    <span class="text">完了取消</span>
                                                </button>
                                            @else
                                                <input type="hidden" name="is_completed" value="1">
                                                <button class="button button-secondary" id="button-done" type="submit">
                                                    <span class="text">完了</span>
                                                </button>
                                            @endif
                                        </form>
                                    @elsecan('isTeacher')
                                        <a href="{{ route('course.edit', $course->id) }}" class="button button-secondary">
                                            <span class="text">編集</span>
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>

                        @if (!empty($course->video))
                            <div class="movie pt-0">
                                <video id="video-player" controls></video>
                            </div>
                        @endif

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
        <script src="{{ asset('js/hls.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // HLS読み込み
                const videoSrc = "{{ asset('storage/media/course/' . Auth::user()->school_id . '/' . $course->id . '/' . $course->video . '.m3u8') }}";
                initHls(videoSrc);
            });
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
