<?php include("db.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Attendance</title>
    <link rel="stylesheet" href="attendance_style.css">
    <style>
        input::placeholder {
            font-weight: bold;
            color: #333;
        }

        select {
            font-weight: bold;
            color: #333;
        }

        input[type="submit"] {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Add Attendance Record</h1>

    <form method="POST">
        <input type="text" name="employee_id" placeholder="Employee ID" required>
        <input type="text" name="employee_name" placeholder="Employee Name" required>
        <input type="date" name="date" required>

        <select name="department" required>
            <option value="" disabled selected>Select Department</option>
            <option value="HR">HR</option>
            <option value="IT">IT</option>
            <option value="Finance">Finance</option>
        </select>

        <select name="status" required>
            <option value="" disabled selected>Select Status</option>
            <option value="Present">Present</option>
            <option value="Absent">Absent</option>
            <option value="Late">Late</option>
        </select>

        <select name="role" required>
            <option value="" disabled selected>Select Role</option>
            <option value="Admin">Admin</option>
            <option value="HR">HR</option>
            <option value="Payroll Clerk">Payroll Clerk</option>
        </select>

        <input type="submit" name="save" value="Save">
    </form>

    <div style="margin-top: 30px; text-align: center;">
        <a href="records.php">View Records</a>
    </div>
</div>
</body>
</html>

<?php
if (isset($_POST['save'])) {
    $employee_id   = $_POST['employee_id'];
    $employee_name = $_POST['employee_name'];
    $date          = $_POST['date'];
    $department    = $_POST['department'];
    $status        = $_POST['status'];
    $role          = $_POST['role'];

    $sql = "INSERT INTO attendance (employee_id, employee_name, department, date, status, role) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $employee_id, $employee_name, $department, $date, $status, $role);

    if ($stmt->execute()) {
        echo "<script>alert('Attendance Added Successfully!'); window.location='records.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>