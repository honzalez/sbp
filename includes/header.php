<?php
// ===== HEADER (hlavička webu) =====
// Tento soubor se includuje na všech stránkách.
// Obsahuje černý horní pruh s logem, navigační menu a případně uživatelský panel.
session_start();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Sebranka Praha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ===== CSS STYLY ===== -->
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/menu.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/cards.css">
    <link rel="stylesheet" href="/css/body.css">
    <link rel="stylesheet" href="/css/responsive.css">
    <link rel="stylesheet" href="/css/sponsors.css">
</head>
<body>

<!-- ===== NAVBAR (horní pruh) ===== -->
<header class="navbar-pro">

    <!-- Logo vlevo -->
    <div class="logo-left">
        <!-- Kulaté logo – překrývá červenou linku díky z-index -->
        <a href="/index.php">
            <img src="/img/logo.png" alt="Sebranka Praha logo">
        </a>
    </div>

    <!-- Navigační menu -->
    <nav class="menu-pro">
        <!-- Hlavní menu inline -->
        <ul class="main-menu-inline" id="mainMenuInline">
            <li><a href="/index.php"<?= basename($_SERVER['PHP_SELF']) == "index.php" ? ' class="active"' : '' ?>>Novinky</a></li>
            <li><a href="/matches.php"<?= basename($_SERVER['PHP_SELF']) == "matches.php" ? ' class="active"' : '' ?>>Zápasy</a></li>
            <li><a href="/roster.php"<?= basename($_SERVER['PHP_SELF']) == "roster.php" ? ' class="active"' : '' ?>>Soupiska</a></li>
            <li><a href="/about.php"<?= basename($_SERVER['PHP_SELF']) == "about.php" ? ' class="active"' : '' ?>>O&nbsp;nás</a></li>
            <li><a href="/stats.php"<?= basename($_SERVER['PHP_SELF']) == "stats.php" ? ' class="active"' : '' ?>>Statistiky</a></li>

            <!-- Přihlášení se ukáže jen nepřihlášeným -->
            <?php if (!isset($_SESSION['user_id'])): ?>
                <li><a href="/login.php">Přihlášení</a></li>
            <?php endif; ?>

            <!-- Administrace (zatím zakomentovaná, využijeme později) -->
            <!-- 
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <li><a href="/admin/index.php">Administrace</a></li>
            <?php endif; ?> 
            -->
        </ul>
    </nav>

</header>




<!--
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Sebranka Praha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/base.css?v=1">
    <link rel="stylesheet" href="/css/style.css?v=1">
    <link rel="stylesheet" href="/css/menu.css?v=1">
    <link rel="stylesheet" href="/css/cards.css?v=1">
    <link rel="stylesheet" href="/css/footer.css?v=1">
    <link rel="stylesheet" href="/css/responsive.css?v=1">
<!--
    <link href="/css/base.css" rel="stylesheet"> 
    <link href="/css/style.css" rel="stylesheet">	
    <link rel="stylesheet" href="/css/body.css">
    <link rel="stylesheet" href="/css/menu.css">
    <link rel="stylesheet" href="/css/sponsors.css">
    <link rel="stylesheet" href="/css/cards.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/responsive.css"> 
->
    <link rel="icon" type="image/x-icon" href="logo/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="logo/favicon.png">      
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&family=Roboto:wght@400;700&display=swap&subset=latin-ext" rel="stylesheet">
    <script src="/js/main.js" defer></script>
</head>
<body>
<header class="navbar-pro">
    <nav class="menu-pro">
    
        <!-- Logo vlevo ->
        <div class="logo-left"><a href="/"><img src="/logo/sebranka-logo-01.svg" alt="Sebranka logo"></a></div>

        
        <!--Hamburger button ->
        <button id="hamburgerBtn" aria-label="Menu">&#9776;</button>
        

         
        <!-- Hlavní menu ->
<ul class="main-menu-inline" id="mainMenuInline">
    <li><a href="/index.php"<?= basename($_SERVER['PHP_SELF']) == "index.php" ? ' class="active"' : '' ?>>Novinky</a></li>
    <li><a href="/matches.php"<?= basename($_SERVER['PHP_SELF']) == "matches.php" ? ' class="active"' : '' ?>>Zápasy</a></li>
    <li><a href="/roster.php"<?= basename($_SERVER['PHP_SELF']) == "roster.php" ? ' class="active"' : '' ?>>Soupiska</a></li>
    <li><a href="/about.php"<?= basename($_SERVER['PHP_SELF']) == "about.php" ? ' class="active"' : '' ?>>O&nbsp;nás</a></li>
    <li><a href="/stats.php"<?= basename($_SERVER['PHP_SELF']) == "stats.php" ? ' class="active"' : '' ?>>Statistiky</a></li>
    <?php if (!isset($_SESSION['user_id'])): ?>
    <li><a href="/login.php">Přihlášení</a></li>
    <?php endif; ?>
    <!-- <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <li><a href="/admin/index.php">Administrace</a></li>
    <?php endif; ?> ->
</ul>



        <!-- Sponzoři ->
        <div class="menu-sponsor-tiles-and-label">
            <div class="menu-sponsor-tiles">
                <a href="https://www.autopapousek.cz" target="_blank" class="menu-sponsor-tile" title="Auto Papoušek"><img src="/uploads/sponsors/auto-papousek-kulate-logo.svg" alt="Auto Papoušek"></a>
                <a href="https://www.goodyear.eu/" target="_blank" class="menu-sponsor-tile" title="Goodyear"><img src="/uploads/sponsors/goodyear-logo.svg" alt="Goodyear"></a>
                <a href="https://neatwood.cz/" target="_blank" class="menu-sponsor-tile" title="Neatwood"><img src="/uploads/sponsors/neatwood-logo.svg" alt="Neatwood"></a>
            </div>
            <div class="menu-sponsor-label">Partneři&nbsp;a&nbsp;sponzoři</div>
        </div>
        
        <!-- Přihlášený uživatel: avatar + jméno ->
        <?php if (isset($_SESSION['user_id'])): ?>
        <div class="user-profile-menu" id="userProfileMenu">
            <img src="/logo/sebranka-lebkoun-01.svg" alt="Profil" class="user-avatar">
            <span class="user-profile-name"><?= htmlspecialchars($_SESSION['username']) ?></span>
            <div class="user-dropdown" id="userDropdown">
                <a href="/profile.php" class="user-dropdown-link">Můj účet</a>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="/admin/index.php" class="user-dropdown-link">Admin sekce</a>
                <?php endif; ?>
                <a href="/logout.php" class="user-dropdown-link">Odhlásit se</a>
            </div>
        </div>
        <?php endif; ?>
    </nav>        
</header>
                -->