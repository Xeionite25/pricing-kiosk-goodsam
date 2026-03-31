<?php

// if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {

//     header("Location: /GS/Pages/404.php");
//     exit;
// }
//
// // Request file
// $request = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
//
// // Load file
// if (file_exists(__DIR__ . $request) && !is_dir(__DIR__ . $request)) {
//     return false;
// }
//
// // Show 404 for everything else
// http_response_code(404);
// include __DIR__ . '/GS/Pages/404.php';
//
// $request = urldecode($request);
// Get the requested file
$request = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

// Decode URL-encoded characters
$request = urldecode($request);

// Always allow assets (CSS, JS, Images)
$asset_extensions = ['.css', '.js', '.png', '.jpg', '.jpeg', '.gif', '.ico', '.svg'];

$ext = strtolower(pathinfo($request, PATHINFO_EXTENSION));
$is_asset = in_array('.' . $ext, $asset_extensions);

// If it's an asset and file exists, serve it
if ($is_asset && file_exists(__DIR__ . $request)) {
    return false;
}

// If it's a valid PHP file, serve it
if (file_exists(__DIR__ . $request) && !is_dir(__DIR__ . $request)) {
    return false;
}

// Show 404 for everything else
http_response_code(404);
include __DIR__ . '/GS/Pages/404.php';
