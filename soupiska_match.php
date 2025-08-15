<?php
// soupiska_match.php?match_id=123
session_start();
require_once __DIR__ . '/config/config.php';

$match_id = intval($_GET['match_id'] ?? 0);
if ($match_id <= 0) {
    echo "Neplatné ID zápasu";
    exit;
}

// Načtení zápasu (pro název atp.)
$sql_match = $conn->prepare("SELECT home_team, away_team, match_date FROM sbp_matches WHERE id = ?");
$sql_match->bind_param("i", $match_id);
$sql_match->execute();
$result_match = $sql_match->get_result();
$match = $result_match->fetch_assoc();
if (!$match) {
    echo "Zápas nenalezen";
    exit;
}

// Načtení soupisky - hráči + jejich pozice + čísla + avatar
$sql = $conn->prepare("
    SELECT p.id, p.name, p.number, p.nickname, p.avatar_media_id, l.position, l.line,
           m.file_path AS avatar_path
    FROM sbp_lineups l
    JOIN sbp_players p ON l.player_id = p.id
    LEFT JOIN sbp_media m ON p.avatar_media_id = m.id
    WHERE l.match_id = ?
    ORDER BY FIELD(l.position, 'Brankář', 'Obránce', 'Útočník'), l.line, p.number
");
$sql->bind_param("i", $match_id);
$sql->execute();
$result = $sql->get_result();

$lineup = ['Brankář' => [], 'Obránce' => [], 'Útočník' => []];
while ($row = $result->fetch_assoc()) {
    $pos = $row['position'] ?: 'Útočník'; // výchozí pokud není
    if (!isset($lineup[$pos])) $lineup[$pos] = [];
    $lineup[$pos][] = $row;
}

?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Soupiska zápasu <?= htmlspecialchars($match['home_team'].' vs '.$match['away_team']) ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .lineup-section {
            margin-bottom: 40px;
        }
        .lineup-section h2 {
            color: #7d0036;
            border-bottom: 2px solid #7d0036;
            padding-bottom: 4px;
            margin-bottom: 16px;
            font-family: 'Russo One', Arial, sans-serif;
        }
        .player-card {
            display: flex;
            align-items: center;
            background: #19191aee;
            border-radius: 10px;
            padding: 12px 18px;
            margin-bottom: 10px;
            box-shadow: 0 2px 10px #0006;
        }
        .player-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #232323;
            margin-right: 14px;
            object-fit: cover;
            border: 2px solid #7d0036;
        }
        .player-info {
            font-family: 'Russo One', Arial, sans-serif;
            color: #fff;
            font-size: 1.1em;
            flex-grow: 1;
        }
        .player-number {
            background: #7d0036;
            border-radius: 6px;
            padding: 4px 10px;
            color: #fff;
            font-weight: 700;
            font-family: 'Russo One', Arial, sans-serif;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
<div class="main-wrap">
    <h1>Soupiska zápasu: <?= htmlspecialchars($match['home_team']) ?> vs <?= htmlspecialchars($match['away_team']) ?></h1>
    <p><em>Datum zápasu: <?= htmlspecialchars($match['match_date']) ?></em></p>

    <?php foreach ($lineup as $position => $players): ?>
        <section class="lineup-section">
            <h2><?= $position ?></h2>
            <?php if (count($players) === 0): ?>
                <p>Žádní hráči v této pozici.</p>
            <?php else: ?>
                <?php foreach ($players as $player): ?>
                    <div class="player-card">
                        <img class="player-avatar" src="<?= htmlspecialchars($player['avatar_path'] ?? '/logo/sebranka-lebkoun-01.svg') ?>" alt="avatar <?= htmlspecialchars($player['name']) ?>">
                        <div class="player-info">
                            <?= htmlspecialchars($player['name']) ?> <?= $player['nickname'] ? '(' . htmlspecialchars($player['nickname']) . ')' : '' ?>
                        </div>
                        <div class="player-number"><?= htmlspecialchars($player['number'] ?? '-') ?></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    <?php endforeach; ?>
</div>
</body>
</html>
