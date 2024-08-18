<?php
include 'db.php';

$result = $conn->query("SELECT * FROM Users");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .actions a {
            text-decoration: none;
            color: #4CAF50;
            margin-right: 10px;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        .confirm-dialog {
            font-size: 0.9em;
            color: #a94442;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            margin: 10px 0;
            border-radius: 4px;
            color: #fff;
            background-color: #4CAF50;
            text-decoration: none;
            text-align: center;
        }

        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>User List</h2>
        <a href="register.php" class="btn">Add New User</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Referral Code</th>
                <th>Points</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['referral_code']; ?></td>
                    <td><?php echo $row['points']; ?></td>
                    <td class="actions">
                        <a href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a> |
                        <a href="delete_user.php?id=<?php echo $row['id']; ?>"
                            onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>

</html>