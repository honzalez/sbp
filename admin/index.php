<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /login.php");
    exit;
}
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>


<main class="admin-main">
  <h1>Administrace</h1>
<?php require_once __DIR__ . '/../admin/admin_menu.php'; ?>
</main>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>