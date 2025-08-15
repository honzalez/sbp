<?php
session_start();
?>
<?php require_once __DIR__ . '/includes/header.php'; ?>

<main class="main-wrap">
    <?php
    require_once __DIR__ . '/config/config.php';

    $sql = "SELECT * FROM sbp_matches ORDER BY match_date DESC";
    $res = $conn->query($sql);
    ?>

    <h1>Zápasy</h1>
    <table class="matches-table">
        <thead>
            <tr>
                <th>Datum</th>
                <th>Doma</th>
                <th>Venku</th>
                <th>Skóre</th>
                <th>Trenér</th>
                <th>Rozhodčí</th>
                <th>Poznámka</th>
                <th>Spotify playlist</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['match_date']) ?></td>
                    <td><?= htmlspecialchars($row['home_team']) ?></td>
                    <td><?= htmlspecialchars($row['away_team']) ?></td>
                    <td><?= htmlspecialchars($row['score_for']) ?> : <?= htmlspecialchars($row['score_against']) ?></td>
                    <td><?= htmlspecialchars($row['coach_name']) ?></td>
                    <td><?= htmlspecialchars($row['referee_name']) ?></td>
                    <td><?= htmlspecialchars($row['note']) ?></td>
                    <td>
                        <?php if (!empty($row['spotify_playlist'])): ?>
                            <a href="<?= htmlspecialchars($row['spotify_playlist']) ?>" target="_blank">Playlist</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="/lineup.php?match_id=<?= $row['id'] ?>">Soupiska</a> |
                        <a href="/stats.php?match_id=<?= $row['id'] ?>">Statistiky</a> |
                        <a href="/gallery.php?match_id=<?= $row['id'] ?>">Galerie</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
