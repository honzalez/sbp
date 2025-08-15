<?php
require_once __DIR__ . '/../config/config.php';
session_start();

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: player_list.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("DELETE FROM sbp_players WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: player_list.php");
    exit;
}
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>
<h2>Smazat hráče</h2>
<p>Opravdu chcete smazat hráče?</p>
<form method="post">
    <button type="submit">Ano, smazat</button>
    <a href="player_list.php" class="back-btn">Ne, zpět</a>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
