<?php
session_start();
require_once __DIR__ . '/../config/config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    exit("Přístup zamítnut.");
}

$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$user_id) exit("Neplatné ID uživatele.");

// Načíst uživatele
$stmt = $conn->prepare("SELECT id, username, email, role, status FROM sbp_users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
if (!$user) exit("Uživatel nenalezen.");

$error = '';
$success = '';

// Změna údajů
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['admin_deactivate']) && !isset($_POST['admin_delete'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $status = $_POST['status'];
    $new_pass = $_POST['new_password'];

    $stmt2 = $conn->prepare("SELECT id FROM sbp_users WHERE (username=? OR email=?) AND id!=?");
    $stmt2->bind_param("ssi", $username, $email, $user_id);
    $stmt2->execute();
    if ($stmt2->get_result()->num_rows > 0) {
        $error = "Jméno nebo e-mail už někdo používá!";
    } else {
        if ($new_pass) {
            $hash = password_hash($new_pass, PASSWORD_DEFAULT);
            $up = $conn->prepare("UPDATE sbp_users SET username=?, email=?, role=?, status=?, password=? WHERE id=?");
            $up->bind_param("sssssi", $username, $email, $role, $status, $hash, $user_id);
        } else {
            $up = $conn->prepare("UPDATE sbp_users SET username=?, email=?, role=?, status=? WHERE id=?");
            $up->bind_param("ssssi", $username, $email, $role, $status, $user_id);
        }
        if ($up->execute()) {
            $success = "Uživatel upraven.";
            log_action($conn, "edit_user", $_SESSION['user_id'], $user_id, "Admin editace uživatele $username");
        } else {
            $error = "Chyba databáze: " . $conn->error;
        }
    }
}

// Deaktivace adminem
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_deactivate'])) {
    $deact = $conn->prepare("UPDATE sbp_users SET status='deactivated' WHERE id=?");
    $deact->bind_param("i", $user_id);
    if ($deact->execute()) {
        log_action($conn, "admin_deactivate", $_SESSION['user_id'], $user_id, "Admin deaktivoval účet");
        $success = "Účet deaktivován.";
        $user['status'] = 'deactivated';
    } else {
        $error = "Chyba deaktivace!";
    }
}

// Trvalé smazání adminem
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_delete'])) {
    $del = $conn->prepare("DELETE FROM sbp_users WHERE id=?");
    $del->bind_param("i", $user_id);
    if ($del->execute()) {
        log_action($conn, "admin_delete", $_SESSION['user_id'], $user_id, "Admin smazal účet");
        header("Location: users.php?deleted=1");
        exit;
    } else {
        $error = "Chyba mazání!";
    }
}
?>
<?php include '../includes/header.php'; ?>
<div class="main-box" style="max-width:480px;margin:50px auto;">
    <h2>Editace uživatele</h2>
    <?php if($error): ?><div class="error"><?=htmlspecialchars($error)?></div><?php endif; ?>
    <?php if($success): ?><div class="success"><?=htmlspecialchars($success)?></div><?php endif; ?>
    <form method="post" autocomplete="off">
        <label>Uživatelské jméno</label>
        <input type="text" name="username" value="<?=htmlspecialchars($user['username'])?>" required>
        <label>E-mail</label>
        <input type="email" name="email" value="<?=htmlspecialchars($user['email'])?>" required>
        <label>Role</label>
        <select name="role" required>
            <option value="user"   <?=$user['role']=='user'?'selected':''?>>user</option>
            <option value="player" <?=$user['role']=='player'?'selected':''?>>player</option>
            <option value="editor" <?=$user['role']=='editor'?'selected':''?>>editor</option>
            <option value="admin"  <?=$user['role']=='admin'?'selected':''?>>admin</option>
        </select>
        <label>Status</label>
        <select name="status" required>
            <option value="active"    <?=$user['status']=='active'?'selected':''?>>aktivní</option>
            <option value="pending"   <?=$user['status']=='pending'?'selected':''?>>čekající</option>
            <option value="deactivated" <?=$user['status']=='deactivated'?'selected':''?>>deaktivovaný</option>
        </select>
        <label>Nové heslo (ponech prázdné, pokud nechceš změnit)</label>
        <input type="password" name="new_password" autocomplete="new-password">
        <input type="submit" value="Uložit změny">
    </form>
    <?php if ($user['status'] !== 'deactivated'): ?>
        <form method="post" style="margin-top:16px;" onsubmit="return confirm('Opravdu deaktivovat tento účet?');">
            <input type="hidden" name="admin_deactivate" value="1">
            <input type="submit" value="Deaktivovat účet" style="background:#ad3030;color:#fff;">
        </form>
    <?php endif; ?>
    <form method="post" style="margin-top:8px;" onsubmit="return confirm('Opravdu trvale smazat tento účet? Tato akce je nevratná!');">
        <input type="hidden" name="admin_delete" value="1">
        <input type="submit" value="Smazat účet" style="background:#333;color:#fff;">
    </form>
    <p><a href="users.php">Zpět na uživatele</a></p>
</div>
<?php include '../includes/footer.php'; ?>
