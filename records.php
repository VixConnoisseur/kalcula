<?php include("db.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance Records</title>
    <link rel="stylesheet" href="attendance_style.css">
</head>
<body>
<div class="container">
    <h1> Attendance Records</h1>

    <table>
        <tr>
            <th>Employee ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>Date</th>
            <th>Status</th>
            <th>Role</th> </tr>
        <?php
        $where = "1=1";
        $params = [];
        $types = "";

        if (!empty($_GET['employee_name'])) {
            $name = "%" . $_GET['employee_name'] . "%";
            $where .= " AND employee_name LIKE ?";
            $params[] = $name;
            $types .= "s";
        }
        if (!empty($_GET['date'])) {
            $date = $_GET['date'];
            $where .= " AND date=?";
            $params[] = $date;
            $types .= "s";
        }
        if (!empty($_GET['department'])) {
            $dept = $_GET['department'];
            $where .= " AND department=?";
            $params[] = $dept;
            $types .= "s";
        }
        
        // Updated SQL query to select the new 'role' column
        $sql = "SELECT id, employee_id, employee_name, department, date, status, role FROM attendance WHERE $where ORDER BY date DESC";
        $stmt = $conn->prepare($sql);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['employee_id']}</td>
                        <td>{$row['employee_name']}</td>
                        <td>{$row['department']}</td>
                        <td>{$row['date']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['role']}</td> </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No records found</td></tr>";
        }
        
        $stmt->close();
        ?>
    </table>

    <div style="margin-top:20px; text-align:center;">
        <a href="index.php">⬅ Back to Dashboard</a>
    </div>
</div>
</body>
</html>