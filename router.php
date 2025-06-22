<?php
session_start();
ini_set('memory_limit', '1024M');

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = '/college';
if (strpos($request_uri, $base) === 0) {
    $request_uri = substr($request_uri, strlen($base));
}
$request_uri = trim($request_uri, '/');




function authCheck()
{
    if (!isset($_COOKIE['email']) || !isset($_COOKIE['user_type'])) {
        header('Location: /college/login');
        exit();
    } 
}


switch ($request_uri) {
    // Public routes
    case '':
    case 'home':
    case 'index.php':
    case 'aboutus':
    case 'menu':
    case 'contactus':
    case 'login':
    case 'register':

        require __DIR__ . "/$request_uri.php";
        break;

    // User routes (auth required)
    case 'users/index':
    case 'users/menu':
    case 'users/aboutus':
    case 'users/myorder':
    case 'users/contactus':

        authCheck();
        require __DIR__ . "/client/" . basename($request_uri) . ".php";
        break;

    // Admin routes (auth required)
    case 'admin/index':
    case 'admin/menu':
    case 'admin/myorder':
    case 'admin/users':
    case 'admin/bookings':
        authCheck();
        require __DIR__ . "/admin/" . basename($request_uri) . ".php";
        break;

    // Default 404
    default:
        http_response_code(404);
        require __DIR__ . '/404.php';
        break;
}
