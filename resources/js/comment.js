document.addEventListener('DOMContentLoaded', function () {
    const commentInputs = document.querySelectorAll('.comment-input-field');

    commentInputs.forEach(function (input) {
        input.addEventListener('keypress', function (e) {
            if (e.key === 'Enter' && input.value.trim() !== '') {
                submitComment(input);
            }
        });
    });

    document.querySelectorAll('.comment-send-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const postId = btn.dataset.postId;
            const input = document.querySelector(`.comment-input-field[data-post-id="${postId}"]`);
            if (input && input.value.trim() !== '') {
                submitComment(input);
            }
        });
    });

    document.querySelectorAll('.comment-delete-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const commentId = btn.dataset.commentId;
            const postId = btn.dataset.postId;
            const url = btn.dataset.deleteUrl;

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
                .then(function (response) { return response.json(); })
                .then(function (data) {
                    if (data.deleted) {
                        const commentEl = document.querySelector(`.comment-item[data-comment-id="${commentId}"]`);
                        if (commentEl) {
                            commentEl.remove();
                        }

                        const countSpan = document.querySelector(`.comment-count[data-post-id="${postId}"]`);
                        if (countSpan) {
                            countSpan.textContent = data.count;
                        }
                    }
                })
                .catch(function (error) { console.error('Delete comment error:', error); });
        });
    });

    function submitComment(input) {
        const url = input.dataset.commentUrl;
        const postId = input.dataset.postId;
        const content = input.value.trim();

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: JSON.stringify({ content: content }),
        })
            .then(function (response) { return response.json(); })
            .then(function (data) {
                if (!data || !data.id) {
                    console.error('Comment response missing id', data);
                    return;
                }

                const commentsList = document.getElementById('comments-' + postId);
                if (!commentsList) return;

                const newComment = document.createElement('div');
                newComment.className = 'comment-item';
                newComment.dataset.commentId = data.id;

                var avatarSrc = '';
                if (input.closest('.hp-comment-row')) {
                    var avatarImg = input.closest('.hp-comment-row').querySelector('.hp-avatar-ring img');
                    if (avatarImg) {
                        avatarSrc = avatarImg.getAttribute('src') || '';
                    }
                }

                newComment.innerHTML = `
                    <span class="hp-avatar-ring xs"><img src="${avatarSrc}" alt=""></span>
                    <div class="comment-bubble">
                        <div class="comment-header">
                            <div class="comment-author">${escapeHtml(data.user_name || '')}</div>
                            <button type="button" class="comment-delete-btn" data-delete-url="/comments/${data.id}" data-comment-id="${data.id}" data-post-id="${postId}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/>
                                </svg>
                            </button>
                        </div>
                        <div class="comment-text">${escapeHtml(data.content || '')}</div>
                    </div>
                `;

                var deleteBtn = newComment.querySelector('.comment-delete-btn');
                if (deleteBtn) {
                    deleteBtn.addEventListener('click', function () {
                        var commentId = deleteBtn.dataset.commentId;
                        var url = deleteBtn.dataset.deleteUrl;
                        var postIdForCount = deleteBtn.dataset.postId;

                        fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                            },
                        })
                            .then(function (response) { return response.json(); })
                            .then(function (data) {
                                if (data.deleted) {
                                    newComment.remove();
                                    var countSpan = document.querySelector('.comment-count[data-post-id="' + postIdForCount + '"]');
                                    if (countSpan) {
                                        countSpan.textContent = data.count;
                                    }
                                }
                            })
                            .catch(function (error) { console.error('Delete comment error:', error); });
                    });
                }

                commentsList.appendChild(newComment);

                var countSpan = document.querySelector('.comment-count[data-post-id="' + postId + '"]');
                if (countSpan) {
                    countSpan.textContent = data.count;
                }

                input.value = '';
            })
            .catch(function (error) { console.error('Comment error:', error); });
    }

    function escapeHtml(text) {
        if (text == null) return '';
        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
});
