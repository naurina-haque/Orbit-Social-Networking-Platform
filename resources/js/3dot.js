const menuSelector = '[data-post-menu]';
const buttonSelector = '[data-post-menu-button]';
const dropdownSelector = '[data-post-menu-dropdown]';
const openClass = 'show';

function closeMenu(menu) {
    if (!menu) {
        return;
    }

    const button = menu.querySelector(buttonSelector);
    const dropdown = menu.querySelector(dropdownSelector);

    dropdown?.classList.remove(openClass);
    button?.setAttribute('aria-expanded', 'false');
}

function closeAllMenus(exceptMenu = null) {
    document.querySelectorAll(menuSelector).forEach((menu) => {
        if (menu !== exceptMenu) {
            closeMenu(menu);
        }
    });
}

function toggleMenu(button) {
    const menu = button.closest(menuSelector);
    const dropdown = menu?.querySelector(dropdownSelector);

    if (!menu || !dropdown) {
        return;
    }

    const isOpen = dropdown.classList.contains(openClass);
    closeAllMenus(menu);

    if (isOpen) {
        closeMenu(menu);
        return;
    }

    dropdown.classList.add(openClass);
    button.setAttribute('aria-expanded', 'true');
}

document.addEventListener('click', (event) => {
    const button = event.target.closest(buttonSelector);

    if (button) {
        event.preventDefault();
        toggleMenu(button);
        return;
    }

    if (!event.target.closest(menuSelector)) {
        closeAllMenus();
    }
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        closeAllMenus();
    }
});