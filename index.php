<?php include("db.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>📊 Attendance Dashboard</h1>

    <?php
    // Get today's date
    $today = date('Y-m-d');

    // Query counts for Present, Absent, Late
    $present = $conn->query("SELECT COUNT(*) AS total FROM attendance WHERE date='$today' AND status='Present'")->fetch_assoc()['total'];
    $absent  = $conn->query("SELECT COUNT(*) AS total FROM attendance WHERE date='$today' AND status='Absent'")->fetch_assoc()['total'];
    $late    = $conn->query("SELECT COUNT(*) AS total FROM attendance WHERE date='$today' AND status='Late'")->fetch_assoc()['total'];
    ?>

    <div class="cards">
        <div class="card">✔ Present Today: <?= $present ?></div>
        <div class="card">✖ Absent Today: <?= $absent ?></div>
        <div class="card">⏰ Late Today: <?= $late ?></div>
    </div>

    <div style="text-align:center; margin-top:20px;">
        <a href="records.php">📖 View Attendance Records</a>
        <a href="add_attendance.php">➕ Add Attendance</a>
    </div>
</div>
</body>
</html>