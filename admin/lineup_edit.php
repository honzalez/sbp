<?php
session_start();
require_once __DIR__ . '/config/config.php';

$match_id = $_GET['match_id'] ?? null;
if (!$match_id) {
    die('Chybí ID zápasu.');
}

// Načti všechny hráče
$playersRes = $conn->query("SELECT id, name, number FROM sbp_players WHERE is_staff=0 ORDER BY number");

// Načti soupisku pro zápas
$stmt = $conn->prepare("SELECT * FROM sbp_lineups WHERE match_id = ?");
$stmt->bind_param("i", $match_id);
$stmt->execute();
$lineupRes = $stmt->get_result();

$lineup = [];
while ($row = $lineupRes->fetch_assoc()) {
    $lineup[$row['player_id']] = $row;
}

// Zpracování formuláře
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Smazat stávající soupisku pro zápas (jednoduchý přístup)
    $del = $conn->prepare("DELETE FROM sbp_lineups WHERE match_id = ?");
    $del->bind_param("i", $match_id);
    $del->execute();

    // Vložit nové záznamy
    if (!empty($_POST['players'])) {
        $insert = $conn->prepare("INSERT INTO sbp_lineups (match_id, player_id, position, line, is_captain, is_alternate, is_substitute) VALUES (?, ?, ?, ?, ?, ?, ?)");
        foreach ($_POST['players'] as $player_id => $data) {
            $position = $conn->real_escape_string($data['position']);
            $line = intval($data['line']);
            $is_captain = isset($data['is_captain']) ? 1 : 0;
            $is_alternate = isset($data['is_alternate']) ? 1 : 0;
            $is_substitute = isset($data['is_substitute']) ? 1 : 0;
            $insert->bind_param("iisiiii", $match_id, $player_id, $position, $line, $is_captain, $is_alternate, $is_substitute);
            $insert->execute();
        }
        $insert->close();
    }
    header("Location: lineup.php?match_id=$match_id");
    exit;
}
?>

<?php require_once __DIR__ . '/includes/header.php'; ?>

<main class="main-wrap">
    <h1>Úprava soupisky zápasu #<?= htmlspecialchars($match_id) ?></h1>
    <form method="post">
        <table>
            <thead>
                <tr>
                    <th>Vybrán</th>
                    <th>Jméno</th>
                    <th>Pozice</th>
                    <th>Lajna</th>
                    <th>Kapitán (C)</th>
                    <th>Asistent (A)</th>
                    <th>Náhradník</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($player = $playersRes->fetch_assoc()): 
                    $pid = $player['id'];
                    $data = $lineup[$pid] ?? null;
                ?>
                <tr>
                    <td>
                        <input type="checkbox" name="players[<?= $pid ?>][selected]" <?= $data ? 'checked' : '' ?>>
                    </td>
                    <td><?= htmlspecialchars($player['name']) ?> (<?= htmlspecialchars($player['number']) ?>)</td>
                    <td>
                        <input type="text" name="players[<?= $pid ?>][position]" value="<?= htmlspecialchars($data['position'] ?? '') ?>">
                    </td>
                    <td>
                        <input type="number" min="1" max="10" name="players[<?= $pid ?>][line]" value="<?= htmlspecialchars($data['line'] ?? '') ?>" style="width:50px;">
                    </td>
                    <td>
                        <input type="checkbox" name="players[<?= $pid ?>][is_captain]" <?= ($data && $data['is_captain']) ? 'checked' : '' ?>>
                    </td>
                    <td>
                        <input type="checkbox" name="players[<?= $pid ?>][is_alternate]" <?= ($data && $data['is_alternate']) ? 'checked' : '' ?>>
                    </td>
                    <td>
                        <input type="checkbox" name="players[<?= $pid ?>][is_substitute]" <?= ($data && $data['is_substitute']) ? 'checked' : '' ?>>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <button type="submit">Uložit soupisku</button>
    </form>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
