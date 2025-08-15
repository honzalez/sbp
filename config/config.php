<?php
$host = "md414.wedos.net";
$user = "";     // Zadej své údaje
$pass = "";
$db   = "d301858_sbprg";

$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Chyba připojení: " . $conn->connect_error);
}

// Logovací funkce – použiješ všude, kde includuješ config.php
function log_action($conn, $action, $admin_id, $user_id, $info) {
    $stmt = $conn->prepare("INSERT INTO sbp_userlog (action, admin_id, user_id, info) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siis", $action, $admin_id, $user_id, $info);
    $stmt->execute();
}
?>