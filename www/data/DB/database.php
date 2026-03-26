<?php

// $host = "localhost";
// $user = "root";
// $pass = "";
// $db = "pricing_items";
//
// $conn = mysqli_connect($host, $user, $pass, $db);
//
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }

// Optional: echo "Connected successfully";


//SqLite3 Version
$token = __DIR__ . '/../DB/database.db';
$conn = new SQLite3($token);

$conn->enableExceptions(true);
