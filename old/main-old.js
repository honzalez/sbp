document.addEventListener("DOMContentLoaded", function() {
    // --- Uživatelský profil menu (hover efekt s delay) ---
    const menu = document.getElementById('userProfileMenu');
    if (menu) {
        let hideTimeout = null;
        menu.addEventListener('mouseenter', function() {
            clearTimeout(hideTimeout);
            menu.classList.add('open');
        });
        menu.addEventListener('mouseleave', function() {
            hideTimeout = setTimeout(function() {
                menu.classList.remove('open');
            }, 2000);
        });

        const dropdown = document.getElementById('userDropdown');
        if (dropdown) {
            dropdown.addEventListener('mouseenter', function() {
                clearTimeout(hideTimeout);
                menu.classList.add('open');
            });
            dropdown.addEventListener('mouseleave', function() {
                hideTimeout = setTimeout(function() {
                    menu.classList.remove('open');
                }, 2000);
            });
        }
    }

    // --- Hamburger menu toggle ---
    document.addEventListener("DOMContentLoaded", function() {
    const hamburger = document.getElementById('hamburgerBtn');
    const menu = document.querySelector('.main-menu-inline');
    if (hamburger && menu) {
        hamburger.addEventListener('click', function() {
            menu.classList.toggle('show');
        });
    }
});