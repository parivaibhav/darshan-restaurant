<?php $basePath = '/college';

function authCheck($maxSessionTime = 86400)
{
    global $basePath;

    if (!isset($_SESSION['email']) || !isset($_SESSION['user_type'])) {
        header("Location: {$basePath}/login");
        exit();
    }

    if (isset($_SESSION['login_time'])) {
        if ((time() - $_SESSION['login_time']) > $maxSessionTime) {
            session_unset();
            session_destroy();

            header("Location: {$basePath}/login?session_expired=1");
            exit();
        } else {
            $_SESSION['login_time'] = time();
        }
    } else {
        header("Location: {$basePath}/login");
        exit();
    }
}
