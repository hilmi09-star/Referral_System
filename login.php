<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $special_referral_code = "GCIMAJU";

    $result = $conn->query("SELECT * FROM Users WHERE email = '$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            echo "<script>
                    alert('Login successful!');
                    window.location.href = 'user_list.php';
                  </script>";

            // Check if the user enters the special referral code during login
            if ($_POST['referral_code'] == $special_referral_code) {
                // Check if the referral code has already been used by this user
                if ($user['referral_code_used'] == 0) {
                    // Check if this referral code has already been used by another user
                    $check_code_usage = $conn->query("SELECT * FROM Referrals WHERE referrer_id = '$user[id]' AND referral_code_used = 1");
                    if ($check_code_usage->num_rows == 0) {
                        // Add 50 points to the user and mark the referral code as used
                        $conn->query("UPDATE Users SET points = points + 50, referral_code_used = 1 WHERE id = '$user[id]'");
                        $conn->query("INSERT INTO Referrals (referrer_id, referred_id, referral_code_used) VALUES ('$user[id]', NULL, 1)");
                    }
                } else {
                    echo "<div class='message error'>Referral code has already been used.</div>";
                }
            }
        } else {
            echo "<div class='message error'>Invalid password.</div>";
        }
    } else {
        echo "<script>
        alert('Data not Found');
      </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        }

        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .container input[type="email"],
        .container input[type="password"],
        .container input[type="text"] {
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

        .container .optional {
            color: #777;
            font-size: 0.9em;
        }

        .container .message {
            text-align: center;
            margin: 10px 0;
            padding: 10px;
            border-radius: 4px;
            font-size: 1em;
        }

        .container .message.success {
            background-color: #dff0d8;
            color: #3c763d;
        }

        .container .message.error {
            background-color: #f2dede;
            color: #a94442;
        }

        .container .signup-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
        }

        .container .signup-link a {
            color: #4CAF50;
            text-decoration: none;
        }

        .container .signup-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Login</h2>
        <form method="POST" action="login.php">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="referral_code">Referral Code <span class="optional">(optional)</span>:</label>
            <input type="text" id="referral_code" name="referral_code">

            <input type="submit" value="Login">
        </form>

        <div class="signup-link">
            Don't have an account? <a href="register.php">Sign up here</a>.
        </div>
    </div>

</body>

</html>