<?php
$host = 'localhost';
$db = 'gci_db';
$user = 'root';
$pass = '';

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the charset to avoid character encoding issues
if (!$conn->set_charset("utf8mb4")) {
    die("Error loading character set utf8mb4: " . $conn->error);
}
?>