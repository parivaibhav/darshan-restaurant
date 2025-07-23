<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Darshan Restaurant | Register</title>

    <!-- Favicons -->
    <link href="assets/img/logo.png" rel="icon">

    <!-- Fonts & Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets/css/main.css" rel="stylesheet">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow rounded-4 p-4">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Register Your Account</h2>

                        <form action="./includes/register.php" method="post" class="needs-validation" novalidate onsubmit="return validateForm()">

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <div class="input-group">
                                
                                    <input type="email" name="email" id="email" class="form-control" placeholder="name@example.com" required>
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                            </div>


                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" oninput="checkPasswordStrength()" required>
                                    <span class="input-group-text" onclick="togglePassword('password', this)">
                                        <i class="bi bi-eye-slash"></i>
                                    </span>
                                </div>
                                <small id="passwordStrength" class="form-text text-muted mt-1"></small>
                            </div>

                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Confirm Password" required>
                                    <span class="input-group-text" onclick="togglePassword('confirmPassword', this)">
                                        <i class="bi bi-eye-slash"></i>
                                    </span>
                                </div>
                                <div class="invalid-feedback">Passwords must match.</div>
                            </div>

                            <div class="d-grid mt-3">
                                <button type="submit" class="btn btn-danger">Register</button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <p>Already have an account? <a href="login" class="text-danger">Login here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Scripts -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Session Message Alert -->
    <?php if (isset($_SESSION['msg'])): ?>
        <script>
            Swal.fire({
                icon: '<?= $_SESSION['msg']['type'] ?>',
                title: '<?= $_SESSION['msg']['text'] ?>',
                showConfirmButton: false,
                timer: 2500
            });
        </script>
        <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>

    <!-- Password Validation Scripts -->
    <script>
        function togglePassword(fieldId, toggleIcon) {
            const input = document.getElementById(fieldId);
            const icon = toggleIcon.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            } else {
                input.type = "password";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            }
        }

        function checkPasswordStrength() {
            const password = document.getElementById('password').value.trim();
            const strengthMsg = document.getElementById('passwordStrength');

            const isLongEnough = password.length >= 3;
            const hasSymbol = /[!@#$%^&*(),.?":{}|<>]/.test(password);
            const hasNumber = /\d/.test(password);

            if (isLongEnough && hasSymbol && hasNumber) {
                strengthMsg.textContent = "valid password";
                strengthMsg.classList.remove("text-danger");
                strengthMsg.classList.add("text-primary");
            } else {
                strengthMsg.textContent = "Min 3 chars, 1 symbol, 1 number required.";
                strengthMsg.classList.remove("text-primary");
                strengthMsg.classList.add("text-danger");
            }
        }

        document.getElementById('confirmPassword').addEventListener('input', function() {
            const pass = document.getElementById('password').value;
            const confirmPass = this.value;

            if (confirmPass && pass !== confirmPass) {
                this.classList.add("is-invalid");
            } else {
                this.classList.remove("is-invalid");
            }
        });

        function validateForm() {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const confirmPassword = document.getElementById('confirmPassword').value.trim();
            const strengthMsg = document.getElementById('passwordStrength');

            const isLongEnough = password.length >= 3;
            const hasSymbol = /[!@#$%^&*(),.?":{}|<>]/.test(password);
            const hasNumber = /\d/.test(password);

            if (!email) {
                Swal.fire({
                    icon: 'error',
                    title: 'Email Required',
                    text: 'Please enter your email address.',
                });
                return false;
            }

            if (!isLongEnough || !hasSymbol || !hasNumber) {
                strengthMsg.textContent = "Min 3 chars, 1 symbol, 1 number required.";
                strengthMsg.classList.remove("text-primary");
                strengthMsg.classList.add("text-danger");

                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Password',
                    text: 'Min 3 chars, 1 symbol, 1 number required.',
                });
                return false;
            }

            if (password !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Passwords Do Not Match',
                    text: 'Make sure both password fields match.',
                });
                return false;
            }

            return true;
        }
    </script>

    <script src="./assets/js/main.js"></script>
</body>

</html>