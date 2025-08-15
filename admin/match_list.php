<?php
session_start();
require_once __DIR__ . '/../config/config.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /login.php"); exit;
}
$result = $conn->query("SELECT * FROM sbp_matches ORDER BY match_date DESC");
?>
<?php include '../includes/header.php'; ?>
<div class="main-box" style="max-width:900px;margin:50px auto;">
    <h2>Správa zápasů</h2>
    <a href="match_add.php" class="main-btn" style="margin-bottom:16px;display:inline-block;">+ Přidat zápas</a>
    <table>
        <tr>
            <th>ID</th><th>Datum</th><th>Domácí</th><th>Hosté</th><th>Skóre</th><th>Poznámka</th><th>Akce</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?=$row['id']?></td>
            <td><?=htmlspecialchars($row['match_date'])?></td>
            <td><?=htmlspecialchars($row['home_team'])?></td>
            <td><?=htmlspecialchars($row['away_team'])?></td>
            <td><?=htmlspecialchars($row['score_for'])?> : <?=htmlspecialchars($row['score_against'])?></td>
            <td><?=htmlspecialchars($row['note'])?></td>
            <td>
                <a href="match_edit.php?id=<?=$row['id']?>">Upravit</a> | 
                <a href="match_delete.php?id=<?=$row['id']?>" onclick="return confirm('Opravdu smazat?');">Smazat</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php include '../includes/footer.php'; ?>
