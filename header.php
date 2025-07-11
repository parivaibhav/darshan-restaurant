<?php
require_once __DIR__ . '/includes/auth_check.php';

$userType = null;

if (isset($_COOKIE['user_type'])) {
    $userType = decrypt($_COOKIE['user_type'], SECRET_KEY);
}

if ($userType === 'admin') {
    header('Location: /college/admin/index');
    exit();
}

if ($userType === 'user') {
    header('Location: /college/users/index');
    exit();
}


?>

<style>
    .btn-grp {
        width: 30% !important;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1rem;
    }

    .custom-signup-btn {
        background-color: #000 !important;
        border-color: #000 !important;
        color: #fff !important;
        padding: 0.4rem 0.8rem !important;
        font-size: 0.9rem !important;
        border-radius: 7px;

    }

    .custom-signup-btn:hover,
    .custom-signup-btn:focus {
        background-color: #222 !important;
        border-color: #222 !important;
        color: #fff !important;
    }
</style>
<header id="header" class="header d-flex align-items-center sticky-top bg-body-tertiary" id="main-navbar">
    <div class="container position-relative d-flex align-items-center justify-content-between px-5">
        <a href="/college/" class="logo d-flex align-items-center me-auto me-xl-0">
            <h1 class="sitename d-none d-lg-block text-danger w-100">Darshan Restaurant</h1>
        </a>
        <nav id="navmenu" class="navmenu mx-auto">
            <ul>
                <li><a href="/college/">Home</a></li>
                <li><a href="aboutus">About</a></li>
                <li><a href="menu">Menu</a></li>
                <li><a href="contactus">Contact</a></li>

            </ul>
        </nav>



        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </div>
    <div class=" d-flex justify-content-center align-items-center " style="width:30%; word-wrap: inherit; ">
        <a class="d-none d-xl-flex btn-sm custom-signup-btn ms-2" href="/college/register" style="font-size:clamp(0.85rem, 2vw, 1.1rem);">Sign up</a>
        <div class="login-box">
            <button class="login-btn" onclick="window.location.href='/college/login'">
                Login
                <div class="star-1">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        xml:space="preserve"
                        version="1.1"
                        style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                        viewBox="0 0 784.11 815.53"
                        xmlns:xlink="http://www.w3.org/1999/xlink">
                        <defs></defs>
                        <g id="Layer_x0020_1">
                            <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                            <path
                                class="fil0"
                                d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z"></path>
                        </g>
                    </svg>
                </div>
                <div class="star-2">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        xml:space="preserve"
                        version="1.1"
                        style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                        viewBox="0 0 784.11 815.53"
                        xmlns:xlink="http://www.w3.org/1999/xlink">
                        <defs></defs>
                        <g id="Layer_x0020_1">
                            <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                            <path
                                class="fil0"
                                d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z"></path>
                        </g>
                    </svg>
                </div>
                <div class="star-3">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        xml:space="preserve"
                        version="1.1"
                        style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                        viewBox="0 0 784.11 815.53"
                        xmlns:xlink="http://www.w3.org/1999/xlink">
                        <defs></defs>
                        <g id="Layer_x0020_1">
                            <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                            <path
                                class="fil0"
                                d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z"></path>
                        </g>
                    </svg>
                </div>
                <div class="star-4">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        xml:space="preserve"
                        version="1.1"
                        style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                        viewBox="0 0 784.11 815.53"
                        xmlns:xlink="http://www.w3.org/1999/xlink">
                        <defs></defs>
                        <g id="Layer_x0020_1">
                            <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                            <path
                                class="fil0"
                                d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z"></path>
                        </g>
                    </svg>
                </div>
                <div class="star-5">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        xml:space="preserve"
                        version="1.1"
                        style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                        viewBox="0 0 784.11 815.53"
                        xmlns:xlink="http://www.w3.org/1999/xlink">
                        <defs></defs>
                        <g id="Layer_x0020_1">
                            <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                            <path
                                class="fil0"
                                d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z"></path>
                        </g>
                    </svg>
                </div>
                <div class="star-6">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        xml:space="preserve"
                        version="1.1"
                        style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                        viewBox="0 0 784.11 815.53"
                        xmlns:xlink="http://www.w3.org/1999/xlink">
                        <defs></defs>
                        <g id="Layer_x0020_1">
                            <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                            <path
                                class="fil0"
                                d="M392.05 0c-20.9,210.08 -184.06,378.41 -392.05,407.78 207.96,29.37 371.12,197.68 392.05,407.74 20.93,-210.06 184.09,-378.37 392.05,-407.74 -207.98,-29.38 -371.16,-197.69 -392.06,-407.78z"></path>
                        </g>
                    </svg>
                </div>
            </button>
        </div>

    </div>
</header>

<!-- Rest of your homepage content -->