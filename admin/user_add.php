<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /login.php");
    exit;
}
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/header.php';

// CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = "";
$roles = ['admin','editor','player','viewer'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    $email = trim($_POST['email']);
    $csrf_token = $_POST['csrf_token'] ?? '';

    if ($csrf_token !== $_SESSION['csrf_token']) {
        $error = "Neplatný CSRF token!";
    } elseif (!$username || !$password || !$role) {
        $error = "Vyplňte všechna pole!";
    } elseif (!in_array($role, $roles)) {
        $error = "Neplatná role!";
    } else {
        $stmt = $conn->prepare("INSERT INTO sbp_users (username, password, role, email) VALUES (?, ?, ?, ?)");
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("ssss", $username, $hash, $role, $email);
        if ($stmt->execute()) {
            // Logování akce
            log_action($conn, "add_user", $_SESSION['user_id'], $stmt->insert_id, "Přidán uživatel: $username ($role)");
            header("Location: users.php");
            exit;
        } else {
            $error = "Chyba při ukládání!";
        }
    }
}
?>
<div class="admin-layout">
    <?php include 'admin_menu.php'; ?>
    <main class="admin-main">
        <h1>Přidat uživatele</h1>
        <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="post" autocomplete="off">
            <label>Uživatelské jméno:<br>
                <input type="text" name="username" required>
            </label><br>
            <label>Heslo:<br>
                <input type="password" name="password" required>
            </label><br>
            <label>Role:<br>
                <select name="role" required>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= $role ?>"><?= ucfirst($role) ?></option>
                    <?php endforeach; ?>
                </select>
            </label><br>
            <label>Email:<br>
                <input type="email" name="email">
            </label><br>
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <input type="submit" value="Přidat">
        </form>
        <p><a href="users.php" class="back-btn">Zpět na správu uživatelů</a></p>
    </main>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>