<?php
session_start();
?>
<?php require_once __DIR__ . '/includes/header.php'; ?>

    <main class="main-wrap">
        <h1>O klubu</h1>
        <p>Zde bude info o týmu, historii, kontakty...</p>
        
   <!-- TŘI ČISTÉ REKLAMNÍ BANNERY / SPONZOŘI -->
<section class="sponsor-section" style="margin-top: 36px;">
    <h2>Naši partneři a sponzoři</h2>
    <div class="sponsor-cards">
        <div class="sponsor-card" style="background: none; box-shadow: none; border: none;">
            <div class="sponsor-image" style="background: none; border: none; box-shadow: none;">
                <img src="/uploads/sponsors/auto-papousek-kulate-logo.svg" alt="Auto Papoušek" style="border: none; background: none; box-shadow: none; border-radius: 0; max-height: 80px;">
            </div>
            <div class="sponsor-desc"></div>
        </div>
        <div class="sponsor-card" style="background: none; box-shadow: none; border: none;">
            <div class="sponsor-image" style="background: none; border: none; box-shadow: none;">
                <img src="/uploads/sponsors/goodyear-logo.svg" alt="Goodyear" style="border: none; background: none; box-shadow: none; border-radius: 0; max-height: 80px;">
            </div>
            <div class="sponsor-desc"></div>
        </div>
        <div class="sponsor-card" style="background: none; box-shadow: none; border: none;">
            <div class="sponsor-image" style="background: none; border: none; box-shadow: none;">
                <img src="/uploads/sponsors/neatwood-logo.svg" alt="Neatwood" style="border: none; background: none; box-shadow: none; border-radius: 0; max-height: 80px;">
            </div>
            <div class="sponsor-desc"></div>
        </div>
    </div>
</section>



<?php require_once __DIR__ . '/includes/footer.php'; ?>