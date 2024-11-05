function initCommentSystem(createRoute, deleteRoute, category) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const replyButtons = document.querySelectorAll('.reply-button');
    const deleteButtons = document.querySelectorAll('.delete-button');
    const likeButtons = document.querySelectorAll('.like-button');
    const commentFormContainer = document.getElementById('comment-form-container');
    const commentForm = document.getElementById('comment-form');
    const commentBody = document.getElementById('body');
    const parentCommentIdInput = document.getElementById('parent_comment_id');
    const mentionedUserIdInput = document.getElementById('mentioned_user_id');
    const cancelReplyButton = document.getElementById('cancel-reply');

    // コメント欄非表示 & 初期化
    function hideAndResetForm () {
        commentFormContainer.style.display = 'none';
        parentCommentIdInput.value = '';
        mentionedUserIdInput.value = '';
        commentBody.value = '';
    }

    // コメント欄表示制御
    replyButtons.forEach(function(button) {
        addCommentButtonEvent(button);
    });
    function addCommentButtonEvent (button) {
        button.addEventListener('click', function() {
            parentCommentIdInput.value = button.getAttribute('data-parent-comment-id');
            mentionedUserIdInput.value = button.getAttribute('data-user-id');
            commentBody.value = '';

            const commentId = button.getAttribute('data-comment-id');
            document.getElementById('reply-' + commentId).appendChild(commentFormContainer);
            commentFormContainer.style.display = 'block';
        });
    }

    // キャンセルボタン制御
    cancelReplyButton.addEventListener('click', function() {
        hideAndResetForm();
    });

    // コメント投稿
    commentForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(commentForm);
        if (formData.get('parent_comment_id') == '0'){
            formData.delete('parent_comment_id');
        }
        fetch(createRoute, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.message) {
                    // コメントの挿入
                    let newComment;
                    if (formData.get('parent_comment_id') == null) {
                        // コメントがない投稿を削除
                        const noCommentMsg = document.getElementById('no-comment-msg');
                        if (noCommentMsg != null){
                            noCommentMsg.remove();
                        }

                        newComment = createCommentElement('parent', data.comment, data.user);
                        const comments = document.getElementById('comments');
                        comments.insertAdjacentElement('afterbegin', newComment);
                    } else {
                        newComment = createCommentElement('child', data.comment, data.user);
                        const card = document.getElementById('card-' + data.comment.parent_comment_id);
                        card.appendChild(newComment);
                    }

                    // コメントボタンにイベントを付与
                    const newReplyButton = newComment.querySelector('.reply-button');
                    addCommentButtonEvent(newReplyButton);

                    if (category != false){
                        // いいねボタンにイベントを付与
                        const newLikeButton = newComment.querySelector('.like-button');
                        likeComment(newLikeButton);
                    }

                    if (data.user.role != 'student'){
                        // コメント削除ボタンにイベントを付与
                        const newDeleteButton = newComment.querySelector('.delete-button');
                        deleteComment(newDeleteButton);
                    }

                    // コメント数の更新
                    const commentCreatedEvent = new CustomEvent('commentCreated');
                    document.dispatchEvent(commentCreatedEvent);

                    // 当該コメントにスクロール
                    newComment.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });

                    hideAndResetForm();
                }
            })
            .catch(error => {
                alert('コメントを投稿できませんでした。時間を置いて再度お試しください。'+ error);
            });
    });

    // コメント削除
    deleteButtons.forEach(function(button) {
        deleteComment(button);
    });

    function deleteComment(button) {
        button.addEventListener('click', function() {
            if (!window.confirm('コメントを削除しますか？')){
                return;
            }

            const commentId = button.getAttribute('data-comment-id');
            const parentCommentId = button.getAttribute('data-parent-comment-id');
            const formData = new FormData();
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            formData.append('comment_id', commentId);

            fetch(deleteRoute, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.message) {
                        if (commentId == parentCommentId){
                            document.getElementById('card-' + commentId).remove();
                        } else {
                            document.getElementById('reply-container-' + commentId).remove();
                        }

                        // コメント数の更新
                        const commentDeletedEvent = new CustomEvent('commentDeleted');
                        document.dispatchEvent(commentDeletedEvent);

                    } else {
                        throw new Error("削除できませんでした。");
                    }
                })
                .catch(error => {
                    alert('コメントを削除できませんでした。時間を置いて再度お試しください。');
                });
        });
    }

    // いいねボタン
    likeButtons.forEach(function(button) {
        likeComment(button);
    });
    function likeComment(button) {
        button.addEventListener('click', function() {
            const commentId = this.dataset.commentId;
            const liked = this.dataset.liked === 'true';

            // Send a request to toggle the like status
            fetch(`/${category}/comment/${commentId}/toggle-like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Toggle the like status
                    this.dataset.liked = !liked;

                    // Update the button label and icon
                    const icon = this.querySelector('.material-symbols-outlined');
                    const likeCountSpan = icon.nextElementSibling;
                    const currentCount = (likeCountSpan.textContent != '') ? parseInt(likeCountSpan.textContent) : 0;

                    if (!liked) {
                        button.classList.remove('button-secondary');
                        button.classList.add('button-like');
                        likeCountSpan.textContent = currentCount + 1;
                    } else {
                        button.classList.remove('button-like');
                        button.classList.add('button-secondary');
                        likeCountSpan.textContent = ((currentCount - 1) > 0) ? currentCount - 1 : '';
                    }
                }
            });
        });
    }

    function createCommentElement(domRelationship, comment, user) {
        const parentCommentId = (comment.parent_comment_id != null) ? comment.parent_comment_id : comment.id;

        const detailDiv = document.createElement('div');
        if (domRelationship == 'parent'){
            detailDiv.classList.add('detail');
            detailDiv.setAttribute('id', 'card-' + comment.id);
        } else {
            detailDiv.classList.add('detail', 'reply');
            detailDiv.setAttribute('id', 'reply-container-' + comment.id);
        }

        const detailContent = document.createElement('div');
        detailContent.classList.add('detail-content');
        const detailContentBody = document.createElement('div');
        detailContentBody.classList.add('detail-content-body');
        const detailContentBodyItem = document.createElement('div');
        detailContentBodyItem.classList.add('detail-content-body-item');

        const postHeader = document.createElement('div');
        postHeader.classList.add('post-header');
        const editcase = document.createElement('div');
        editcase.classList.add('editcase');

        const editcaseLeft = document.createElement('div');
        editcaseLeft.classList.add('editcase-left');
        const namebox = document.createElement('span');
        namebox.classList.add('namebox');
        const icon = document.createElement('span');
        icon.classList.add('avator', 'size-middle');
        icon.style.backgroundImage = `url(${user.icon})`;
        namebox.appendChild(icon);
        const nameWrapper = document.createElement('span');
        const name = document.createElement('span');
        name.classList.add('text', 'size-middle');
        name.textContent = `${user.commentUserName}`;
        nameWrapper.appendChild(name);
        namebox.appendChild(nameWrapper);
        editcaseLeft.appendChild(namebox);

        const editcaseRight = document.createElement('div');
        editcaseRight.classList.add('editcase-right');
        const time = document.createElement('span');
        time.classList.add('text', 'size-mini');
        time.textContent = formatDate(comment.created_at);
        editcaseRight.appendChild(time);
        editcase.appendChild(editcaseLeft);
        editcase.appendChild(editcaseRight);

        postHeader.appendChild(editcase);
        detailContentBodyItem.appendChild(postHeader);
        detailContentBody.appendChild(detailContentBodyItem);
        detailContent.appendChild(detailContentBody);
        detailDiv.appendChild(detailContent);

        const commentContent = document.createElement('div');
        commentContent.classList.add('textcontent');
        const p = document.createElement('p');
        p.textContent = (user.mentionedUserName != null) ? `@ ${user.mentionedUserName}　${comment.body}` : comment.body;
        commentContent.appendChild(p);
        detailDiv.appendChild(commentContent);

        const editFooter = document.createElement('div');
        editFooter.classList.add('edit-footer');
        editFooter.id = `reply-${comment.id}`;
        const editFooterLeft = document.createElement('div');
        editFooterLeft.classList.add('edit-footer-left');

        if (category != false){
            const likeButton = document.createElement('button');
            likeButton.classList.add('button', 'like-button', 'button-secondary');
            likeButton.setAttribute('aria-label', 'いいね');
            likeButton.setAttribute('data-comment-id', comment.id);
            likeButton.setAttribute('data-liked', 'false');
            const materialSymbolsOutlined = document.createElement('span');
            materialSymbolsOutlined.classList.add('material-symbols-outlined');
            materialSymbolsOutlined.textContent = 'thumb_up';
            likeButton.appendChild(materialSymbolsOutlined);
            const likeCount = document.createElement('span');
            likeCount.classList.add('text', 'size-middle', 'like-count');
            likeButton.appendChild(likeCount);
            editFooterLeft.appendChild(likeButton);
        }

        const replyButton = document.createElement('button');
        replyButton.classList.add('button', 'button-secondary', 'reply-button');
        replyButton.setAttribute('data-comment-id', comment.id);
        replyButton.setAttribute('data-parent-comment-id', parentCommentId);
        replyButton.setAttribute('data-user-id', comment.user_id);
        const materialSymbolsOutlined2 = document.createElement('span');
        materialSymbolsOutlined2.classList.add('material-symbols-outlined');
        materialSymbolsOutlined2.textContent = 'comment';
        replyButton.appendChild(materialSymbolsOutlined2);
        editFooterLeft.appendChild(replyButton);
        editFooter.appendChild(editFooterLeft);

        if (user.role != 'student'){
            const editFooterRight = document.createElement('div');
            editFooterRight.classList.add('edit-footer-right');
            const deleteButton = document.createElement('button');
            deleteButton.classList.add('button', 'button-thirdly', 'type-alert', 'delete-button');
            deleteButton.setAttribute('data-comment-id', comment.id);
            deleteButton.setAttribute('data-parent-comment-id', parentCommentId);
            const materialSymbolsOutlined3 = document.createElement('span');
            materialSymbolsOutlined3.classList.add('material-symbols-outlined');
            materialSymbolsOutlined3.textContent = 'delete';
            deleteButton.appendChild(materialSymbolsOutlined3);
            const text = document.createElement('span');
            text.classList.add('text', 'size-small');
            text.textContent = '削除';
            deleteButton.appendChild(text);
            editFooterRight.appendChild(deleteButton);
            editFooter.appendChild(editFooterRight);
        }

        detailDiv.appendChild(editFooter);

        return detailDiv;
    }
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');

    return `${year}/${month}/${day} ${hours}:${minutes}`;
}

// コメント数の更新（フォーラム用）
document.addEventListener('commentCreated', function () {
    const commentCountElement = document.querySelector('.comment-count');
    if (commentCountElement) {
        const currentCommentCount = (commentCountElement.textContent != '') ? parseInt(commentCountElement.textContent) : 0;
        commentCountElement.textContent = currentCommentCount + 1;
    }
});
document.addEventListener('commentDeleted', function () {
    const commentCountElement = document.querySelector('.comment-count');
    if (commentCountElement) {
        const currentCommentCount = (commentCountElement.textContent != '') ? parseInt(commentCountElement.textContent) : 0;
        commentCountElement.textContent = currentCommentCount - 1;
    }
});
