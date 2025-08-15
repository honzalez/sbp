// Hamburger menu toggle pro mobil/tablet
document.addEventListener("DOMContentLoaded", function() {
    const hamburger = document.getElementById('hamburgerBtn');
    const menu = document.getElementById('mainMenuInline');
    if (hamburger && menu) {
        hamburger.addEventListener('click', function() {
            menu.classList.toggle('show');
        });
    }

    // Uživatel - rozbalovací menu (drop-down)
    const userMenu = document.getElementById('userProfileMenu');
    const dropdown = document.getElementById('userDropdown');
    let hideTimeout = null;

    if(userMenu && dropdown) {
        // Při najetí na uživatelské menu zobraz dropdown
        userMenu.addEventListener('mouseenter', function() {
            clearTimeout(hideTimeout);
            userMenu.classList.add('open');
        });
        userMenu.addEventListener('mouseleave', function() {
            hideTimeout = setTimeout(function() {
                userMenu.classList.remove('open');
            }, 320); // můžeš snížit/zvýšit čas podle pocitu
        });

        // Pokud uživatel rychle najede myší z avatara do dropdownu
        dropdown.addEventListener('mouseenter', function() {
            clearTimeout(hideTimeout);
            userMenu.classList.add('open');
        });
        dropdown.addEventListener('mouseleave', function() {
            hideTimeout = setTimeout(function() {
                userMenu.classList.remove('open');
            }, 320);
        });
    }
});