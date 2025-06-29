<?php
include __DIR__ . '/../includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>User Management</title>
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
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <section id="myorder" class="myorder section py-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">User List</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                    <i class="bi bi-plus-lg"></i> Add Admin
                </button>
            </div>

            <?php
            $sql = "SELECT id, email, user_type FROM users ORDER BY id DESC";
            $result = $conn->query($sql);
            ?>

            <?php if ($result && $result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Email</th>
                                <th>User Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td><?= htmlspecialchars(ucfirst($row['user_type'])) ?></td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- Delete Button Logic -->
                                            <?php if ($row['user_type'] === 'admin'): ?>
                                                <button class="btn btn-danger btn-sm" disabled title="Cannot delete admin users">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            <?php elseif (isset($_COOKIE['user_type']) && $_COOKIE['user_type'] === 'admin'): ?>
                                                <form method="POST" action="../includes/delete_user.php" onsubmit="return confirmDelete(event, this);">
                                                    <input type="hidden" name="user_id" value="<?= (int)$row['id'] ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <button class="btn btn-danger btn-sm" disabled title="Only admin can delete users">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            <?php endif; ?>

                                            <!-- Update Password Button -->
                                            <button class="btn  btn-sm" data-bs-toggle="modal" style="background-color: #fdb833;"
                                                data-bs-target="#updatePasswordModal"
                                                onclick="setUserDataForUpdate(<?= $row['id'] ?>, '<?= $row['email'] ?>')">
                                                Update Password
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center">No users found.</p>
            <?php endif; ?>
        </div>
    </section>

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

    <!-- Modal: Update Password -->
    <div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="updatePasswordLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="../includes/update_password.php" class="modal-content" onsubmit="return validatePasswordMatch();">
                <div class="modal-header">
                    <h5 class="modal-title" id="updatePasswordLabel">Update User Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="updateUserId" name="user_id" />
                    <div class="mb-3">
                        <label for="updateUserEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="updateUserEmail" name="email" disabled />
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="newPassword" name="new_password" oninput="checkStrength()" required />
                            <span class="input-group-text" onclick="togglePassword('newPassword', this)">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                        </div>
                        <small id="strengthMsg" class="form-text text-muted"></small>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirmPassword" oninput="checkStrength()" required />
                            <span class="input-group-text" onclick="togglePassword('confirmPassword', this)">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="updatePasswordBtn" class="btn btn-success" disabled>Update Password</button>
                </div>
            </form>
        </div>
    </div>

    <?php include 'footer.php'; ?>

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
                text: "This will permanently delete the user.",
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

        function setUserDataForUpdate(id, email) {
            document.getElementById('updateUserId').value = id;
            document.getElementById('updateUserEmail').value = email;
            document.getElementById('newPassword').value = "";
            document.getElementById('confirmPassword').value = "";
            const msg = document.getElementById('strengthMsg');
            msg.textContent = "";
            msg.className = "form-text text-muted";
            document.getElementById('updatePasswordBtn').disabled = true;
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

        function checkStrength() {
            const password = document.getElementById("newPassword").value;
            const confirm = document.getElementById("confirmPassword").value;
            const msg = document.getElementById("strengthMsg");
            const updateBtn = document.getElementById("updatePasswordBtn");

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

            updateBtn.disabled = !(minLength && hasSymbol && hasNumber && match);
        }

        function validatePasswordMatch() {
            const pass = document.getElementById("newPassword").value;
            const confirm = document.getElementById("confirmPassword").value;

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