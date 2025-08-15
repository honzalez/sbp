<?php
require 'config.php';
$username = 'sa';
$password = password_hash('admin123', PASSWORD_DEFAULT);
$sql = "INSERT INTO sbp_users (username, password, role, email) VALUES (?, ?, 'admin', 'adminx@sebrankapraha.cz')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
echo "Admin vytvořen.";
?>
