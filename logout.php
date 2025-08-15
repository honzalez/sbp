<?php
session_start();
require_once __DIR__ . '/config/config.php';
if (isset($_SESSION['user_id'])) {
    log_action($conn, 'logout', $_SESSION['user_id'], $_SESSION['user_id'], 'Uživatel se odhlásil');
}
session_unset();
session_destroy();
header('Location: login.php');
exit;
?>      
