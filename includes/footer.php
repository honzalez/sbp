<?php
// ===== FOOTER SEKCE WEBU =====
// Tento soubor se includuje na všech stránkách.
// Obsahuje logo (volitelné) a odkazy na hlavní sekce webu.
?>

<footer class="footer-pro">
    <div class="footer-wrap">

        <!-- Logo v patičce (může být i menší varianta týmového loga) -->
        <div class="footer-logo">
            <img src="/img/logo.png" alt="Sebranka Praha" height="40">
        </div>

        <!-- Textová část footeru -->
        <div class="footer-text">
            <!-- Navigační odkazy - stejné jako v hlavním menu -->
            <a href="/index.php">Novinky</a> | 
            <a href="/matches.php">Zápasy</a> | 
            <a href="/roster.php">Soupiska</a> | 
            <a href="/about.php">O&nbsp;nás</a> | 
            <a href="/stats.php">Statistiky</a>
        </div>

    </div>

    <!-- Autorské info nebo copyright -->
    <div class="footer-text" style="margin-top:10px; font-size:0.85em;">
        &copy; <?= date("Y") ?> Sebranka Praha – všechna práva vyhrazena
    </div>
</footer>
</body>
</html>