<?php
include __DIR__ . '/../includes/db.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Admin Management</title>
    <link href="../assets/img/logo.png" rel="icon" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="../assets/vendor/aos/aos.css" rel="stylesheet" />
    <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
    <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />
    <link href="../assets/css/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />
    <script src="../assets/js/modetoggle.js" defer></script>
    <style>
        .input-group-text {
            cursor: pointer;
        }
        
        .admin-hero {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 2.5rem 0;
            margin-bottom: 2rem;
        }

        .admin-hero h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .admin-hero p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .admin-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(52, 73, 94, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .admin-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .admin-email {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .admin-type {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
            background: rgba(25, 135, 84, 0.2);
            color: #198754;
        }

        .btn-delete-admin {
            background: linear-gradient(45deg, #dc3545, #fd7e14);
            border: none;
            border-radius: 20px;
            padding: 0.5rem 1.5rem;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .btn-delete-admin:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
            color: white;
        }

        .btn-delete-admin:disabled {
            background: #6c757d;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .btn-add-admin {
            background: linear-gradient(45deg, #2c3e50, #34495e);
            border: none;
            border-radius: 25px;
            padding: 0.75rem 2rem;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-add-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(44, 62, 80, 0.3);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6c757d;
        }

        .empty-icon {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #495057;
        }

        .empty-text {
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .admin-hero h1 {
                font-size: 2rem;
            }

            .admin-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .admin-card {
                padding: 1rem;
            }

            .admin-email {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .admin-hero {
                padding: 2rem 0;
            }

            .admin-hero h1 {
                font-size: 1.75rem;
            }

            .btn-delete-admin,
            .btn-add-admin {
                width: 100%;
                margin-top: 0.5rem;
            }
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <!-- Hero Section -->
    <section class="admin-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1>Admin Management</h1>
                    <p>Manage admin users and permissions</p>
                </div>
                <div class="col-lg-4 text-end">
                    <i class="bi bi-shield-check" style="font-size: 4rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Admin Users</h2>
            <button class="btn btn-add-admin" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                <i class="bi bi-plus-lg"></i> Add Admin
            </button>
        </div>

        <?php
        // Only fetch admin users
        $sql = "SELECT id, email, user_type FROM users WHERE user_type = 'admin' ORDER BY id DESC";
        $result = $conn->query($sql);
        ?>

        <?php if ($result && $result->num_rows > 0): ?>
            <div class="row">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-lg-6 col-md-12">
                        <div class="admin-card">
                            <div class="admin-header">
                                <div>
                                    <div class="admin-email"><?= htmlspecialchars($row['email']) ?></div>

                                </div>
                                <div>
                                    <?php if ($row['email'] === 'parivaibhav@gmail.com'): ?>
                                        <button class="btn btn-delete-admin" disabled title="Cannot delete this admin user">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    <?php else: ?>
                                        <form method="POST" action="../includes/delete_user.php" onsubmit="return confirmDelete(event, this);" class="d-inline">
                                            <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                                            <button type="submit" class="btn btn-delete-admin">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-shield-x"></i>
                </div>
                <h3 class="empty-title">No Admin Users Found</h3>
                <p class="empty-text">No admin users have been created yet. Add the first admin user to get started.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal: Add Admin -->
    <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="../includes/add_admin.php" class="modal-content" onsubmit="return validateAdminPasswordMatch();">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAdminModalLabel">Add Admin User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="adminEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="adminEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="adminPassword" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="adminPassword" name="password" oninput="checkAdminPasswordStrength()" required />
                            <span class="input-group-text" onclick="togglePassword('adminPassword', this)">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                        </div>
                        <small id="adminStrengthMsg" class="form-text text-muted"></small>
                    </div>
                    <div class="mb-3">
                        <label for="adminConfirmPassword" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="adminConfirmPassword" oninput="checkAdminPasswordStrength()" required />
                            <span class="input-group-text" onclick="togglePassword('adminConfirmPassword', this)">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="addAdminBtn" class="btn btn-primary" disabled>Add Admin</button>
                </div>
            </form>
        </div>
    </div>

    <?php include __DIR__ .  '/../footer.php'; ?>

    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <div id="preloader"></div>

    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../assets/js/main.js"></script>

    <script>
        function confirmDelete(event, form) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the admin user.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            return false;
        }

        function togglePassword(inputId, el) {
            const input = document.getElementById(inputId);
            const icon = el.querySelector("i");

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

        function checkAdminPasswordStrength() {
            const password = document.getElementById("adminPassword").value;
            const confirm = document.getElementById("adminConfirmPassword").value;
            const msg = document.getElementById("adminStrengthMsg");
            const addBtn = document.getElementById("addAdminBtn");

            const minLength = password.length >= 3;
            const hasSymbol = /[!@#$%^&*(),.?":{}|<>]/.test(password);
            const hasNumber = /\d/.test(password);
            const match = password === confirm && confirm.length > 0;

            if (minLength && hasSymbol && hasNumber) {
                msg.textContent = "Valid password format.";
                msg.className = "form-text text-primary";
            } else {
                msg.textContent = "Password must be at least 3 characters, contain a symbol and a number.";
                msg.className = "form-text text-danger";
            }

            addBtn.disabled = !(minLength && hasSymbol && hasNumber && match);
        }

        function validateAdminPasswordMatch() {
            const pass = document.getElementById("adminPassword").value;
            const confirm = document.getElementById("adminConfirmPassword").value;

            if (pass !== confirm) {
                Swal.fire({
                    icon: 'error',
                    title: 'Passwords do not match',
                    text: 'Please re-enter matching passwords.',
                });
                return false;
            }
            return true;
        }
    </script>

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
</body>

</html>