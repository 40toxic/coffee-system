<?php
session_start();
include('config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form submission
    if (isset($_POST['create_admin'])) {
        $admin_id = hash('sha256', $_POST['admin_id']); // Hashing the admin ID
        $admin_name = $_POST['admin_name'];
        $admin_email = $_POST['admin_email'];
        $admin_password = sha1(md5($_POST['admin_password'])); // Double encrypt to increase security

        // Insert new admin into database
        $insert_stmt = $mysqli->prepare("INSERT INTO colos_admin (admin_id, admin_name, admin_email, admin_password) VALUES (?, ?, ?, ?)");
        $insert_stmt->bind_param('ssss', $admin_id, $admin_name, $admin_email, $admin_password);
        if ($insert_stmt->execute()) {
            $success = "Admin created successfully";
        } else {
            $err = "Creation failed";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(#00ffff, #8b4513);
            margin: 0;
            padding: 20px;
        }

        h1 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            max-width: 300px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 1px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: tan;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
        }

        .error {
            background-color: #ffcccc;
            border: 1px solid #ff0000;
            color: #ff0000;
        }

        .success {
            background-color: burlywood;
            border: 1px solid #00cc00;
            color: #006600;
        }
    </style>
</head>

<body>
    <h1>Create New Admin</h1>
    <?php if (isset($err)) : ?>
        <p>Error: <?php echo $err; ?></p>
    <?php endif; ?>
    <?php if (isset($success)) : ?>
        <p>Success: <?php echo $success; ?></p>
    <?php endif; ?>
    <form method="post">
        <!-- If admin_id is not auto-incremented, you can include it here -->
        <label for="admin_id">Admin ID:</label><br>
        <input type="text" id="admin_id" name="admin_id" required><br><br>
        
        <label for="admin_name">Admin Name:</label><br>
        <input type="text" id="admin_name" name="admin_name" required><br><br>
        
        <label for="admin_email">Email:</label><br>
        <input type="email" id="admin_email" name="admin_email" required><br><br>
        
        <label for="admin_password">Password:</label><br>
        <input type="password" id="admin_password" name="admin_password" required><br><br>
        
        <input type="submit" name="create_admin" value="Create Admin">
    </form>
</body>

</html>
