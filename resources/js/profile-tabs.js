document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.pv-tab');

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            const target = tab.dataset.tab;

            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            document.querySelectorAll('.pv-tab-content').forEach(function (content) {
                content.style.display = 'none';
            });

            const activeContent = document.getElementById(`pv-tab-${target}`);
            if (activeContent) activeContent.style.display = 'block';
        });
    });
});
