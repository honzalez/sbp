<?php
session_start();
require_once __DIR__ . '/config/config.php';

if (!isset($_GET['match_id']) || !is_numeric($_GET['match_id'])) {
    die("Neplatný zápas.");
}
$match_id = (int)$_GET['match_id'];

// Načti zápas
$stmt = $conn->prepare("SELECT * FROM sbp_matches WHERE id = ?");
$stmt->bind_param("i", $match_id);
$stmt->execute();
$match = $stmt->get_result()->fetch_assoc();
if (!$match) {
    die("Zápas nenalezen.");
}

// Načti soupisku zápasu
$stmt = $conn->prepare("
    SELECT l.*, p.name, p.number, p.default_position
    FROM sbp_lineups l
    JOIN sbp_players p ON l.player_id = p.id
    WHERE l.match_id = ?
    ORDER BY l.line, p.number
");
$stmt->bind_param("i", $match_id);
$stmt->execute();
$lineups = $stmt->get_result();

?>

<?php require_once __DIR__ . '/includes/header.php'; ?>

<main class="main-wrap">
    <h1>Soupiska zápasu <?= htmlspecialchars($match['home_team']) ?> vs <?= htmlspecialchars($match['away_team']) ?> (<?= htmlspecialchars($match['match_date']) ?>)</h1>

    <form method="post" action="lineup_save.php">
        <input type="hidden" name="match_id" value="<?= $match_id ?>">

        <table class="player-table">
            <thead>
                <tr>
                    <th>Číslo</th>
                    <th>Jméno</th>
                    <th>Pozice</th>
                    <th>Lína</th>
                    <th>Kapitán (C)</th>
                    <th>Asistent (A)</th>
                    <th>Náhradník</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $lineups->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['number']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['position']) ?></td>
                    <td><?= htmlspecialchars($row['line']) ?></td>
                    <td>
                        <input type="checkbox" name="captain[]" value="<?= $row['id'] ?>" <?= $row['is_captain'] ? 'checked' : '' ?>>
                    </td>
                    <td>
                        <input type="checkbox" name="assistant[]" value="<?= $row['id'] ?>" <?= $row['is_alternate'] ? 'checked' : '' ?>>
                    </td>
                    <td>
                        <input type="checkbox" name="substitute[]" value="<?= $row['id'] ?>" <?= $row['is_substitute'] ? 'checked' : '' ?>>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <button type="submit" class="main-btn">Uložit soupisku</button>
    </form>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
