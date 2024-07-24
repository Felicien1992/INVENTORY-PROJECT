<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
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
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }

        button:hover {
            background-color: #4cae4c;
        }
        
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login Form</h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="gmail">Gmail</label>
                <input type="email" id="gmail" name="gmail" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <?php
session_start(); // Start the session

// Include database connection file
include_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gmail = $_POST['gmail'];
    $password = $_POST['password'];

    // Validate inputs
    if (empty($gmail) || empty($password)) {
        echo "<p class='error'>Gmail and Password are required.</p>";
        exit;
    }

    if (!filter_var($gmail, FILTER_VALIDATE_EMAIL)) {
        echo "<p class='error'>Invalid email format.</p>";
        exit;
    }

    // Fetch the user from the database
    $sql = "SELECT * FROM employees WHERE gmail = :gmail";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':gmail' => $gmail]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($employee) {
        // Verify the password (plain text comparison)
        if ($password == $employee['password']) {
            if ($employee['status'] == 'pending') {
                echo "<p class='error'>Your account is pending. Waiting for approval from HR.</p>";
            } elseif ($employee['status'] == 'dismissed') {
                echo "<p class='error'>Your account has been dismissed.</p>";
            } elseif ($employee['status'] == 'active') {
                // Store user information in the session
                $_SESSION['user_id'] = $employee['id'];
                $_SESSION['user_gmail'] = $employee['gmail'];
                $_SESSION['user_position'] = $employee['position'];

                // Redirect based on the position
                if ($employee['position'] == 'stock manager') {
                    header("Location: stock.php");
                } elseif ($employee['position'] == 'warehouse manager') {
                    header("Location: warehouse.php");
                } elseif ($employee['position'] == 'human resource') {
                    header("Location: hr.php");
                } else {
                    echo "<p class='error'>Invalid position.</p>";
                }
                exit;
            } else {
                echo "<p class='error'>Invalid account status.</p>";
            }
        } else {
            echo "<p class='error'>Incorrect password.</p>";
        }
    } else {
        echo "<p class='error'>No account found with that email.</p>";
    }
}
?>
    </div>
</body>
</html>
