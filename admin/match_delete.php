<?php
session_start();
require_once __DIR__ . '/../config/config.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /login.php"); exit;
}
$id = (int)($_GET['id'] ?? 0);
if (!$id) exit("Neplatné ID zápasu.");

$stmt = $conn->prepare("DELETE FROM sbp_matches WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
header("Location: match_list.php?deleted=1");
exit;
?>
