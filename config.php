<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "GreenLife";

try {
    $conn = new mysqli($host, $user, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Set charset to UTF-8 for proper character encoding
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}
?>