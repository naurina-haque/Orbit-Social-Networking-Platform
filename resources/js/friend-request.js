document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Send friend request
    document.querySelectorAll('.add-friend-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const url = button.dataset.sendUrl;
            const userId = button.dataset.userId;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.sent) {
                        const suggestBox = document.getElementById(`suggest-${userId}`);
                        if (suggestBox) suggestBox.remove();
                    }
                })
                .catch(error => console.error('Friend request error:', error));
        });
    });

    // Accept friend request
    document.querySelectorAll('.accept-req-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const url = button.dataset.acceptUrl;
            const requestId = button.dataset.requestId;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    const item = document.getElementById(`request-${requestId}`);
                    if (item) item.remove();
                    updateBadgeCount(data.pending_count);
                })
                .catch(error => console.error('Accept error:', error));
        });
    });

    // Decline friend request
    document.querySelectorAll('.decline-req-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const url = button.dataset.declineUrl;
            const requestId = button.dataset.requestId;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    const item = document.getElementById(`request-${requestId}`);
                    if (item) item.remove();
                    updateBadgeCount(data.pending_count);
                })
                .catch(error => console.error('Decline error:', error));
        });
    });

    function updateBadgeCount(count) {
        const badge = document.querySelector('.hp-count-badge');
        if (badge) {
            if (count > 0) {
                badge.textContent = count;
            } else {
                badge.remove();
            }
        }
    }
});