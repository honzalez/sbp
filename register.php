<?php
require_once __DIR__ . '/config/config.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $role = $_POST["role"] ?? "user";

    // Kontrola existence uživatele/emailu
    $stmt = $conn->prepare("SELECT id FROM sbp_users WHERE username=? OR email=?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $error = "Tento uživatel nebo email už existuje!";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $status = ($role === "user") ? "active" : "pending";
        $requested_role = ($role === "user") ? NULL : $role;
        $final_role = "user"; // Každý je nejdřív uživatel

        $insert = $conn->prepare("INSERT INTO sbp_users (username, password, email, role, status, requested_role) VALUES (?, ?, ?, ?, ?, ?)");
        $insert->bind_param("ssssss", $username, $hash, $email, $final_role, $status, $requested_role);
        if ($insert->execute()) {
            $success = "Registrace proběhla úspěšně. Podrobnosti najdeš ve svém e-mailu.";
            // Odeslat potvrzovací email
            $mail_sub = "Registrace na webu Sebranka Praha";
            if ($status === "pending") {
                $mail_body = "Děkujeme za registraci na Sebranka Praha.\n\n"
                           . "Požádali jste o vyšší roli („" . htmlspecialchars($role) . "“). Po schválení administrátorem vám přijde potvrzení.\n\n"
                           . "Do té doby máš účet jako běžný uživatel.";
            } else {
                $mail_body = "Děkujeme za registraci na Sebranka Praha.\n\n"
                           . "Účet je nyní aktivní, můžeš se přihlásit svými údaji na webu.\n\n"
                           . "Pokud jsi to nebyl ty, kontaktuj správce.";
            }
            $mail_headers = "From: info@sebrankapraha.cz\r\n"
                          . "Reply-To: info@sebrankapraha.cz\r\n"
                          . "Content-Type: text/plain; charset=utf-8\r\n";
            @mail($email, $mail_sub, $mail_body, $mail_headers);
        } else {
            $error = "Chyba databáze: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Registrace | Sebranka Praha</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<div class="login-box main-box">
    <h2>Registrace</h2>
    <?php if($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if($success): ?>
        <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="post" autocomplete="off">
        <label for="username">Uživatelské jméno</label>
        <input type="text" id="username" name="username" required>
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Heslo</label>
        <input type="password" id="password" name="password" required>
        <label for="role">Role</label>
        <select name="role" id="role">
            <option value="user">Běžný uživatel</option>
            <option value="player">Hráč (schvaluje admin)</option>
            <option value="editor">Editor (schvaluje admin)</option>
        </select>
        <input type="submit" value="Registrovat">
    </form>
</div>
</body>
</html>
