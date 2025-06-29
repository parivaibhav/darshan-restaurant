<?php
session_start();
require_once('db.php'); // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize & collect input
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password_plain = $_POST['password'];
    $user_type = 'user';

    // === Input Validation ===
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['msg'] = ['type' => 'error', 'text' => 'Invalid email format.'];
        header('Location: /college/register');
        exit;
    }

    // Password must be at least 6 characters, contain 1 symbol and 1 number
    $hasSymbol = preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password_plain);
    $hasNumber = preg_match('/\d/', $password_plain);
    if (strlen($password_plain) < 6 || !$hasSymbol || !$hasNumber) {
        $_SESSION['msg'] = ['type' => 'error', 'text' => 'Password must be at least 6 characters with 1 symbol & 1 number.'];
        header('Location: /college/register');
        exit;
    }

    // === Check for duplicate email ===
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $_SESSION['msg'] = ['type' => 'error', 'text' => 'Email already registered.'];
        header('Location: /college/register');
        exit;
    }

    $checkStmt->close();

    // === Register New User ===
    $hashedPassword = password_hash($password_plain, PASSWORD_DEFAULT);
    $insertStmt = $conn->prepare("INSERT INTO users (email, password, user_type) VALUES (?, ?, ?)");
    $insertStmt->bind_param("sss", $email, $hashedPassword, $user_type);

    if ($insertStmt->execute()) {
        $_SESSION['msg'] = ['type' => 'success', 'text' => 'Registration successful!'];
        $_SESSION['email'] = $email;
        $_SESSION['user_type'] = $user['user_type'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['login_time'] = time();

        // Set cookies for a more persistent login (1 day validity)
        setcookie('email', $user['email'], time() + 86400, '/', '', false, true);  // HttpOnly & Secure
        setcookie('user_type', $user['user_type'], time() + 86400, '/', '', false, true);  // HttpOnly & Secure
        setcookie('login_time', time(), time() + 86400, '/', '', false, true);  // HttpOnly & Secure
        header('Location: /college/users/index');
    } else {
        $_SESSION['msg'] = ['type' => 'error', 'text' => 'Registration failed. Please try again.'];
        header('Location: /college/register');
    }

    $insertStmt->close();
    $conn->close();
    exit;
} else {
    // Redirect non-POST requests
    header('Location: /college/register');
    exit;
}
