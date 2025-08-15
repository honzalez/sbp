<?php
// ...session kontrola na admina...
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /login.php");
    exit;
}
$q = $conn->query("
    SELECT rr.id, rr.user_id, rr.requested_role, rr.request_time, u.username, u.email 
    FROM sbp_role_requests rr
    JOIN sbp_users u ON rr.user_id = u.id
    WHERE rr.processed = 0
    ORDER BY rr.request_time ASC
");
while ($row = $q->fetch_assoc()) {
    echo "<div>";
    echo "<b>{$row['username']}</b> ({$row['email']}) žádá o roli <strong>{$row['requested_role']}</strong> ";
    echo "<form method='post' action='approve_role.php' style='display:inline'>";
    echo "<input type='hidden' name='request_id' value='{$row['id']}'>";
    echo "<input type='submit' value='Povýšit'>";
    echo "</form>";
    echo "</div>";
}
?>
