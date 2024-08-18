<?php
include 'db.php';

function generateReferralCode($length = 10)
{
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $referral_code = generateReferralCode();
    $special_referral_code = "GCIMAJU";
    $entered_referral_code = $_POST['referral_code'];

    // Insert new user
    $sql = "INSERT INTO Users (name, email, password, referral_code) VALUES ('$name', '$email', '$password', '$referral_code')";
    if ($conn->query($sql) === TRUE) {
        $new_user_id = $conn->insert_id;

        // Cek jika pengguna memasukkan kode referral khusus
        if ($entered_referral_code == $special_referral_code) {
            // Cek jika kode referral khusus sudah digunakan
            $check_code_usage = $conn->query("SELECT * FROM Referrals WHERE referrer_id IS NULL AND referral_code_used = 1");
            if ($check_code_usage->num_rows == 0) {
                // Tambahkan 50 poin ke pengguna baru dan tandai kode referral sebagai digunakan
                $conn->query("UPDATE Users SET points = points + 50 WHERE id = '$new_user_id'");
                $conn->query("INSERT INTO Referrals (referrer_id, referred_id, referral_code_used) VALUES (NULL, '$new_user_id', 1)");
            }
        }

        // Cek jika pengguna memasukkan kode referral yang valid
        if ($entered_referral_code) {
            $referrer_result = $conn->query("SELECT * FROM Users WHERE referral_code = '$entered_referral_code' AND referral_code_used = 0");
            if ($referrer_result->num_rows > 0) {
                $referrer = $referrer_result->fetch_assoc();

                // Tambahkan 50 poin ke referrer dan tandai kode referral sebagai digunakan
                $conn->query("UPDATE Users SET points = points + 50, referral_code_used = 1 WHERE id = '{$referrer['id']}'");
                $conn->query("INSERT INTO Referrals (referrer_id, referred_id) VALUES ('{$referrer['id']}', '$new_user_id')");
            }
        }

        echo "<script>
                alert('Registration successful!');
                window.location.href = 'login.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

        .welcome-message {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.2em;
            color: #ff5722;
            animation: blink 1.5s infinite step-start;
        }

        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .referral-code {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.1em;
            color: #4CAF50;
            font-weight: bold;
        }

        .container input[type="text"],
        .container input[type="email"],
        .container input[type="password"] {
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

        .container .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
        }

        .container .login-link a {
            color: #4CAF50;
            text-decoration: none;
        }

        .container .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Register</h2>
        <div class="welcome-message">
            <p>Welcome to Training GCI!</p>
        </div>
        <div class="referral-code">
            Use the referral code below to earn additional points:<br>
            <strong>GCIMAJU</strong>
        </div>
        <form method="POST" action="register.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="referral_code">Referral Code <span class="optional">(optional)</span>:</label>
            <input type="text" id="referral_code" name="referral_code">

            <input type="submit" value="Register">
        </form>

        <div class="login-link">
            Already have an account? <a href="login.php">Login here</a>.
        </div>
    </div>

</body>

</html>