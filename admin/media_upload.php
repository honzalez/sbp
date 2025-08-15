<?php
session_start();
require_once __DIR__ . '/../config/config.php'; // cesta podle umístění

// Přístup jen pro přihlášené
if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $desc = trim($_POST['description'] ?? '');
    $gallery_type = $_POST['gallery_type'] ?? 'moment';
    $match_id = !empty($_POST['match_id']) ? (int)$_POST['match_id'] : null;
    
    // Upload kontrola
    if (!isset($_FILES['media_file']) || $_FILES['media_file']['error'] !== UPLOAD_ERR_OK) {
        $error = "Chyba při nahrávání souboru!";
    } else {
        $file = $_FILES['media_file'];
        $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
        if (!in_array($file['type'], $allowed)) {
            $error = "Povoleny jsou pouze obrázky (jpg, png, gif, webp, svg).";
        } else {
            // Bezpečné jméno a cesta
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newname = 'media_' . date('Ymd_His') . '_' . rand(1000,9999) . '.' . $ext;
            $targetDir = __DIR__ . '/../uploads/';
            $targetFile = $targetDir . $newname;
            $webPath = '/uploads/moments/' . $newname;
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                // Zapsat do DB
                $stmt = $conn->prepare("INSERT INTO sbp_media (file_path, file_type, uploaded_by, description, match_id, gallery_type) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param('ssisis', $webPath, $file['type'], $_SESSION['user_id'], $desc, $match_id, $gallery_type);
                $stmt->execute();

                $success = "Soubor byl úspěšně nahrán.";
            } else {
                $error = "Soubor se nepodařilo uložit!";
            }
        }
    }
}
?>

<?php require_once __DIR__ .'/../includes/header.php'; ?>
<div class="main-box">
    <h2>Nahrát médium</h2>
    <?php if ($error) echo "<div class='error'>$error</div>"; ?>
    <?php if ($success) echo "<div class='info-box'>$success</div>"; ?>
    <form method="post" enctype="multipart/form-data">
        <label for="media_file">Soubor (obrázek):</label>
        <input type="file" name="media_file" id="media_file" required accept="image/*">
        
        <label for="description">Popisek:</label>
        <input type="text" name="description" id="description" maxlength="200">
        
        <label for="match_id">Zápas (volitelně):</label>
        <input type="number" name="match_id" id="match_id" min="1" placeholder="ID zápasu (nepovinné)">
        
        <label for="gallery_type">Typ galerie:</label>
        <select name="gallery_type" id="gallery_type">
            <option value="moment">Momentka</option>
            <option value="team">Týmová</option>
            <option value="promo">Promo</option>
            <option value="other">Jiné</option>
        </select>
        <input type="submit" value="Nahrát">
    </form>
</div>
<?php require_once __DIR__ .'/../includes/footer.php'; ?>
