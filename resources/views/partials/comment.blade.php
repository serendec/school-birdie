<div class="detail-content">
    <div class="detail-content-body">
        <div class="detail-content-body-item">
            <div class="post-header">
                <div class="editcase">
                    <div class="editcase-left">
                        @if (isset($unread) && $unread === true)
                            <span class="texticon type-new">未読</span>
                        @endif
                        <span class="namebox">
                            @include('partials.icon', ['icon' => $comment->user->icon, 'size' => 'middle'])
                            <span>
                                <span class="text size-middle">
                                    @if (Auth::user()->role == 'student')
                                        {{ ($comment->user->role == 'student' && $comment->user->id != Auth::user()->id) ? $comment->user->nickname : $comment->user->family_name.' '.$comment->user->first_name }}
                                    @else
                                        {{ $comment->user->role == 'student' ? $comment->user->nickname.' ('.$comment->user->family_name.' '.$comment->user->first_name.')' : $comment->user->family_name.' '.$comment->user->first_name }}
                                    @endif
                                </span>
                            </span>
                        </span>
                    </div>
                    <div class="editcase-right">
                        <span class="text size-mini">{{ $comment->created_at->format('Y/m/d H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="textcontent">
    <p>
        @if (!empty($comment->mentionedUser->family_name))
            @if (Auth::user()->role == 'student')
                @ {{ ($comment->mentionedUser->role == 'student' && $comment->mentionedUser->id != Auth::user()->id) ? $comment->mentionedUser->nickname : $comment->mentionedUser->family_name.' '.$comment->mentionedUser->first_name }}
            @else
                @ {{ $comment->mentionedUser->role == 'student' ? $comment->mentionedUser->nickname.' ('.$comment->mentionedUser->family_name.' '.$comment->mentionedUser->first_name.')' : $comment->mentionedUser->family_name.' '.$comment->mentionedUser->first_name }}
            @endif
        @endif
        {{ $comment->body }}
    </p>
</div>
<div class="edit-footer" id="reply-{{ $comment->id }}">
    <div class="edit-footer-left">
        @if (isset($likedCommentIds))
            <button class="button like-button {{ $likedCommentIds->contains($comment->id) ? '' : 'button-secondary' }}" aria-label="いいね" data-comment-id="{{ $comment->id }}" data-liked="{{ $likedCommentIds->contains($comment->id) ? 'true' : 'false' }}">
                <span class="material-symbols-outlined">
                    thumb_up
                </span>
                <span class="text size-middle like-count">{{ $comment->likes_count > 0 ? $comment->likes_count : '' }}</span>
            </button>
        @endif

        @if (!isset($can_reply) || $can_reply === true)
            <button class="button button-secondary reply-button" data-comment-id="{{ $comment->id }}"
                data-parent-comment-id="{{ $parent_comment_id }}" data-user-id="{{ $comment->user_id }}">
                <span class="material-symbols-outlined">
                    comment
                </span>
            </button>
        @endif
    </div>

    @if (Auth::user()->role == 'admin' && (!isset($can_reply) || $can_reply === true))
        <div class="edit-footer-right">
            <button class="button button-thirdly type-alert delete-button" data-comment-id="{{ $comment->id }}" data-parent-comment-id="{{ $parent_comment_id }}">
                <span class="material-symbols-outlined">
                    delete
                </span>
                <span class="text size-small">削除</span>
            </button>
        </div>
    @endif
</div>
