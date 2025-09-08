<?php
require 'config.php';

// Check if any users exist
$stmt = $pdo->query("SELECT COUNT(*) AS total FROM users");
$totalUsers = $stmt->fetch()['total'];

if ($totalUsers == 0) {
    // No users exist, create default admin
    $defaultUsername = 'admin';
    $defaultPassword = 'Admin123!'; // default password
    $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password, role, first_login) VALUES (?, ?, 'admin', 1)");
    $stmt->execute([$defaultUsername, $hashedPassword]);
    echo "Default admin created successfully!<br>";
    echo "Username: <strong>{$defaultUsername}</strong><br>";
    echo "Password: <strong>{$defaultPassword}</strong><br>";
    echo "Please login and change the password immediately.";
} else {
    echo "Users already exist. No action needed.";
}
?>
