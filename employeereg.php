<?php
// Include database connection file
include_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'];
    $full_name = $_POST['full_name'];
    $gmail = $_POST['gmail'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $resident_gps = $_POST['resident_gps'];
    $position = $_POST['position'];
    $bank_name = $_POST['bank_name'];
    $bank_account_number = $_POST['bank_account_number'];
    $status = 'pending'; // Default status
    $password = $_POST['password']; // No hashing

    // Validate inputs
    if (empty($employee_id)) {
        echo "All fields are required.";
        exit;
    }

    if (!filter_var($gmail, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        echo "Invalid phone number. It should be 10 digits.";
        exit;
    }

    // Insert data into the database
    $sql = "INSERT INTO employees (employee_id, full_name, gmail, phone, dob, gender, resident_gps, position, bank_name, bank_account_number, status, password) 
            VALUES (:employee_id, :full_name, :gmail, :phone, :dob, :gender, :resident_gps, :position, :bank_name, :bank_account_number, :status, :password)";
    
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([
            ':employee_id' => $employee_id,
            ':full_name' => $full_name,
            ':gmail' => $gmail,
            ':phone' => $phone,
            ':dob' => $dob,
            ':gender' => $gender,
            ':resident_gps' => $resident_gps,
            ':position' => $position,
            ':bank_name' => $bank_name,
            ':bank_account_number' => $bank_account_number,
            ':status' => $status,
            ':password' => $password
        ]);

        echo "<script>alert('THANK YOU FOR REGISTERING. Waiting for approval from HR'); window.location.href = 'login.php';</script>";
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
