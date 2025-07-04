<?php
require_once __DIR__ . '/../includes/auth_check.php';
$user = requireLogin();
$email = $user['email'];

 // redirect → /login if not logged in
/* ---------- role gate ---------- */
if ($user['userType'] !== 'admin') {
    header('Location: ' . ($user['userType'] === 'user'
        ? '/college/users/index' : '/college/login'));
    exit();
}


?>




<header id="header" class="header d-flex align-items-center sticky-top bg-white " id="main-navbar">
    <div class="container position-relative d-flex align-items-center justify-content-between">

        <a href="/college/admin/index" class="logo d-flex align-items-center me-auto me-xl-0">
            <h1 class="sitename text-danger">Darshan Restaurant</h1>
        </a>

        <nav id="navmenu" class="navmenu mx-auto">
            <ul>
                <li><a href="/college/admin/index">Home</a></li>
                <li><a href="/college/admin/menu">Menu</a></li>
                <li><a href="/college/admin/users">Users</a></li>
                <li><a href="/college/admin/myorder">Orders</a></li>
                <li><a href="/college/admin/bookings">Bookings</a></li>
            </ul>
        </nav>

        <i class="mobile-nav-toggle d-xl-none bi bi-list mb-3"></i>
    </div>
    <div class="login-box">
        <a class="btn btn-danger btn-sm" href="../includes/logout.php">Logout</a>
    </div>
</header>