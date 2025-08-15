<?php
session_start();
require_once __DIR__ . '/../config/config.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /login.php"); exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $team = trim($_POST['team']);
    $position = trim($_POST['default_position']);
    $number = (int)$_POST['number'];
    $stmt = $conn->prepare("INSERT INTO sbp_players (name, team, default_position, number) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $team, $position, $number);
    if ($stmt->execute()) {
        header("Location: player_list.php?added=1"); exit;
    } else {
        $error = "Chyba při vkládání!";
    }
}
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>
<div class="main-box" style="max-width:500px;margin:50px auto;">
    <h2>Přidat hráče</h2>
    <?php if($error): ?><div class="error"><?=$error?></div><?php endif; ?>
    <form method="post">
        <label>Jméno</label>
        <input type="text" name="name" required>
        <label>Tým</label>
        <input type="text" name="team" required>
        <label>Pozice</label>
        <input type="text" name="default_position" required>
        <label>Číslo dresu</label>
        <input type="number" name="number" min="0" required>
        <input type="submit" value="Uložit hráče">
    </form>
    <p><a href="player_list.php">Zpět na soupisku</a></p>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
