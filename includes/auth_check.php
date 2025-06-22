<?php $basePath = '/college';

function authCheck($maxSessionTime = 86400)
{
    global $basePath;

    if (!isset($_COOKIE['email']) || !isset($_COOKIE['user_type'])) {
        header("Location: {$basePath}/login");
        exit();
    } else if ($_COOKIE['user_type'] == "admin") {
        header("Location: {$basePath}/admin/index");
        exit();
    } else {
        header("Location: {$basePath}/users/index");
        exit();
    }



    if (isset($_SESSION['login_time'])) {
        if ((time() - $_COOKIE['login_time']) > $maxSessionTime) {
            session_unset();
            session_destroy();

            header("Location: {$basePath}/login?session_expired=1");
            exit();
        } else {
            $_COOKIE['login_time'] = time();
        }
    } else {
        header("Location: {$basePath}/login");
        exit();
    }
}
