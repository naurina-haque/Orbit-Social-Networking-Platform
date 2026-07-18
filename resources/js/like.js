document.addEventListener('DOMContentLoaded', function () {
    const likeButtons = document.querySelectorAll('.like-btn');

    likeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const url = button.dataset.likeUrl;
            const postId = button.dataset.postId;
            const heartActive = button.dataset.heartActive;
            const heartInactive = button.dataset.heartInactive;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    const textSpan = button.querySelector('.like-text');
                    const img = button.querySelector('.action-icon');
                    const liked = data.liked === true || data.liked === 'true' || data.liked === 1 || data.liked === '1';

                    if (liked) {
                        button.classList.add('hp-liked');
                        textSpan.textContent = 'Liked';
                        if (img && heartActive) img.src = heartActive;
                    } else {
                        button.classList.remove('hp-liked');
                        textSpan.textContent = 'Like';
                        if (img && heartInactive) img.src = heartInactive;
                    }

                    const countSpan = document.querySelector(`.like-count[data-post-id="${postId}"]`);
                    if (countSpan) {
                        countSpan.textContent = data.count;
                    }
                })
                .catch(error => console.error('Like error:', error));
        });
    });
});