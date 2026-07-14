document.addEventListener('DOMContentLoaded', function () {
    const commentInputs = document.querySelectorAll('.comment-input-field');

    commentInputs.forEach(function (input) {
        input.addEventListener('keypress', function (e) {
            if (e.key === 'Enter' && input.value.trim() !== '') {
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
                    .then(response => response.json())
                    .then(data => {
                        // add new comment to list 
                        const commentsList = document.getElementById(`comments-${postId}`);
                        const newComment = document.createElement('div');
                        newComment.className = 'comment-item';
                        newComment.innerHTML = `
                            <span class="hp-avatar-ring xs"><img src="https://i.pravatar.cc/80?img=12" alt=""></span>
                            <div class="comment-bubble">
                                <div class="comment-author">${data.user_name}</div>
                                <div class="comment-text">${data.content}</div>
                            </div>
                        `;
                        commentsList.appendChild(newComment);

                        // update Count
                        const countSpan = document.querySelector(`.comment-count[data-post-id="${postId}"]`);
                        if (countSpan) {
                            countSpan.textContent = data.count;
                        }

                        input.value = '';
                    })
                    .catch(error => console.error('Comment error:', error));
            }
        });
    });
});