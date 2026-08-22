// public/modules/admin/js/sidebar.js
function toggleNavGroup(menuId, buttonElement) {
    const menu = document.getElementById(menuId);
    const icon = buttonElement.querySelector('.iconify:last-child');
    
    if (menu.classList.contains('grid-rows-[0fr]')) {
        menu.classList.remove('grid-rows-[0fr]', 'opacity-0');
        menu.classList.add('grid-rows-[1fr]', 'opacity-100');
        icon.classList.add('rotate-180');
    } else {
        menu.classList.remove('grid-rows-[1fr]', 'opacity-100');
        menu.classList.add('grid-rows-[0fr]', 'opacity-0');
        icon.classList.remove('rotate-180');
    }
}
