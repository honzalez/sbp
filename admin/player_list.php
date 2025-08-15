<?php
require_once __DIR__ . '/../config/config.php';
session_start();
// Přidej kontrolu oprávnění admin/editor...

$sql = "SELECT p.*, u.username as user_username FROM sbp_players p LEFT JOIN sbp_users u ON p.user_id = u.id ORDER BY p.name";
$res = $conn->query($sql);
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>
<h2>Soupiska hráčů</h2>
<a href="player_edit.php" class="main-btn">+ Přidat hráče</a>
<table class="admin-table">
    <tr>
        <th>Jméno</th>
        <th>Přezdívka</th>
        <th>Post</th>
        <th>Číslo</th>
        <th>Staff</th>
        <th>Avatar</th>
        <th>Uživatel</th>
        <th>Akce</th>
    </tr>
    <?php while ($p = $res->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($p['name']) ?></td>
        <td><?= htmlspecialchars($p['nickname']) ?></td>
        <td><?= htmlspecialchars($p['default_position']) ?></td>
        <td><?= htmlspecialchars($p['number']) ?></td>
        <td><?= $p['is_staff'] ? htmlspecialchars($p['staff_role']) : '' ?></td>
        <td>
            <?php if ($p['avatar_media_id']): ?>
                <img src="<?= htmlspecialchars(getAvatarUrl($p['avatar_media_id'])) ?>" alt="avatar" style="height:36px;">
            <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($p['user_username']) ?></td>
        <td>
            <a href="player_edit.php?id=<?= $p['id'] ?>">Upravit</a>
            <a href="player_delete.php?id=<?= $p['id'] ?>" onclick="return confirm('Opravdu smazat hráče?');">Smazat</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>

<?php
// Pomocná funkce (implementuj podle svého storage)
function getAvatarUrl($media_id) {
    // Vrací URL obrázku podle ID v tabulce sbp_media
    global $conn;
    $sql = "SELECT file_path FROM sbp_media WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $media_id);
    $stmt->execute();
    $stmt->bind_result($file_path);
    if ($stmt->fetch()) {
        return $file_path;
    }
    return '/img/default_avatar.svg'; // nebo jiný default
}
?>
