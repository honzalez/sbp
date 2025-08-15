<?php
session_start();
require_once __DIR__ . '/config/config.php'; // cesta podle umístění configu

// Načteme poslední 3 zápasy
$sql = "SELECT match_date, home_team, away_team, score_for, score_against, note
        FROM sbp_matches
        ORDER BY match_date DESC
        LIMIT 3";
$result = $conn->query($sql);

// Pole pro zápasy
$matches = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $matches[] = $row;
    }
}
?>  
               
<?php require_once __DIR__ . '/includes/header.php'; ?>

    <section class="hero-simple">
        <img src="/logo/sebranka-napis-01.svg" class="hero-napis" alt="Sebranka Praha">
        <div class="hero-tagline">
            Oficiální web týmu – výsledky, statistiky a aktuality
        </div>
    </section>
   <!--
 <section class="sponsor-section">
    <h2>Naši partneři a sponzoři</h2>
    <div class="sponsor-cards">
        <!-- Helma ->
        <div class="sponsor-card">
            <div class="sponsor-image helmet">
                <img src="logo/sebranka-logo-01.svg" alt="Logo na helmě">
            </div>
            <div class="sponsor-desc">Předek helmy<br><span class="sponsor-name">[LOGO SPONZORA]</span></div>
        </div>
        <!-- Dres ->
        <div class="sponsor-card">
            <div class="sponsor-image jersey">
                <img src="logo/sebranka-napis-01.svg" alt="Jméno/Logo sponzora">
                <div class="jersey-number">1</div>
            </div>
            <div class="sponsor-desc">Záda dresu<br><span class="sponsor-name">[JMÉNO/LOGO]</span></div>
        </div>
        <!-- Kalhoty ->
        <div class="sponsor-card">
            <div class="sponsor-image pants">
                <img src="logo/sebranka-lebkoun-01.svg" alt="Logo na kalhotách">
            </div>
            <div class="sponsor-desc">Kalhoty<br><span class="sponsor-name">[LOGO SPONZORA]</span></div>
        </div>
    </div>
</section>
   -->
    <main class="main-wrap">
        <section class="cards-row">
            <div class="info-card">
                <div class="info-title">Poslední zápas</div>
                <div class="info-value"><span class="jersey-num">8 : 5</span><br><small>vs. PRE</small></div>
            </div>
            <div class="info-card">
                <div class="info-title">Nejbližší zápas</div>
                <div class="info-value">Pátek 13.6.2025 21:00<br><small>ICERINK</small></div>
            </div>
            <div class="info-card">
                <div class="info-title">
                    <img src="/logo/sebranka-lebkoun-01.svg" alt="Lebkoun" class="icon-lebkoun"> Top střelec
                </div>
                <div class="info-value">Sam<br><span class="jersey-num">4 G</span></div>
            </div>
        </section>
        
        <section class="matches-table">
    <h2>Zápasy</h2>
    <table>
        <tr><th>Datum</th><th>Soupeř</th><th>Skóre</th><th>Poznámka</th></tr>
        <?php foreach ($matches as $match): ?>
            <tr>
                <td><?= htmlspecialchars($match['match_date']) ?></td>
                <td>
                    <?= htmlspecialchars($match['home_team']) ?>
                    <span style="color:#888;font-size:0.9em;">vs</span>
                    <?= htmlspecialchars($match['away_team']) ?>
                </td>
                <td class="jersey-num"><?= (int)$match['score_for'] ?> : <?= (int)$match['score_against'] ?></td>
                <td><?= htmlspecialchars($match['note']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>

        <section class="news-section">
            <h2>Novinky</h2>
            <div class="news-list">
                <article class="news-card">
                    <h3>Hattrick Sama proti Rybářům!</h3>
                    <p>V posledním zápase Sebranka deklasovala soupeře 10:0, Sam zaznamenal čtyři branky.</p>
                    <span class="news-date"></span>
                </article>
                <article class="news-card">
                    <h3>Přichází nové levé křídlo</h3>
                    <p>Na led, jako hráč se dostal i Honza (rozhodčí). Ačkoliv nastoupil jako LK, švihl si i pozici centra!</p>
                    <span class="news-date"></span>
                </article>
               <article class="news-card news-sparta">
                    <h3>
                        <img src="/logo/sebranka-lebkoun-01.svg" alt="SBP" style="height:17px;vertical-align:middle;margin-right:6px;">
                        PRE padlo se Sebrankou!
                    </h3>
                    <p>
                        Zápas byl pěkně vyrovnaný jak na počet hráčů, tak i na počet branek, ale v závěru se Sebranka ještě jendou pořádně nadechala a nedala už soupeři šanci. 
                        <span style="color:#7d0036;font-weight:bold;"></span>
                    </p>
                </article>
            </div>
        </section>
    </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>