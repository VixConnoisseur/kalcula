<?php include("db.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Attendance</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>➕ Add Attendance Record</h1>

    <form method="POST">
        <input type="text" name="employee_id" placeholder="Employee ID" required>
        <input type="text" name="employee_name" placeholder="Employee Name" required>
        <input type="date" name="date" required>
        <select name="department" required>
            <option value="HR">HR</option>
            <option value="IT">IT</option>
            <option value="">Finance</option>
        </select>
        <select name="status" required>
            <option value="Present">Present</option>
            <option value="Absent">Absent</option>
            <option value="Late">Late</option>
        </select>
        <select name="role" required>
            <option value="Admin">Admin</option>
            <option value="HR">HR</option>
            <option value="Payroll Clerk">Payroll Clerk</option>
        </select>
        <input type="submit" name="save" value="Save">
    </form>

    <div style="margin-top:20px;">
        <a href="records.php">📖 View Records</a>
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
    $role          = $_POST['role']; // New: Get the role

    // Updated SQL query to include the new 'role' column
    $sql = "INSERT INTO attendance (employee_id, employee_name, department, date, status, role) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    // Updated bind_param to include the new 'role' parameter
    $stmt->bind_param("ssssss", $employee_id, $employee_name, $department, $date, $status, $role);

    if ($stmt->execute()) {
        echo "<script>alert('Attendance Added Successfully!'); window.location='records.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}
?>