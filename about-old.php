<?php
session_start();
?>
<?php require_once __DIR__ . '/includes/header.php'; ?>

    <main class="main-wrap">
        <h1>O klubu</h1>
        <p>Zde bude info o týmu, historii, kontakty...</p>
        
           <section class="sponsor-section">
        <h2>Naši partneři a sponzoři</h2>
        <div class="sponsor-cards">
            <div class="sponsor-card">
                <div class="sponsor-image helmet">
                    <img src="/logo/sebranka-logo-01.svg" alt="Logo na helmě">
                </div>
                <div class="sponsor-desc">Předek helmy<br><span class="sponsor-name">[LOGO SPONZORA]</span></div>
            </div>
            <div class="sponsor-card">
                <div class="sponsor-image jersey">
                    <img src="/logo/sebranka-napis-01.svg" alt="Jméno/Logo sponzora">
                    <div class="jersey-number">1</div>
                </div>
                <div class="sponsor-desc">Záda dresu<br><span class="sponsor-name">[JMÉNO/LOGO]</span></div>
            </div>
            <div class="sponsor-card">
                <div class="sponsor-image pants">
                    <img src="/logo/sebranka-lebkoun-01.svg" alt="Logo na kalhotách">
                </div>
                <div class="sponsor-desc">Kalhoty<br><span class="sponsor-name">[LOGO SPONZORA]</span></div>
            </div>
        </div>
    </section>   
    </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
