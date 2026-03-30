<?php

// session_start();
//
// if (!isset($_SESSION['main']) || $_SESSION['main'] !== true) {
//     header("Location: /GS/Pages/404.php");
//     exit;
//     // if (!isset($_GET['token'])) {
//     //     header("Location: ../GS/index.php");
//     //     exit;
// }
//
// unset($_SESSION['main']);


session_start();

// Block direct access
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Location: /GS/Pages/404.php");
    exit;
}
if (!isset($_GET['token'])) {
    header("Location: /GS/Pages/404.php");
    exit;
}

if (!isset($_SESSION['main']) || $_SESSION['main'] !== true) {
    header("Location: /GS/Pages/404.php");
    exit;
}

// Session is valid, keep it for this visit
// Don't unset it here - let admin_panel.php use it
