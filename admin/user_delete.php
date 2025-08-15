<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /login.php");
    exit;
}
require_once __DIR__ . '/../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $csrf_token = $_POST['csrf_token'] ?? '';

    // Ověř CSRF token
    if ($csrf_token !== $_SESSION['csrf_token']) {
        die("Chybný CSRF token!");
    }

    // Nesmíš smazat admina
    $q = $conn->prepare("SELECT username, role FROM sbp_users WHERE id = ?");
    $q->bind_param("i", $id);
    $q->execute();
    $q->bind_result($username, $role);
    if ($q->fetch()) {
        if ($role === 'admin') {
            die("Nelze smazat hlavního admina!");
        }
    }
    $q->close();

    // Smazání uživatele
    $stmt = $conn->prepare("DELETE FROM sbp_users WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        // Logování
        log_action($conn, "delete_user", $_SESSION['user_id'], $id, "Smazán uživatel: $username ($role)");
        $_SESSION['user_deleted'] = 1;
    }
}
header("Location: users.php");
exit;
?>