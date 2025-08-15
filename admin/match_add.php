<?php
session_start();
require_once __DIR__ . '/../config/config.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /login.php"); exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $match_date = $_POST['match_date'];
    $home_team = trim($_POST['home_team']);
    $away_team = trim($_POST['away_team']);
    $score_for = (int)$_POST['score_for'];
    $score_against = (int)$_POST['score_against'];
    $note = trim($_POST['note']);
    $stmt = $conn->prepare("INSERT INTO sbp_matches (match_date, home_team, away_team, score_for, score_against, note) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiss", $match_date, $home_team, $away_team, $score_for, $score_against, $note);
    if ($stmt->execute()) {
        header("Location: match_list.php?added=1"); exit;
    } else {
        $error = "Chyba při vkládání!";
    }
}
?>
<?php include '../includes/header.php'; ?>
<div class="main-box" style="max-width:500px;margin:50px auto;">
    <h2>Přidat zápas</h2>
    <?php if($error): ?><div class="error"><?=$error?></div><?php endif; ?>
    <form method="post">
        <label>Datum</label>
        <input type="date" name="match_date" required>
        <label>Domácí tým</label>
        <input type="text" name="home_team" required>
        <label>Hostující tým</label>
        <input type="text" name="away_team" required>
        <label>Skóre domácích</label>
        <input type="number" name="score_for" min="0" required>
        <label>Skóre hostů</label>
        <input type="number" name="score_against" min="0" required>
        <label>Poznámka</label>
        <input type="text" name="note">
        <input type="submit" value="Uložit zápas">
    </form>
    <p><a href="match_list.php">Zpět na zápasy</a></p>
</div>
<?php include '../includes/footer.php'; ?>
