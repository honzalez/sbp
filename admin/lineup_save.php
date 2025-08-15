<?php
session_start();
require_once __DIR__ . '/config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $match_id = (int)($_POST['match_id'] ?? 0);
    if (!$match_id) {
        die("Neplatný zápas.");
    }

    // Nejprve odznačit všechny příznaky u soupisky tohoto zápasu
    $conn->query("UPDATE sbp_lineups SET is_captain=0, is_alternate=0, is_substitute=0 WHERE match_id = $match_id");

    // Pak označit vybrané
    $updateStmt = $conn->prepare("UPDATE sbp_lineups SET is_captain=?, is_alternate=?, is_substitute=? WHERE id=?");

    // Pole s ID z POST (mohou chybět)
    $captainIds = $_POST['captain'] ?? [];
    $assistantIds = $_POST['assistant'] ?? [];
    $substituteIds = $_POST['substitute'] ?? [];

    // Všechny soupisky zápasu
    $res = $conn->query("SELECT id FROM sbp_lineups WHERE match_id = $match_id");
    while ($row = $res->fetch_assoc()) {
        $id = $row['id'];
        $isCaptain = in_array($id, $captainIds) ? 1 : 0;
        $isAssistant = in_array($id, $assistantIds) ? 1 : 0;
        $isSubstitute = in_array($id, $substituteIds) ? 1 : 0;

        $updateStmt->bind_param("iiii", $isCaptain, $isAssistant, $isSubstitute, $id);
        $updateStmt->execute();
    }

    header("Location: lineup.php?match_id=$match_id&saved=1");
    exit;
}

die("Neplatný požadavek.");
