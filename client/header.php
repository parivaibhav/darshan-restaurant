<header id="header" class="header d-flex align-items-center sticky-top bg-white" id="main-navbar">
    <div class="container position-relative d-flex align-items-center justify-content-between">

        <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
            <h1 class="sitename text-danger">Darshan Restaurant</h1>
        </a>

        <nav id="navmenu" class="navmenu mx-auto">
            <ul>
                <li><a href="/college/users/index">Home<br></a></li>
                <li><a href="/college/users/aboutus">About</a></li>
                <li><a href="/college/users/menu">Menu</a></li>
                <li><a href="/college/users/contactus">Contact</a></li>
                <li><a href="/college/users/myorder">my order</a></li>
            </ul>
        </nav>
        <i class="mobile-nav-toggle d-xl-none bi bi-list mb-3"></i>
    </div>

    <div class="d-none flex gap-3 d-lg-flex px-4">
        <a>
            <?php
            echo htmlspecialchars($_SESSION['email']);
            ?>
        </a>
        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#logoutModal">
            Logout
        </button>


    </div>
</header>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to log out?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="../includes/logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div>