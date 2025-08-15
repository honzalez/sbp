<?php
session_start();
require_once __DIR__ . '/../config/config.php';

// Přístup jen pro admina
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    echo "Přístup zamítnut.";
    exit;
}

// Ověření vstupů
$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($user_id < 1) {
    echo "Neplatné ID uživatele.";
    exit;
}

// Najít čekajícího uživatele
$stmt = $conn->prepare("SELECT id, username, email, requested_role, status FROM sbp_users WHERE id = ? AND status = 'pending'");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    echo "Uživatel nebyl nalezen nebo není čekající ke schválení.<br><a href='users.php'>Zpět</a>";
    exit;
}
$role = $user['requested_role'] ?: 'user';

// Schválení
$update = $conn->prepare("UPDATE sbp_users SET status = 'active', role = ?, requested_role = NULL WHERE id = ?");
$update->bind_param("si", $role, $user_id);
if ($update->execute()) {
    // Log
    log_action($conn, "approve_user", $_SESSION['user_id'], $user_id, "Schválen uživatel: {$user['username']}, role: $role");
    // Notifikační email
    $email = $user['email'];
    $subject = "Schválení registrace na Sebranka Praha";
    $message = "Váš účet byl schválen. Nyní máte přístup s rolí: $role.\n\nPřihlaste se na webu Sebranka Praha.";
    $headers = "From: info@sebrankapraha.cz\r\nContent-Type: text/plain; charset=utf-8\r\n";
    @mail($email, $subject, $message, $headers);

    echo "Uživatel byl úspěšně schválen a má nyní roli $role.<br><a href='users.php'>Zpět na správu uživatelů</a>";
} else {
    echo "Chyba při schvalování: " . $conn->error;
}
?>
