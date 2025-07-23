<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/db.php';        // defines $conn (mysqli)
require_once __DIR__ . '/auth_check.php'; // defines encrypt(), SECRET_KEY, routeAfterLogin()

/* Only accept POST  */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /college/login');
    exit();
}

/* Input validation */
$userEmail = trim($_POST['useremail'] ?? '');
$password  = $_POST['password'] ?? '';

if ($userEmail === '' || $password === '') {
    $_SESSION['msg'] = ['type' => 'error', 'text' => 'Email and password are required'];
    header('Location: /college/login');
    exit();
}

/*  Fetch user with a prepared statement  */
$stmt = $conn->prepare('SELECT email, password, user_type FROM users WHERE email = ? LIMIT 1');
if (!$stmt) {
    $_SESSION['msg'] = ['type' => 'error', 'text' => 'Database error'];
    header('Location: /college/login');
    exit();
}

$stmt->bind_param('s', $userEmail);
$stmt->execute();
$result = $stmt->get_result();
$user   = $result->fetch_assoc();
$stmt->close();

/*  Verify credentials  */
if (!$user || !password_verify($password, $user['password'])) {
    $_SESSION['msg'] = ['type' => 'error', 'text' => 'Invalid credentials'];
    header('Location: /college/login');
    exit();
}

/*  Successful login  */
$now          = time();
$cookieMaxAge = 86400; // 24 h

setcookie('email',      encrypt($user['email'],     SECRET_KEY), $now + $cookieMaxAge, '/', '', false, true);
setcookie('user_type',  encrypt($user['user_type'], SECRET_KEY), $now + $cookieMaxAge, '/', '', false, true);
setcookie('login_time', encrypt((string) $now,      SECRET_KEY), $now + $cookieMaxAge, '/', '', false, true);

$_SESSION['msg'] = ['type' => 'success', 'text' => 'Login successful!'];

/*  Redirect based on role  */
routeAfterLogin($user['user_type']);
