<?php

session_start();
$_SESSION['main'] = true;

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Location: /GS/Pages/404.php");
    exit;
}
