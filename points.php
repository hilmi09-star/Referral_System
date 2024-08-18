<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $user_id = $_GET['user_id'];

    $result = $conn->query("SELECT points FROM Users WHERE id = '$user_id'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo "User Points: " . $user['points'];
    } else {
        echo "User not found.";
    }
}
?>