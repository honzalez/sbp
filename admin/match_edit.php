<?php
session_start();
require_once __DIR__ . '/../config/config.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /login.php"); exit;
}
$id = (int)($_GET['id'] ?? 0);
if (!$id) exit("Neplatné ID zápasu.");

$stmt = $conn->prepare("SELECT * FROM sbp_matches WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$match = $stmt->get_result()->fetch_assoc();
if (!$match) exit("Zápas nenalezen.");
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $match_date = $_POST['match_date'];
    $home_team = trim($_POST['home_team']);
    $away_team = trim($_POST['away_team']);
    $score_for = (int)$_POST['score_for'];
    $score_against = (int)$_POST['score_against'];
    $note = trim($_POST['note']);
    $stmt2 = $conn->prepare("UPDATE sbp_matches SET match_date=?, home_team=?, away_team=?, score_for=?, score_against=?, note=? WHERE id=?");
    $stmt2->bind_param("sssissi", $match_date, $home_team, $away_team, $score_for, $score_against, $note, $id);
    if ($stmt2->execute()) {
        header("Location: match_list.php?edited=1"); exit;
    } else {
        $error = "Chyba při ukládání!";
    }
}
?>
<?php include '../includes/header.php'; ?>
<div class="main-box" style="max-width:500px;margin:50px auto;">
    <h2>Editace zápasu</h2>
    <?php if($error): ?><div class="error"><?=$error?></div><?php endif; ?>
    <form method="post">
        <label>Datum</label>
        <input type="date" name="match_date" value="<?=htmlspecialchars($match['match_date'])?>" required>
        <label>Domácí tým</label>
        <input type="text" name="home_team" value="<?=htmlspecialchars($match['home_team'])?>" required>
        <label>Hostující tým</label>
        <input type="text" name="away_team" value="<?=htmlspecialchars($match['away_team'])?>" required>
        <label>Skóre domácích</label>
        <input type="number" name="score_for" min="0" value="<?=$match['score_for']?>" required>
        <label>Skóre hostů</label>
        <input type="number" name="score_against" min="0" value="<?=$match['score_against']?>" required>
        <label>Poznámka</label>
        <input type="text" name="note" value="<?=htmlspecialchars($match['note'])?>">
        <input type="submit" value="Uložit změny">
    </form>
    <p><a href="match_list.php">Zpět na zápasy</a></p>
</div>
<?php include '../includes/footer.php'; ?>
