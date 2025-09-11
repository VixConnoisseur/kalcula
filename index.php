    <?php include("db.php"); ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Attendance Dashboard</title>
        <link rel="stylesheet" href="attendance_style.css">
    </head>
    <body>
    <div class="container">
        <h1> Attendance </h1>

         <?php
         $today = date('Y-m-d');
         $present = $conn->query("SELECT COUNT(*) AS total FROM attendance WHERE date='$today' AND LOWER(TRIM(status))='present'")->fetch_assoc()['total'];
         $absent  = $conn->query("SELECT COUNT(*) AS total FROM attendance WHERE date='$today' AND LOWER(TRIM(status))='absent'")->fetch_assoc()['total'];
         $late = $conn->query("SELECT COUNT(*) AS total FROM attendance WHERE date='$today' AND LOWER(TRIM(status))='late'")->fetch_assoc()['total'];
         ?>
         
        <div class="cards">
            <div class="card"> Present Today: <?= $present ?></div>
            <div class="card"> Absent Today: <?= $absent ?></div>
            <div class="card"> Late Today: <?= $late ?></div>
        </div>

        <div style="text-align:center; margin-top:20px;">
            <a href="records.php"> View Attendance Records</a>
            <a href="add_attendance.php"> Add Attendance</a>
        </div>
    </div>
    </body>
    </html>