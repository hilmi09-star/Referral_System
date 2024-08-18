<?php
include 'db.php';

$id = $_GET['id'];
$sql = "DELETE FROM Users WHERE id='$id'";

$message = '';
if ($conn->query($sql) === TRUE) {
    $message = "User deleted successfully.";
} else {
    $message = "Error deleting user: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }

        .message {
            padding: 20px;
            border-radius: 4px;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .message.success {
            background-color: #dff0d8;
            color: #3c763d;
        }

        .message.error {
            background-color: #f2dede;
            color: #a94442;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 4px;
            color: #fff;
            background-color: #4CAF50;
            text-decoration: none;
            text-align: center;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        window.onload = function () {
            alert("<?php echo $message; ?>");
            window.location.href = "user_list.php";
        }
    </script>
</head>

<body>

    <div class="container">
        <!-- The message will be shown via JavaScript alert -->
    </div>

</body>

</html>