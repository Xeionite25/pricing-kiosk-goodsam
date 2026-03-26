<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    require_once __DIR__ . '/../../data/DB/database.php';

    $sql = "SELECT data FROM pricing_kiosk ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result && $row = $result->fetchArray(SQLITE3_ASSOC)) {
        echo $row['data'];
    } else {
        echo json_encode([]);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
