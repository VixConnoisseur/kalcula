<?php
// Start session only if it hasn’t started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


// Check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Check user role
function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// Redirect to login if not logged in
function require_login() {
    if (!is_logged_in()) {
        header('Location: index.php');
        exit();
    }
}

// Hash password securely
function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Verify password
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

// Check if account is locked
function is_locked($user) {
    if ($user['locked_until'] && strtotime($user['locked_until']) > time()) {
        return true;
    }
    return false;
}

// Increase failed attempts
function add_failed_attempt($pdo, $user_id) {
    $stmt = $pdo->prepare("UPDATE users SET failed_attempts = failed_attempts + 1 WHERE user_id = ?");
    $stmt->execute([$user_id]);
}

// Lock account for 15 minutes after 5 failed attempts
function lock_account($pdo, $user_id) {
    $lock_time = date('Y-m-d H:i:s', strtotime('+15 minutes'));
    $stmt = $pdo->prepare("UPDATE users SET locked_until = ?, failed_attempts = 0 WHERE user_id = ?");
    $stmt->execute([$lock_time, $user_id]);
}

// Reset failed attempts after successful login
function reset_failed_attempts($pdo, $user_id) {
    $stmt = $pdo->prepare("UPDATE users SET failed_attempts = 0, locked_until = NULL WHERE user_id = ?");
    $stmt->execute([$user_id]);
}

?>
