<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $points = $_POST['points'];

    $sql = "UPDATE Users SET name='$name', email='$email', points='$points' WHERE id='$id'";
    $message = '';
    if ($conn->query($sql) === TRUE) {
        $message = "User updated successfully.";
    } else {
        $message = "Error updating user: " . $conn->error;
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit User</title>
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
                width: 100%;
                max-width: 400px;
                text-align: center;
            }

            .container h2 {
                margin-bottom: 20px;
                color: #333;
            }

            .container input[type="text"],
            .container input[type="email"],
            .container input[type="number"] {
                width: 100%;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }

            .container input[type="submit"] {
                width: 100%;
                background-color: #4CAF50;
                color: white;
                padding: 10px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            }

            .container input[type="submit"]:hover {
                background-color: #45a049;
            }

            .message {
                padding: 20px;
                border-radius: 4px;
                font-size: 16px;
                margin-bottom: 20px;
                display: none;
            }

            .message.success {
                background-color: #dff0d8;
                color: #3c763d;
            }

            .message.error {
                background-color: #f2dede;
                color: #a94442;
            }
        </style>
        <script>
            window.onload = function () {
                var message = "<?php echo $message; ?>";
                if (message) {
                    alert(message);
                    window.location.href = "user_list.php";
                }
            }
        </script>
    </head>

    <body>
        <div class="container">
            <h2>Edit User</h2>
            <form method="POST" action="edit_user.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"
                    required>

                <label for="points">Points:</label>
                <input type="number" id="points" name="points" value="<?php echo htmlspecialchars($user['points']); ?>"
                    required>

                <input type="submit" value="Update User">
            </form>
        </div>
    </body>

    </html>

    <?php
} else {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM Users WHERE id='$id'");
    $user = $result->fetch_assoc();
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit User</title>
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
                width: 100%;
                max-width: 400px;
                text-align: center;
            }

            .container h2 {
                margin-bottom: 20px;
                color: #333;
            }

            .container input[type="text"],
            .container input[type="email"],
            .container input[type="number"] {
                width: 100%;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }

            .container input[type="submit"] {
                width: 100%;
                background-color: #4CAF50;
                color: white;
                padding: 10px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            }

            .container input[type="submit"]:hover {
                background-color: #45a049;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <h2>Edit User</h2>
            <form method="POST" action="edit_user.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"
                    required>

                <label for="points">Points:</label>
                <input type="number" id="points" name="points" value="<?php echo htmlspecialchars($user['points']); ?>"
                    required>

                <input type="submit" value="Update User">
            </form>
        </div>
    </body>

    </html>

    <?php
}
?>