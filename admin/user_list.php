<?php
session_start();
require_once __DIR__ . '/../config/config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    exit("Přístup zamítnut.");
}
$result = $conn->query("SELECT id, username, email, role, status FROM sbp_users ORDER BY id");
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>
<div class="main-box" style="max-width:800px;margin:50px auto;">
    <h2>Uživatelé</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Uživatel</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Akce</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?=htmlspecialchars($row['id'])?></td>
                <td><?=htmlspecialchars($row['username'])?></td>
                <td><?=htmlspecialchars($row['email'])?></td>
                <td><?=htmlspecialchars($row['role'])?></td>
                <td><?=htmlspecialchars($row['status'])?></td>
                <td>
                    <a href="user_edit.php?id=<?=$row['id']?>">Upravit</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
