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
                                        <span class="text size-mini">{{ $forum->created_at->format('Y/m/d') }}</span>
                                        <span class="namebox">
                                            @include('partials.icon', ['icon' => $forum->user->icon, 'size' => 'mini'])
                                            <span>
                                                <span class="text size-mini">
                                                    @if (Auth::user()->role == 'student')
                                                        {{ ($forum->user->role == 'student' && $forum->user->id != Auth::user()->id) ? $forum->user->nickname : $forum->user->family_name.' '.$forum->user->first_name }}
                                                    @else
                                                        {{ $forum->user->role == 'student' ? $forum->user->nickname.' ('.$forum->user->family_name.' '.$forum->user->first_name.')' : $forum->user->family_name.' '.$forum->user->first_name }}
                                                    @endif
                                                </span>
                                            </span>
                                        </span>        
                                    </span>
                                    <span class="card-name">
                                        <span class="namebox">
                                            <span>
                                                <h1 class="text size-default block">
                                                    {{ $forum->title }}
                                                </h1>
                                            </span>
                                        </span>
                                    </span>
                                    <span class="tagbox">
                                        @foreach ($forum->tags as $tag)
                                            <span class="tag">{{ $tag->name }}</span>
                                        @endforeach
                                    </span>
                                </div>
                                <div class="editcase-right">
                                    @can('isAdmin')
                                        <a href="{{ route('forum.edit', $forum->id) }}" class="button button-secondary">
                                            <span class="text">編集</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text size-middle block mt-16">
                            {!! nl2br(e($forum->content)) !!}
                            @if (!empty($forum->images))
                                <p>
                                    @foreach ($forum->imagePaths as $imagePath)
                                        <img src="{{ asset($imagePath) }}" class="wfull" alt="トピック画像">
                                    @endforeach
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <hr />

            <div class="edit-footer" id="reply-0">
                <div class="edit-footer-left">
                    <button class="button button-secondary reply-button" data-comment-id="0" data-parent-comment-id="0" data-user-id="{{ $forum->user_id }}">
                        <span class="material-symbols-outlined">
                            comment
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <h2 class="hd-2" id="comment-area-title">コメント</h2>
        @if ($forum->comments->isNotEmpty())
            <div id="comments">
                @foreach ($forum->comments as $comment)
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
            <input type="hidden" name="forum_id" value="{{ $forum->id }}">
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
    <script src="{{ asset('js/forum.js?v=') . filemtime(public_path('js/forum.js')) }}"></script>
    <script src="{{ asset('js/comment.js?v=') . filemtime(public_path('js/comment.js')) }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // コメント機能
            const category = 'forum';
            const createRoute = "{{ route('forum.comment.create') }}";
            const deleteRoute = "{{ route('forum.comment.delete') }}";
            initCommentSystem(createRoute, deleteRoute, category);
        });
    </script>
@endsection
