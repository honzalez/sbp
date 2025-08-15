<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /login.php");
    exit;
}
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="admin-layout">
    <?php include 'admin_menu.php'; ?>
    <main class="admin-main">
        <!-- obsah konkrétní stránky -->
    </main>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>