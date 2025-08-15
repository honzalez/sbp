<?php
session_start();
require_once __DIR__ . '/config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}
$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Získání údajů uživatele
$stmt = $conn->prepare("SELECT username, email, status FROM sbp_users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Změna údajů
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['deactivate_account'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $new_pass = $_POST['new_password'];

    $stmt2 = $conn->prepare("SELECT id FROM sbp_users WHERE (username=? OR email=?) AND id!=?");
    $stmt2->bind_param("ssi", $username, $email, $user_id);
    $stmt2->execute();
    if ($stmt2->get_result()->num_rows > 0) {
        $error = "Jméno nebo e-mail už někdo používá!";
    } else {
        if ($new_pass) {
            $hash = password_hash($new_pass, PASSWORD_DEFAULT);
            $up = $conn->prepare("UPDATE sbp_users SET username=?, email=?, password=? WHERE id=?");
            $up->bind_param("sssi", $username, $email, $hash, $user_id);
        } else {
            $up = $conn->prepare("UPDATE sbp_users SET username=?, email=? WHERE id=?");
            $up->bind_param("ssi", $username, $email, $user_id);
        }
        if ($up->execute()) {
            $success = "Údaje byly změněny.";
            $_SESSION['username'] = $username;
        } else {
            $error = "Chyba při ukládání!";
        }
    }
}

// Deaktivace účtu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deactivate_account'])) {
    $deact = $conn->prepare("UPDATE sbp_users SET status='deactivated' WHERE id=?");
    $deact->bind_param("i", $user_id);
    if ($deact->execute()) {
        log_action($conn, "user_deactivate", $user_id, $user_id, "Uživatel deaktivoval svůj účet");
        session_destroy();
        header("Location: /login.php?deactivated=1");
        exit;
    } else {
        $error = "Chyba při deaktivaci účtu!";
    }
}
?>
<?php include 'includes/header.php'; ?>
<div class="main-box" style="max-width:420px;margin:60px auto;">
    <h2>Můj profil</h2>
    <?php if($error): ?><div class="error"><?=htmlspecialchars($error)?></div><?php endif; ?>
    <?php if($success): ?><div class="success"><?=htmlspecialchars($success)?></div><?php endif; ?>
    <form method="post" autocomplete="off">
        <label>Uživatelské jméno</label>
        <input type="text" name="username" value="<?=htmlspecialchars($user['username'])?>" required>
        <label>E-mail</label>
        <input type="email" name="email" value="<?=htmlspecialchars($user['email'])?>" required>
        <label>Nové heslo (nepovinné)</label>
        <input type="password" name="new_password" autocomplete="new-password">
        <input type="submit" value="Uložit změny">
    </form>
    <hr>
    <form method="post" onsubmit="return confirm('Opravdu chcete deaktivovat svůj účet? Tato akce je nevratná.');">
        <input type="hidden" name="deactivate_account" value="1">
        <input type="submit" value="Deaktivovat účet" style="background:#ad3030;color:#fff;">
    </form>
</div>
<?php include 'includes/footer.php'; ?>

