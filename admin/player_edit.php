<?php
require_once __DIR__ . '/../config/config.php';
session_start();

$id = $_GET['id'] ?? null;
$edit = false;
$name = $nickname = $team = $default_position = $staff_role = '';
$number = $is_staff = 0;
$avatar_media_id = $user_id = null;

if ($id) {
    $sql = "SELECT * FROM sbp_players WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($id, $name, $nickname, $team, $default_position, $number, $is_staff, $staff_role, $avatar_media_id, $user_id);
    $edit = $stmt->fetch();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $nickname = $_POST['nickname'] ?? '';
    $team = $_POST['team'] ?? '';
    $default_position = $_POST['default_position'] ?? '';
    $number = $_POST['number'] ?: null;
    $is_staff = isset($_POST['is_staff']) ? 1 : 0;
    $staff_role = $_POST['staff_role'] ?? null;
    $avatar_media_id = $_POST['avatar_media_id'] ?: null;
    $user_id = $_POST['user_id'] ?: null;

    if ($id) {
        $sql = "UPDATE sbp_players SET name=?, nickname=?, team=?, default_position=?, number=?, is_staff=?, staff_role=?, avatar_media_id=?, user_id=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiissii", $name, $nickname, $team, $default_position, $number, $is_staff, $staff_role, $avatar_media_id, $user_id, $id);
        $stmt->execute();
    } else {
        $sql = "INSERT INTO sbp_players (name, nickname, team, default_position, number, is_staff, staff_role, avatar_media_id, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiissi", $name, $nickname, $team, $default_position, $number, $is_staff, $staff_role, $avatar_media_id, $user_id);
        $stmt->execute();
    }
    header("Location: player_list.php");
    exit;
}

// Pro select avatarů
function mediaOptions($conn, $selected_id = null) {
    $sql = "SELECT id, file_path FROM sbp_media WHERE file_type LIKE 'image/%' ORDER BY id DESC";
    $res = $conn->query($sql);
    $out = '<option value="">- žádný -</option>';
    while ($row = $res->fetch_assoc()) {
        $out .= '<option value="' . $row['id'] . '" ' . ($selected_id == $row['id'] ? 'selected' : '') . '>' . htmlspecialchars($row['file_path']) . '</option>';
    }
    return $out;
}

// Pro select uživatelů
function userOptions($conn, $selected_id = null) {
    $sql = "SELECT id, username FROM sbp_users ORDER BY username";
    $res = $conn->query($sql);
    $out = '<option value="">- žádný -</option>';
    while ($row = $res->fetch_assoc()) {
        $out .= '<option value="' . $row['id'] . '" ' . ($selected_id == $row['id'] ? 'selected' : '') . '>' . htmlspecialchars($row['username']) . '</option>';
    }
    return $out;
}
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>
<h2><?= $edit ? 'Upravit hráče' : 'Přidat hráče' ?></h2>
<form method="post" autocomplete="off">
    <label>Jméno hráče*<input type="text" name="name" value="<?= htmlspecialchars($name) ?>" required></label>
    <label>Přezdívka<input type="text" name="nickname" value="<?= htmlspecialchars($nickname) ?>"></label>
    <label>Tým<input type="text" name="team" value="<?= htmlspecialchars((isset($team) && trim($team) !== '') ? $team : 'Sebranka Praha') ?>"></label>      
    <label>Výchozí pozice:
      <select name="default_position">
          <option value="">--vyberte--</option>
          <option value="Brankář" <?= $default_position == 'Brankář' ? 'selected' : '' ?>>Brankář</option>
          <option value="Levý Obránce" <?= $default_position == 'Levý Obránce' ? 'selected' : '' ?>>Levý Obránce</option>
          <option value="Pravý Obránce" <?= $default_position == 'Pravý Obránce' ? 'selected' : '' ?>>Pravý Obránce</option>
          <option value="Levé křídlo" <?= $default_position == 'Levé křídlo' ? 'selected' : '' ?>>Levé křídlo</option>
          <option value="Pravé křídlo" <?= $default_position == 'Pravé křídlo' ? 'selected' : '' ?>>Pravé křídlo</option>
          <option value="Centr" <?= $default_position == 'Centr' ? 'selected' : '' ?>>Centr</option>
      </select>
    </label>
    <label>Číslo dresu<input type="number" name="number" value="<?= htmlspecialchars($number) ?>"></label>
    <label><input type="checkbox" name="is_staff" <?= $is_staff ? 'checked' : '' ?>> Člen realizačního týmu</label>
    <label>Pozice v realizačním týmu:
      <select name="staff_role">
          <option value="">--není člen RT--</option>
          <option value="Hlavní trenér" <?= $staff_role == 'Hlavní trenér' ? 'selected' : '' ?>>Hlavní trenér</option>
          <option value="Asistent trenéra" <?= $staff_role == 'Asistent trenéra' ? 'selected' : '' ?>>Asistent trenéra</option>
          <option value="Kondiční trenér" <?= $staff_role == 'Kondiční trenér' ? 'selected' : '' ?>>Kondiční trenér</option>
          <option value="Lékař" <?= $staff_role == 'Lékař' ? 'selected' : '' ?>>Lékař</option>
          <option value="Vedoucí mužstva" <?= $staff_role == 'Vedoucí mužstva' ? 'selected' : '' ?>>Vedoucí mužstva</option>
          <option value="Masér" <?= $staff_role == 'Masér' ? 'selected' : '' ?>>Masér</option>
          <option value="Rozhodčí" <?= $staff_role == 'Rozhodčí' ? 'selected' : '' ?>>Rozhodčí</option>
          <option value="Jiné" <?= $staff_role == 'Jiné' ? 'selected' : '' ?>>Jiné</option>
      </select>
    </label>
    <label>Avatar (vyber z nahraných obrázků)</label>
    <select name="avatar_media_id"><?= mediaOptions($conn, $avatar_media_id) ?></select>
    <label>Přiřadit k uživateli</label>
    <select name="user_id"><?= userOptions($conn, $user_id) ?></select>
    <button type="submit"><?= $edit ? 'Uložit změny' : 'Přidat hráče' ?></button>
    <a href="player_list.php" class="back-btn">Zpět na soupisku</a>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
