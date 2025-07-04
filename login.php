
<?php


$showExpiredAlert = false;
if (isset($_GET['session_expired']) && $_GET['session_expired'] == 1) {
    $showExpiredAlert = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Darshan Restaurant | Login</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="assets/img/logo.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

    <script src="assets/js/modetoggle.js" defer></script>

</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body px-5 py-4">
                         <img src="./assets/img/logo.png" alt="logo" width="100" class="d-block mx-auto my-3" />
                        <h2 class="text-center mb-4">Login to Your Account</h2>
                        <form action="includes/login.php" method="post" id="loginForm" class="needs-validation" novalidate>

                            <!-- Email Field -->
                            <div class="mb-3">
                                <label for="useremail" class="form-label">Email address</label>
                                <div class="input-group ">
                                    <input type="email" class="form-control" id="useremail" name="useremail" placeholder="name@example.com" required>
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                            </div>

                            <!-- Password Field -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group ">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <div class="invalid-feedback">Password is required.</div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-danger">Login</button>
                            </div>

                            <!-- Register Link -->
                            <div class="text-center">
                                <p class="mb-0" style="font-size:clamp(0.95rem, 2vw, 1.1rem);">
                                    Don't have an account?
                                    <a href="register" class="text-danger" style="font-size:inherit;">Register here</a>
                                </p>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include 'footer.php'; ?>
    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert CDN -->


    <?php if (isset($_GET['session_expired']) && $_GET['session_expired'] == 1):
    ?>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Session Expired',
                text: 'Your session has expired. Please log in again.',
                confirmButtonText: 'OK'
            });
        </script>
    <?php endif; ?>

    <?php if (isset($_SESSION['msg'])): ?>
        <script>
            Swal.fire({
                icon: '<?= $_SESSION['msg']['type'] ?>', // 'success', 'error', etc.
                title: '<?= $_SESSION['msg']['text'] ?>',
                showConfirmButton: false,
                timer: 2500
            });
        </script>
        <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>

    <script src="assets/js/formvalidation.js"></script>

</body>

</html>