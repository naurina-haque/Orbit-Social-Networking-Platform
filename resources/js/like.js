document.addEventListener('DOMContentLoaded', function () {
    const likeButtons = document.querySelectorAll('.like-btn');

    likeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const url = button.dataset.likeUrl;
            const postId = button.dataset.postId;

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
                    if (data.liked) {
                        button.classList.add('hp-liked');
                        textSpan.textContent = 'Liked';
                    } else {
                        button.classList.remove('hp-liked');
                        textSpan.textContent = 'Like';
                    }

                    //update count
                    const countSpan = document.querySelector(`.like-count[data-post-id="${postId}"]`);
                    if (countSpan) {
                        countSpan.textContent = data.count;
                    }
                })
                .catch(error => console.error('Like error:', error));
        });
    });
});