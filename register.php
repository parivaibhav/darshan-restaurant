<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Project</title>
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
    <div class="container border border-3  border-light-subtle my-3 rounded-3" style="padding: 90px;">
        <form action="./includes/register.php" method="post" class="needs-validation" novalidate>
            <h1 class="text-center py-2 ">Register Your Account</h1>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control py-3" id="exampleFormControlInput1" placeholder="name@example.com" required>
                <div class="invalid-feedback">Please Enter valid Email Address</div>
            </div>
            <div class="mb-3">
                <label for="inputPassword2" class="mb-2">Password</label>
                <input type="password" class="form-control py-3" id="inputPassword2" placeholder="Password" name="password" required>
                <div class="invalid-feedback">Please Enter valid password</div>
            </div>
            <button class="btn btn-danger w-100 py-3">Register</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>


<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

<!-- Main JS File -->
<script src="assets/js/main.js"></script>
<script src="assets/js/formvalidation.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert CDN -->

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


</body>

</html>