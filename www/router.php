<?php

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Location: /GS/Pages/404.php");
    exit;
}

// Request file
$request = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

// Load file
if (file_exists(__DIR__ . $request) && !is_dir(__DIR__ . $request)) {
    return false;
}

// Show 404 for everything else
http_response_code(404);
include __DIR__ . '/GS/Pages/404.php';
