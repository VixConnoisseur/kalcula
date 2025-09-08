<?php
require 'config.php';
require 'functions.php';
require_login(); // Ensure user is logged in
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>KALCULA Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="assets/style.css">
<style>
body {
    background: linear-gradient(135deg, #1A4B6C, #4AA3DF);
}
</style>
</head>
<body class="min-h-screen flex flex-col">

<!-- Navigation Bar -->
<nav class="bg-[#1A4B6C] text-white p-4 flex justify-between items-center shadow-md">
    <span class="text-xl font-bold">KALCULA</span>
    <div class="flex items-center gap-4">
        <span><?= htmlspecialchars($_SESSION['username']) ?> (<?= $_SESSION['role'] ?>)</span>
        <a href="logout.php" class="underline hover:text-gray-200">Logout</a>
    </div>
</nav>

<!-- Dashboard Content -->
<main class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    <!-- Total Employees -->
    <div class="glass-card shadow-lg p-6 text-center">
        <h2 class="text-white font-bold text-lg mb-2">Total Employees</h2>
        <?php
        $stmt = $pdo->query("SELECT COUNT(*) AS total FROM employees");
        $total = $stmt->fetch()['total'];
        ?>
        <p class="text-[#3D3B40] text-3xl font-semibold mt-2"><?= $total ?></p>
    </div>

    <!-- Pending Leaves -->
    <div class="glass-card shadow-lg p-6 text-center">
        <h2 class="text-white font-bold text-lg mb-2">Pending Leaves</h2>
        <?php
        $stmt = $pdo->query("SELECT COUNT(*) AS total FROM leave_requests WHERE status='pending'");
        $pending = $stmt->fetch()['total'];
        ?>
        <p class="text-[#3D3B40] text-3xl font-semibold mt-2"><?= $pending ?></p>
    </div>

    <!-- Payrolls Processed -->
    <div class="glass-card shadow-lg p-6 text-center">
        <h2 class="text-white font-bold text-lg mb-2">Payrolls Processed</h2>
        <?php
        $stmt = $pdo->query("SELECT COUNT(*) AS total FROM payroll WHERE status='finalized'");
        $processed = $stmt->fetch()['total'];
        ?>
        <p class="text-[#3D3B40] text-3xl font-semibold mt-2"><?= $processed ?></p>
    </div>

    <!-- Quick Actions -->
    <div class="glass-card shadow-lg p-6 col-span-1 md:col-span-2 lg:col-span-3">
        <h2 class="text-white font-bold text-lg mb-4">Quick Actions</h2>
        <div class="flex flex-wrap gap-4">
            <a href="payroll.php" class="flex-1 text-center py-3 bg-[#1A4B6C] text-white rounded hover:bg-[#163b53] transition-colors">Process Payroll</a>
            <a href="leave_requests.php" class="flex-1 text-center py-3 bg-[#1A4B6C] text-white rounded hover:bg-[#163b53] transition-colors">Approve Leaves</a>
            <a href="employees.php" class="flex-1 text-center py-3 bg-[#1A4B6C] text-white rounded hover:bg-[#163b53] transition-colors">Manage Employe
