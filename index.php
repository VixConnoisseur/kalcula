<?php
require 'config.php';
require 'functions.php';

// Start session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message = '';

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $message = "Invalid CSRF token.";
    } else {
        $username = trim($_POST['username']);
        $password_input = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user) {
            if (is_locked($user)) {
                $message = "Account locked. Try again later.";
            } elseif (password_verify($password_input, $user['password'])) {
                reset_failed_attempts($pdo, $user['user_id']);
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                session_regenerate_id(true);

                if ($user['first_login']) {
                    header('Location: change_password.php');
                    exit();
                }

                header('Location: dashboard.php');
                exit();
            } else {
                add_failed_attempt($pdo, $user['user_id']);
                if ($user['failed_attempts'] + 1 >= 5) {
                    lock_account($pdo, $user['user_id']);
                    $message = "Account locked due to multiple failed attempts. Try again in 15 minutes.";
                } else {
                    $message = "Invalid username or password";
                }
            }
        } else {
            $message = "Invalid username or password";
        }
    }
}

// Load the login design
include 'login_design.php';
?>
