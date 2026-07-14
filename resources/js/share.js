document.addEventListener('DOMContentLoaded', function () {
    const shareButtons = document.querySelectorAll('.share-btn');

    shareButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const url = button.dataset.shareUrl;
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
                    // Button-কে "Shared" state এ নিয়ে যাও, disable করে দাও
                    button.classList.add('hp-liked');
                    button.querySelector('.share-text').textContent = 'Shared';
                    button.disabled = true;

                    // Count আপডেট করো
                    const countSpan = document.querySelector(`.share-count[data-post-id="${postId}"]`);
                    if (countSpan) {
                        countSpan.textContent = data.count;
                    }
                })
                .catch(error => console.error('Share error:', error));
        });
    });
});