<?php
// Include database connection file
include_once 'db_connect.php';
session_start();

// Handle approval or dismissal actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];
    
    if ($action === 'approve') {
        $status = 'active';
    } elseif ($action === 'dismiss') {
        $status = 'dismissed';
    } else {
        die('Invalid action.');
    }

    // Update employee status
    $sql = "UPDATE employees SET status = :status WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':status' => $status, ':id' => $id]);
}

// Fetch employees, excluding the logged-in user
$logged_in_user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

$sql = "SELECT * FROM employees WHERE id != :logged_in_user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':logged_in_user_id' => $logged_in_user_id]);
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            margin: 0;
        }
        .side-nav {
            width: 200px;
            background-color: #333;
            color: #fff;
            padding: 15px;
            height: 100vh;
            position: fixed;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .side-nav a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            text-align: center;
        }
        .side-nav a:hover {
            background-color: #575757;
        }
        .container {
            margin-left: 220px;
            padding: 20px;
            width: calc(100% - 220px);
        }
        h2 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: white;
        }
        .action-buttons a {
            margin-right: 10px;
            color: #fff;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }
        .approve {
            background-color: #5cb85c;
        }
        .dismiss {
            background-color: #d9534f;
        }
        .approve:hover {
            background-color: #4cae4c;
        }
        .dismiss:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <h2>Employee Management</h2>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee ID</th>
                    <th>Full Name</th>
                    <th>Gmail</th>
                    <th>Phone</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Resident GPS</th>
                    <th>Position</th>
                    <th>Bank Name</th>
                    <th>Bank Account Number</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $employee): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($employee['id']); ?></td>
                        <td><?php echo htmlspecialchars($employee['employee_id']); ?></td>
                        <td><?php echo htmlspecialchars($employee['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($employee['gmail']); ?></td>
                        <td><?php echo htmlspecialchars($employee['phone']); ?></td>
                        <td><?php echo htmlspecialchars($employee['dob']); ?></td>
                        <td><?php echo htmlspecialchars($employee['gender']); ?></td>
                        <td><?php echo htmlspecialchars($employee['resident_gps']); ?></td>
                        <td><?php echo htmlspecialchars($employee['position']); ?></td>
                        <td><?php echo htmlspecialchars($employee['bank_name']); ?></td>
                        <td><?php echo htmlspecialchars($employee['bank_account_number']); ?></td>
                        <td><?php echo htmlspecialchars($employee['status']); ?></td>
                        <td class="action-buttons">
                            <?php if ($employee['status'] === 'pending'): ?>
                                <a href="?action=approve&id=<?php echo htmlspecialchars($employee['id']); ?>" class="btn btn-success">Approve</a>
                                <a href="?action=dismiss&id=<?php echo htmlspecialchars($employee['id']); ?>" class="btn btn-danger">Dismiss</a>
                            <?php else: ?>
                                <span>---</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
