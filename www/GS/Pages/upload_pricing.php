<?php

// use Tracy\Debugger;
//
// require '../vendor/autoload.php';
// Debugger::enable();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . '/data/DB/database.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['filename']) || !isset($input['data'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
    exit;
}

$filename = $conn->escapeString($input['filename']);
$data = $input['data'];

$jsonData = json_encode($data);
if ($jsonData === false) {
    echo json_encode(['success' => false, 'error' => 'Failed to encode data']);
    exit;
}

$escapedJson = $conn->escapeString($jsonData);

$sql = "INSERT INTO pricing_kiosk (filename, data) VALUES ('$filename', '$escapedJson')";
if ($conn->exec($sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->lastErrorMsg()]);
}
