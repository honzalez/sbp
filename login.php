<?php
session_start();
require_once __DIR__ . '/config/config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password, role FROM sbp_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
        $user = $res->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: /index.php"); // <- ODKOMENTOVAT!
            exit;
        }
    }
    $error = "Nesprávné uživatelské jméno nebo heslo!";
}
?>
<?php require_once __DIR__ . '/includes/header.php'; ?>
    <div class="login-box main-box">
        <h2>Přihlášení</h2>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <label for="username">Uživatelské jméno</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Heslo</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Přihlásit se">
        </form>
    </div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>