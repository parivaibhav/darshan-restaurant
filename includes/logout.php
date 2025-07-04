<?php
session_start();

// Clear all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Remove session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600, $params["path"], $params["domain"]);
}

// Remove your custom cookies
setcookie('email', '', time() - 3600, '/');
setcookie('user_type', '', time() - 3600, '/');
setcookie('login_time', '', time() - 3600, '/');

// Optionally unset from $_COOKIE superglobal (not required, but can help)
unset($_COOKIE['email'], $_COOKIE['user_type'], $_COOKIE['login_time']);

// Redirect to login page
header("Location: /college/login");
exit;
?>
