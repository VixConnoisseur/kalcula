<?php
require 'config.php';
require 'functions.php';
require_login();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Basic strong password validation
    if ($new_password !== $confirm_password) {
        $message = "Passwords do not match";
    } elseif (strlen($new_password) < 8) {
        $message = "Password must be at least 8 characters";
    } else {
        $hash = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ?, first_login = 0 WHERE user_id = ?");
        $stmt->execute([$hash, $_SESSION['user_id']]);
        $message = "Password updated successfully. Redirecting to dashboard...";
        header("Refresh:2; url=dashboard.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Change Password - KALCULA</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-[#1A4B6C] to-[#4AA3DF] flex items-center justify-center h-screen">
    <div class="glass-card p-10 w-full max-w-md shadow-lg">
        <h1 class="text-white text-2xl font-bold mb-6 text-center">Change Password</h1>
        <?php if($message): ?>
            <div class="bg-red-100 text-red-700 p-2 mb-4 rounded text-center"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-white mb-1">New Password</label>
                <input type="password" name="new_password" required class="w-full p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1A4B6C] text-[#3D3B40]" />
            </div>
            <div>
                <label class="block text-white mb-1">Confirm Password</label>
                <input type="password" name="confirm_password" required class="w-full p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1A4B6C] text-[#3D3B40]" />
            </div>
            <button type="submit" class="w-full bg-[#1A4B6C] text-white py-3 rounded-md hover:bg-[#163b53] transition-colors font-semibold">Update Password</button>
        </form>
    </div>
</body>
</html>
